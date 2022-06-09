<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Community;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCommunityRequest;
use App\Http\Requests\UpdateCommunityRequest;

class CommunityController extends Controller
{
    public function index()
    {
        $communities = auth()->user()->communities();

        return view('communities.index', compact('communities'));
    }

    public function create()
    {
        $topics = Topic::all();

        return view('communities.create', compact('topics'));
    }

    public function store(StoreCommunityRequest $request)
    {
        $community = Community::create($request->validated()->marge(['user_id' => auth()->id()]));
        $community->topics()->attach($request->topics);

        return to_route('communities.show', $community);
    }

    public function show(Request $request, Community $community)
    {
        $posts = $community
            ->posts()
            ->with('postVotes')
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
        abort_if($community->user_id != auth()->id(), 403);

        $topics = Topic::all();
        $community->load('topics');

        return view('communities.edit', compact('community', 'topics'));
    }

    public function update(UpdateCommunityRequest $request, Community $community)
    {
        abort_if($community->user_id != auth()->id(), 403);

        $community->update($request->validated());
        $community->topics()->sync($request->topics);

        return to_route('communities.index')->with('message', 'Successfully updated');
    }

    public function destroy(Community $community)
    {
        abort_if($community->user_id != auth()->id(), 403);

        $community->delete();

        return to_route('communities.index')->with('message', 'Successfully deleted');
    }
}
