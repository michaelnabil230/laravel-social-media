<?php

namespace App\Listeners;

use App\Events\PostEvent;
use App\Notifications\MentionPostNotification;

class NotifyUsersMentionedInPost
{
    /**
     * Handle the event.
     *
     * @param  PostEvent  $event
     * @return void
     */
    public function handle(PostEvent $event)
    {
        $event->post->mentionedUsers()->each(function ($user) use ($event) {
            $user->notify(new MentionPostNotification($event->post));
        });
    }
}
