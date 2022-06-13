<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController
{
    public function __invoke(Request $request, User $user = null)
    {
        if ($user) {
            $user->loadCount(['posts', 'comments', 'joinCommunities', 'communities as myCommunities']);

            $posts = $user->posts()->normal()->latest()->paginate();

            return view('users.profile', compact('user', 'posts'));
        }

        if ($request->user()) {
            return to_route('profile', $request->user()->username);
        }

        abort(404);
    }
}
