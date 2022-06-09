<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostCommentController
{
    public function __invoke(Request $request, Post $post)
    {
        $request->validate([
            'comment' => ['required', 'string', 'max:255'],
        ]);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        return to_route('communities.posts.show', $post);
    }
}
