<?php

namespace App\Models;

use App\Observers\MessageObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        self::observe(MessageObserver::class);
    }

    /**
     * Default fetch messages query between a Sender and Receiver.
     *
     * @param string $userId
     * @return Message|\Illuminate\Database\Eloquent\Builder
     */
    public function scopeFetchMessages($userId)
    {
        return self::query()
            ->where('from_id', auth()->id())
            ->where('to_id', $userId)
            ->orWhere('from_id', $userId)
            ->where('to_id', auth()->id());
    }

    /**
     * Make messages between the sender [Auth user] and
     * the receiver [User id] as seen.
     *
     * @param string $userId
     * @return bool
     */
    public static function makeSeen($userId)
    {
        return self::Where('from_id', $userId)
            ->where('to_id', auth()->id())
            ->where('seen', 0)
            ->update(['seen' => 1]);
    }
}
