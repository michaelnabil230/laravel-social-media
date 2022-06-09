<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController 
{
    public function __invoke()
    {
        $posts = Post::query()
            ->with('community')
            ->withCount(['postVotes' => function ($query) {
                $query->where('post_votes.created_at', '>', now()->subDays(7))->where('vote', 1);
            }])
            ->latest('post_votes_count')
            ->take(10)
            ->get();

        return view('home', compact('posts'));
    }
}
