<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\Post;

class HomeController
{
    public function __invoke()
    {
        $communities = Community::withCount('posts')->get();
        $posts = Post::normal()->take(10)->get();

        return view('welcome', compact('communities', 'posts'));
    }
}
