<?php

namespace App\Models;

use App\Models\Comment;
use App\Models\PostVote;
use App\Models\Community;
use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'post',
        'image',
        'url',
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
}
