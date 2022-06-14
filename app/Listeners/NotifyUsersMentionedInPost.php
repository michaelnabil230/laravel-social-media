<?php

namespace App\Listeners;

use App\Events\PostCreatedEvent;
use App\Notifications\MentionPostNotification;

class NotifyUsersMentionedInPost
{
    /**
     * Handle the event.
     *
     * @param  PostCreatedEvent  $event
     * @return void
     */
    public function handle(PostCreatedEvent $event)
    {
        $event->post->mentionedUsers()->each(function ($user) use ($event) {
            $user->notify(new MentionPostNotification($event->post));
        });
    }
}
