<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class YoutubeController extends Controller
{
    public function search(Request $request)
    {
        $apiKey = 'AIzaSyAuOqEP9aTNvYxClOKWyvk_OLRYaEkJoiA';
        $searchTerm = $request->input('q');

        $response = Http::get('https://www.googleapis.com/youtube/v3/search', [
            'key' => $apiKey,
            'part' => 'snippet',
            'type' => 'video',
            'q' => $searchTerm,
        ]);

        return $response->json();
    }
}

