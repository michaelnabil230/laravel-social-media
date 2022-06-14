<?php

namespace App\Models;

use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'community_id',
        'user_id',
        'title',
        'body',
        'votes',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        self::observe(PostObserver::class);
    }

    /**
     * Get the community that owns the Post
     *
     * @return BelongsTo
     */
    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    /**
     * Get all of the postVotes for the Post
     *
     * @return HasMany
     */
    public function postVotes(): HasMany
    {
        return $this->hasMany(PostVote::class);
    }

    /**
     * Get all of the comments for the Post
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }

    /**
     * Get the user that owns the Post
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeNormal($query)
    {
        return $query
            ->with(['community', 'user:id,name,username'])
            ->withCount(['comments', 'postVotes' => function ($query) {
                $query->where('post_votes.created_at', '>', now()->subDays(7))->where('vote', 1);
            }])
            ->latest('post_votes_count');
    }

    public function mentionedUsers(): Collection
    {
        preg_match_all('/@([a-z\d](?:[a-z\d]|-(?=[a-z\d])){0,38}(?!\w))/', $this->body, $matches);

        return User::whereIn('username', $matches[1])->get();
    }
}
