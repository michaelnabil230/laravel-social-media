<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommunityRequest;
use App\Http\Requests\UpdateCommunityRequest;
use App\Models\Community;
use App\Models\Topic;
use App\Policies\CommunityPolicy;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function index()
    {
        $communities = Community::get();

        return view('communities.index', compact('communities'));
    }

    public function create()
    {
        $topics = Topic::all();

        return view('communities.create', compact('topics'));
    }

    public function store(StoreCommunityRequest $request)
    {
        $community = Community::create($request->validated() + ['user_id' => auth()->id()]);
        $community->topics()->attach($request->topics);

        return to_route('communities.show', $community);
    }

    public function show(Request $request, Community $community)
    {
        $community->loadCount('users');

        $posts = $community
            ->posts()
            ->normal()
            ->when($request->sort === 'popular', function ($query) {
                $query->orderBy('votes', 'desc');
            }, function ($query) {
                $query->latest('id');
            })
            ->paginate();

        return view('communities.show', compact('community', 'posts'));
    }

    public function edit(Community $community)
    {
        $this->authorize(CommunityPolicy::UPDATE, $community);

        $topics = Topic::all();
        $community->load('topics');

        return view('communities.edit', compact('community', 'topics'));
    }

    public function update(UpdateCommunityRequest $request, Community $community)
    {
        $this->authorize(CommunityPolicy::UPDATE, $community);

        $community->update($request->validated());
        $community->topics()->sync($request->topics);

        $this->success('Successfully updated');

        return to_route('communities.index');
    }

    public function destroy(Community $community)
    {
        $this->authorize(CommunityPolicy::DELETE, $community);

        $community->delete();

        $this->success('Successfully deleted');

        return to_route('communities.index');
    }

    public function join(Community $community)
    {
        $this->authorize(CommunityPolicy::JOIN, $community);

        $community->users()->attach(auth()->id());

        $this->success('Successfully joined');

        return to_route('communities.show', $community);
    }

    public function leave(Community $community)
    {
        $this->authorize(CommunityPolicy::LEAVE, $community);

        $community->users()->detach(auth()->id());

        $this->success('Successfully left');

        return to_route('communities.show', $community);
    }
}
