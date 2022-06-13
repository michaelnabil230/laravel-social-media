<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    const ADMIN = 'admin';

    const BAN = 'ban';

    const DELETE = 'delete';

    public function admin(User $user): bool
    {
        return $user->is_admin;
    }

    public function ban(User $user, User $subject): bool
    {
        return $user->is_admin && !$subject->is_admin;
    }

    public function delete(User $user, User $subject): bool
    {
        return ($user->is_admin || $user->is($subject)) && !$subject->is_admin;
    }
}
