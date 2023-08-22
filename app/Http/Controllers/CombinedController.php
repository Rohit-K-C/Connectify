<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CombinedController extends Controller
{
    public function index()
    {
        if (!session()->has('user_id')) {
            return redirect('/login');
        } else {
            if (Auth::check()) {
                $user = Auth::user();
                $userId = $user->id;
            }

            $likesData = Like::pluck('total_likes', 'post_id')->toArray();

            $commentsData = Comment::pluck('total_comments', 'post_id')->map(fn ($value) => $value ?? 0)->toArray();

            $posts = Post::with('comments')->get();
            $posts->load('user.profileImage');

            $targetUser = Auth::user();
            $likedPosts = $targetUser->likedPosts;
            $userProfile = [];
            foreach ($likedPosts as $post) {
                $contentFeatures = $this->extractContentFeatures($post->post_info);
                $userProfile = array_merge($userProfile, $contentFeatures);
            }

            $allPosts = Post::whereNotIn('post_id', $likedPosts->pluck('post_id'))->get();
            $recommendedPosts = [];
            $threshold = 0.1;
            foreach ($allPosts as $post) {
                $contentFeatures = $this->extractContentFeatures($post->post_info);
                $similarity = $this->calculateSimilarity($userProfile, $contentFeatures);
                if ($similarity > $threshold) {
                    $recommendedPosts[] = ['post' => $post, 'similarity' => $similarity];
                }
            }
            $topN = 10;
            $recommendedPosts = array_slice($recommendedPosts, 0, $topN);

            //loading emojis
            $apiKey = '7d0db8ddb8ad6c5d21771f69a48c047247440847';
            $response = Http::get("https://emoji-api.com/emojis", [
                'access_key' => $apiKey,
            ]);
            $emojis = $response->json();

            //userbased
            $user_based = $this->generateUsersRecommendation(2);
            // dd($user_based);
            return view('homepage', [
                'posts' => $posts,
                'likesData' => $likesData,
                'commentsData' => $commentsData,
                'user' => $user,
                'recommendedPosts' => $recommendedPosts,
                'emojis' => $emojis,
                'user_based' =>$user_based
            ]);
        }
    }

    private function extractContentFeatures($text)
    {

        $tokens = explode(' ', strtolower($text));
        $filteredTokens = array_filter($tokens, function ($token) {
            return !in_array($token, ['and', 'the', 'is', 'of', 'a', ',', '.', '!', '?']);
        });
        $tokenCounts = array_count_values($filteredTokens);
        $totalTokens = count($filteredTokens);
        $normalizedFeatures = [];
        foreach ($tokenCounts as $token => $count) {
            $normalizedFeatures[$token] = $count / $totalTokens;
        }
        return $normalizedFeatures;
    }

    private function calculateSimilarity($featuresA, $featuresB)
    {
        $dotProduct = 0;
        $magnitudeA = 0;
        $magnitudeB = 0;
        foreach ($featuresA as $feature => $valueA) {
            if (isset($featuresB[$feature])) {
                $dotProduct += $valueA * $featuresB[$feature];
            }
            $magnitudeA += pow($valueA, 2);
        }
        foreach ($featuresB as $valueB) {
            $magnitudeB += pow($valueB, 2);
        }
        $magnitudeA = sqrt($magnitudeA);
        $magnitudeB = sqrt($magnitudeB);
        if ($magnitudeA == 0 || $magnitudeB == 0) {
            return 0;
        }
        $similarity = $dotProduct / ($magnitudeA * $magnitudeB);
        return $similarity;
    }

    public function calculateUserSimilarities()
    {
        $users = User::all();
        foreach ($users as $user) {
            foreach ($users as $otherUser) {
                if ($user->id !== $otherUser->id) {
                    $similarity = $this->calculateUserSimilarity($user, $otherUser);
                    DB::table('user_similarities')->updateOrInsert(
                        ['user_id' => $user->id, 'similar_user_id' => $otherUser->id],
                        ['similarities' => $similarity]
                    );
                }
            }
        }
    }


    private function calculateUserSimilarity($userA, $userB)
    {
        $likedPostsA = $userA->likedPosts()->pluck('posts.post_id')->toArray();
        $likedPostsB = $userB->likedPosts()->pluck('posts.post_id')->toArray();
        $commentedPostsA = $userA->commentedPosts()->pluck('posts.post_id')->toArray();
        $commentedPostsB = $userB->commentedPosts()->pluck('posts.post_id')->toArray();
        $allPosts = array_unique(array_merge($likedPostsA, $likedPostsB, $commentedPostsA, $commentedPostsB));
        $dotProduct = 0;
        $magnitudeA = 0;
        $magnitudeB = 0;

        foreach ($allPosts as $postId) {
            $likeA = in_array($postId, $likedPostsA) ? 1 : 0;
            $likeB = in_array($postId, $likedPostsB) ? 1 : 0;
            $commentA = in_array($postId, $commentedPostsA) ? 1 : 0;
            $commentB = in_array($postId, $commentedPostsB) ? 1 : 0;

            $dotProduct += $likeA * $likeB + $commentA * $commentB;
            $magnitudeA += pow($likeA, 2) + pow($commentA, 2);
            $magnitudeB += pow($likeB, 2) + pow($commentB, 2);
        }

        $magnitudeA = sqrt($magnitudeA);
        $magnitudeB = sqrt($magnitudeB);

        if ($magnitudeA == 0 || $magnitudeB == 0) {
            return 0;
        }

        $similarity = $dotProduct / ($magnitudeA * $magnitudeB);
        return $similarity;
    }



    public function generateUsersRecommendation($userId)
    {
        $user = User::find($userId);
        $userSimilarities = DB::table('user_similarities')
            ->where('user_id', $user->id)
            ->pluck('similarities', 'similar_user_id');

        $recommendedPosts = [];
        foreach ($userSimilarities as $similarUserId => $similarity) {
            $similarUser = User::find($similarUserId);
            if ($similarUser) {
                $interactedPosts = $similarUser->likedPosts()
                    ->select('posts.post_id')
                    ->join('likes as similar_likes', 'posts.post_id', '=', 'similar_likes.post_id')
                    ->where('similar_likes.user_id', $similarUser->id)
                    ->pluck('posts.post_id');

                $unseenInteractedPosts = $interactedPosts->diff(
                    $user->likedPosts()->pluck('posts.post_id')->toArray()
                )->diff(
                    $user->commentedPosts()->pluck('posts.post_id')->toArray()
                );

                $recommendedPosts = array_merge($recommendedPosts, $unseenInteractedPosts->toArray());
            }
        }

        $topN = 10;
        $recommendedPosts = array_slice(array_unique($recommendedPosts), 0, $topN);
        $recommendedPostsData = Post::whereIn('post_id', $recommendedPosts)->get();
        return $recommendedPostsData;
        // return view('calculate-similarities', ['recommendedPosts' => $recommendedPostsData]);
    }
}
