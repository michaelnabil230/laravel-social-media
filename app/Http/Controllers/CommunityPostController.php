<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Community;
use App\Models\Post;
use App\Notifications\PostReportNotification;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class CommunityPostController extends Controller
{
    public function index(Community $community)
    {
        $posts = $community->posts()->latest('id')->paginate();

        return view('communities.index', compact('community', 'posts'));
    }

    public function create(Community $community)
    {
        return view('posts.create', compact('community'));
    }

    public function store(StorePostRequest $request, Community $community)
    {
        $validated = $request->validated();

        $validated['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public/post_images');
        }

        $community->posts()->create($validated);

        return to_route('communities.show', $community);
    }

    public function show(Post $post)
    {
        $post->load('comments.user', 'community');

        return view('posts.show', compact('post'));
    }

    public function edit(Community $community, Post $post)
    {
        abort_if(Gate::denies('edit-post', $post), 403);

        return view('posts.edit', compact('community', 'post'));
    }

    public function update(StorePostRequest $request, Community $community, Post $post)
    {
        abort_if(Gate::denies('edit-post', $post), 403);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::delete($post->image);
            }

            $validated['image'] = $request->file('image')->store('public/post_images');
        }

        $post->update($validated);

        return to_route('communities.posts.show', $post);
    }

    public function destroy(Community $community, Post $post)
    {
        abort_if(Gate::denies('delete-post', $post), 403);

        $post->delete();

        return to_route('communities.show', [$community]);
    }

    public function report(Post $post)
    {
        $post->community->user->notify(new PostReportNotification($post));

        return to_route('communities.posts.show', $post)->with('message', 'Your report has been sent.');
    }
}
