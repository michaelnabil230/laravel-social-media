<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'from_id',
        'community_id',
        'body',
    ];

    /**
     * Get the user that owns the Message
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    /**
     * Get the community that owns the Message
     *
     * @return BelongsTo
     */
    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    public function mentionedUsers(): Collection
    {
        preg_match_all('/@([a-z\d](?:[a-z\d]|-(?=[a-z\d])){0,38}(?!\w))/', $this->body, $matches);

        return User::whereIn('username', $matches[1])->get();
    }
}
