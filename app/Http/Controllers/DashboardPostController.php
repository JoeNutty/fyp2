<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class DashboardPostController extends Controller
{
    public function index()
    {
        // Get the authenticated user
        $user = auth()->user();

        if ($user->role === 'admin') {
            // If the user is an admin, return all posts
            return PostResource::collection(Post::latest()->get());
        } else {
            // If the user is not an admin, return only their posts
            return PostResource::collection(Post::where('user_id', $user->id)->latest()->get());
        }
    }
}
