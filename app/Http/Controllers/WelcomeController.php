<?php

namespace App\Http\Controllers;

use App\Models\Post;

class WelcomeController extends Controller
{
    public function index()
    {
        $posts = Post::where('active', 1)
                     ->where('approved', 1)
                     ->orderBy('created_at', 'desc') // Show the most recent posts first
                     ->get();
                     
        return view('welcome', ['posts' => $posts]); // Pass the posts to the view
    }
    
}
