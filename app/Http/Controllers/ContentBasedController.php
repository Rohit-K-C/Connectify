<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentBasedController extends Controller
{
    public function generateContentBasedRecommendations()
    {
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
        return view('recommended_posts', ['recommendedPosts' => $recommendedPosts]);
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
