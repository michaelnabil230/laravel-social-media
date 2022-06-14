<?php

namespace App\Listeners;

use App\Events\CommentCreatedEvent;
use App\Notifications\MentionCommentNotification;

class NotifyUsersMentionedInComment
{
    /**
     * Handle the event.
     *
     * @param  CommentCreatedEvent $event
     * @return void
     */
    public function handle(CommentCreatedEvent $event)
    {
        $event->comment->mentionedUsers()->each(function ($user) use ($event) {
            $user->notify(new MentionCommentNotification($event->comment));
        });
    }
}
