<?php

namespace App\Listeners;

use App\Events\CommentEvent;
use App\Notifications\MentionCommentNotification;

class NotifyUsersMentionedInComment
{
    /**
     * Handle the event.
     *
     * @param  CommentEvent $event
     * @return void
     */
    public function handle(CommentEvent $event)
    {
        $event->comment->mentionedUsers()->each(function ($user) use ($event) {
            $user->notify(new MentionCommentNotification($event->comment));
        });
    }
}
