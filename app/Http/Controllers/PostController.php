<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Community;
use App\Models\Post;
use App\Notifications\PostReportNotification;
use App\Policies\PostPolicy;

class PostController extends Controller
{
    public function create()
    {
        $communities = Community::query()
            ->unless(auth()->user()->is_admin, function ($query) {
                return $query
                    ->where('user_id', auth()->id())
                    ->orWhereRelation('users', 'user_id', auth()->id());
            })
            ->get();

        return view('posts.create', compact('communities'));
    }

    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();

        $post = Post::create($validated + ['user_id' => auth()->id()]);

        return to_route('posts.show', $post);
    }

    public function show(Post $post)
    {
        $post->load('comments.user');

        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $this->authorize(PostPolicy::UPDATE, $post);

        $communities = Community::all();

        return view('posts.edit', compact('post', 'communities'));
    }

    public function update(StorePostRequest $request, Post $post)
    {
        $this->authorize(PostPolicy::UPDATE, $post);

        $validated = $request->validated();

        $post->update($validated);

        return to_route('posts.show', $post);
    }

    public function destroy(Post $post)
    {
        $this->authorize(PostPolicy::DELETE, $post);

        $post->delete();

        return redirect()->back();
    }

    public function report(Post $post)
    {
        $post->community->user->notify(new PostReportNotification($post));

        $this->success('Your report has been sent.');

        return to_route('posts.show', $post);
    }
}
