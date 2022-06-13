<?php

namespace App\Policies;

use App\Models\Community;
use App\Models\User;

class CommunityPolicy
{
    const UPDATE = 'update';

    const DELETE = 'delete';

    const JOIN = 'join';

    const LEAVE = 'leave';

    public function update(User $user, Community $community): bool
    {
        return $community->user_id == $user->id || $user->is_admin;
    }

    public function delete(User $user, Community $community): bool
    {
        return $community->user_id == $user->id || $user->is_admin;
    }

    public function join(User $user, Community $community): bool
    {
        return ! $community->users()->where('user_id', $user->id)->exists();
    }

    public function leave(User $user, Community $community): bool
    {
        return $community->users()->where('user_id', $user->id)->exists();
    }
}
