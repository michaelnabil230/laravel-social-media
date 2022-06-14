<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    const UPDATE = 'update';

    const DELETE = 'delete';

    const REPORT = 'report';

    public function update(User $user, Post $post): bool
    {
        return $post->user_id == $user->id || $user->is_admin;
    }

    public function delete(User $user, Post $post): bool
    {
        return $post->user_id == $user->id || $user->is_admin;
    }

    public function report(User $user, Post $post): bool
    {
        return $post->user_id != $user->id;
    }
}
