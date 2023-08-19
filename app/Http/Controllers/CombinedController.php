<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

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
            return view('homepage', [
                'posts' => $posts,
                'likesData' => $likesData,
                'commentsData' => $commentsData,
                'user' => $user,
                'recommendedPosts' => $recommendedPosts,
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
}
