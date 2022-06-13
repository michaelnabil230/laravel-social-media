<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Policies\UserPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $posts = Auth::user()->posts()->latest()->get();

        return view('users.settings.settings', compact('posts'));
    }

    public function update(UpdateProfileRequest $request)
    {
        Auth::user()->update($request->validated());

        $this->success('settings.updated');

        return to_route('settings.profile');
    }

    public function destroy(Request $request)
    {
        $this->authorize(UserPolicy::DELETE, $user = $request->user());

        $user->delete();

        $this->success('Has ben deleted your account');

        return to_route('home');
    }
}
