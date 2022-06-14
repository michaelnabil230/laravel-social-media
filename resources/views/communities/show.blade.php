@title("Community | $community->name")

@extends('layouts.app')

@section('content')
    <div class="pt-4">
        <div class="flex justify-between">
            <div class="flex">
                <h1 class="text-3xl font-bold">
                    {{ $community->name }}
                </h1>
                <div class="text-sm">
                    <span class="text-gray-600">{{ $community->users_count }} users </span>
                </div>
                <span class="text-gray-600">{{ $community->created_at->format('d M Y') }}</span>
            </div>
        </div>
        <div class="flex space-x-2">
            <x-buttons.primary-button href="{{ route('posts.create', ['community_id' => $community->id]) }}">
                Create Post
            </x-buttons.primary-button>

            @can(App\Policies\CommunityPolicy::JOIN, $community)
                <x-buttons.primary-button href="{{ route('communities.join', $community) }}">
                    Join
                </x-buttons.primary-button>
            @endcan

            @can(App\Policies\CommunityPolicy::LEAVE, $community)
                <x-buttons.primary-button href="{{ route('communities.leave', $community) }}">
                    Leave
                </x-buttons.primary-button>
            @endcan

            @canany([App\Policies\CommunityPolicy::UPDATE, App\Policies\CommunityPolicy::DELETE], $community)
                <x-buttons.primary-button href="{{ route('communities.edit', $community) }}">
                    Edit
                </x-buttons.primary-button>
                <form action="{{ route('communities.destroy', $community) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <x-buttons.danger-button type="submit">
                        Delete
                    </x-buttons.danger-button>
                </form>
            @endcanany
        </div>
        @if ($posts->count() > 0)
            @foreach ($posts as $post)
                <x-post :post="$post" />
            @endforeach

            {{ $posts->links() }}
        @else
            <div class="text-center">
                <h2 class="text-gray-600">No posts yet</h2>
                <p class="text-gray-600">Be the first to create a post</p>
            </div>
        @endif
    </div>
@endsection
