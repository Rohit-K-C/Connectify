<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EmojiController extends Controller
{
    public function getEmojis()
    {
        $apiKey = '7d0db8ddb8ad6c5d21771f69a48c047247440847'; 
        $response = Http::get("https://emoji-api.com/emojis", [
            'access_key' => $apiKey,
        ]);

        $emojis = $response->json();

        return view('emojis', compact('emojis'));
    }
}
