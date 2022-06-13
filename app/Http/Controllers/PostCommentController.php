<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Http\Requests\UpdateCommentRequest;

class PostCommentController extends Controller
{
    public function store(UpdateCommentRequest $request, Post $post)
    {
        $post->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        $this->success('Comment add successfully.');

        return to_route('posts.show', $post);
    }

    public function delete(Post $post, Comment $comment)
    {
        $comment->delete();

        $this->success('Comment deleted successfully.');

        return to_route('posts.show', $post);
    }
}
