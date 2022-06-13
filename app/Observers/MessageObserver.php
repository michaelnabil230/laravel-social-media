<?php

namespace App\Observers;

use App\Models\Message;
use Illuminate\Support\Facades\Storage;

class MessageObserver
{
    /**
     * Handle the Message "deleting" event.
     *
     * @param  \App\Models\Message  $message
     * @return void
     */
    public function deleting(Message $message)
    {
        if ($message->from_id == auth()->id()) {
            if (! is_null($message->attachment)) {
                if (Storage::exists($message->attachment)) {
                    Storage::delete($message->attachment);
                }
            }
        }
    }
}
