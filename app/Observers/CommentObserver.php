<?php

namespace App\Observers;

use App\Models\Comment;

class CommentObserver
{
    /**
     * Handle the Comment "created" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function created(Comment $comment)
    {
        event(new \App\Events\CommentEvent($comment));

        $comment->user->notify(new \App\Notifications\CommentCreated($comment));
    }
}
