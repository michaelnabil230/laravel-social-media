<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'is_admin',
        'bio',
        'banned_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'banned_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    /**
     * Set the user's Hash password.
     *
     * @return Attribute
     */
    protected function password(): Attribute
    {
        return Attribute::set(fn ($value) => Hash::make($value));
    }

    /**
     * Get the user's isBanned.
     *
     * @return Attribute
     */
    protected function isBanned(): Attribute
    {
        return Attribute::get(fn () => !is_null($this->banned_at));
    }

    /**
     * Get all of the communities for the User
     *
     * @return HasMany
     */
    public function communities(): HasMany
    {
        return $this->hasMany(Community::class);
    }

    /**
     * The joinCommunities that belong to the User
     *
     * @return BelongsToMany
     */
    public function joinCommunities(): BelongsToMany
    {
        return $this->belongsToMany(Community::class);
    }

    /**
     * Get all of the posts for the User
     *
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get all of the comments for the User
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
