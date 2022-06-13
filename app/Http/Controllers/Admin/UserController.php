<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Policies\UserPolicy;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate();

        return view('admin.users', compact('users'));
    }

    public function ban(User $user)
    {
        $this->authorize(UserPolicy::BAN, $user);

        $user->update(['banned_at' => now()]);

        $this->success('User banned' . $user->name);

        return to_route('profile', $user->username);
    }

    public function unban(User $user)
    {
        $this->authorize(UserPolicy::BAN, $user);

        $user->update(['banned_at' => null]);

        $this->success('User unbanned' . $user->name);

        return to_route('profile', $user->username);
    }

    public function delete(User $user)
    {
        $this->authorize(UserPolicy::DELETE, $user);

        $user->delete();

        $this->success('Users deleted' . $user->name);

        return to_route('admin');
    }
}
