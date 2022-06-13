<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    const CREATE = 'create';

    const UPDATE = 'update';

    const DELETE = 'delete';

    /**
     * Determine if the given comment can be updated by the user.
     */
    public function update(User $user, Comment $comment): bool
    {
        return $comment->user_id == $user->id || $user->is_admin;
    }

    /**
     * Determine if the given comment can be deleted by the user.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $comment->user_id == $user->id || $user->is_admin;
    }
}
