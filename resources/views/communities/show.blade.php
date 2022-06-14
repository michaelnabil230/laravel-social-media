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
                    <span class="text-gray-600">{{ $community->users_count }} users</span>
                </div>
                <span class="text-gray-600">{{ $community->created_at->format('d M Y') }}</span>
            </div>
        </div>
        <div class="flex space-x-2">
            @can(App\Policies\CommunityPolicy::CREATE, $community)
                <x-buttons.primary-button href="{{ route('posts.create', ['community_id' => $community->id]) }}">
                    Create Post
                </x-buttons.primary-button>
            @endcan
            @can(App\Policies\CommunityPolicy::JOIN, $community)
                <x-buttons.primary-button href="{{ route('communities.join', $community) }}">
                    Join
                </x-buttons.primary-button>
            @elsecan(App\Policies\CommunityPolicy::LEAVE, $community)
                <x-buttons.primary-button href="{{ route('communities.leave', $community) }}">
                    Leave
                </x-buttons.primary-button>
                <x-buttons.primary-button href="{{ route('communities.chat', $community) }}">
                    Chat
                </x-buttons.primary-button>
            @endcan

            @canany([App\Policies\CommunityPolicy::UPDATE, App\Policies\CommunityPolicy::DELETE], $community)
                <x-buttons.primary-button href="{{ route('communities.edit', $community) }}">
                    Edit
                </x-buttons.primary-button>
                <x-buttons.danger-button x-on:click.prevent="activeModal = 'deleteCommunity'">
                    <i class="fa-solid fa-trash w-5 h-5"></i>
                    Delete
                </x-buttons.danger-button>
                <x-modal identifier="deleteCommunity" :action="route('communities.destroy', $community)" title="Delete {{ $community->name }}">
                    <p>
                        Deleting this community will remove all related content vote & comments.
                    </p>
                </x-modal>
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
