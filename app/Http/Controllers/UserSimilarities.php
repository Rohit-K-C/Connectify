<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class UserSimilarities extends Controller
{

    public function calculateUserSimilarities()
    {
        $users = User::all();
        foreach ($users as $user) {
            $similarities = [];
            foreach ($users as $otherUser) {
                if ($user->id === $otherUser->id) {
                    continue;
                }
                $similarity = $this->calculateSimilarity($user, $otherUser);
                $similarities[$otherUser->id] = $similarity;
            }
            foreach ($similarities as $similarUserId => $similarity) {
                DB::table('user_similarities')->updateOrInsert(
                    ['user_id' => $user->id, 'similar_user_id' => $similarUserId],
                    ['similarities' => json_encode([$similarUserId => $similarity])]
                );
            }
        }
    }


    private function calculateSimilarity($userA, $userB)
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

        DB::table('user_similarities')->updateOrInsert(
            ['user_id' => $userA->id, 'similar_user_id' => $userB->id],
            ['similarities' => json_encode([$userB->id => $similarity])]
        );

        DB::table('user_similarities')->updateOrInsert(
            ['user_id' => $userB->id, 'similar_user_id' => $userA->id],
            ['similarities' => json_encode([$userA->id => $similarity])]
        );
        return $similarity;
    }


    public function generateRecommendations($userId)
    {
        $user = User::find($userId);
        $userSimilarities = DB::table('user_similarities')
            ->where('user_id', $user->id)
            ->pluck('similarities', 'similar_user_id');
        $recommendedPosts = [];
        foreach ($userSimilarities as $similarUserId => $similarityJson) {
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
        return view('calculate-similarities', ['recommendedPosts' => $recommendedPostsData]);
    }
}
