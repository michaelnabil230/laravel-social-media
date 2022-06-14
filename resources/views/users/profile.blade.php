@title("{$user->username} ({$user->name})")

@extends('layouts.app')

@section('content')
    <div class="bg-gray-900 bg-contain h-60 w-full"
        style="background-image: url('{{ asset('images/profile-background.svg') }}')">
    </div>

    <div class="container mx-auto">
        <div class="flex flex-col mt-5 p-4 lg:flex-row lg:gap-x-12">
            <div class="w-full mb-10 lg:w-1/3 lg:mb-0">
                <div>
                    <div class="flex items-center gap-x-4">
                        <h1 class="text-4xl font-bold">{{ $user->name }}</h1>

                        <span class="border border-green-500 text-green-500 rounded px-3 py-1">
                            {{ $user->is_admin ? 'Admin' : 'Normal User' }}
                        </span>
                    </div>

                    <span class="text-gray-600">
                        Joined {{ $user->created_at->format('j M Y') }}
                    </span>
                </div>

                <div class="mt-4">
                    <span class="text-gray-900">
                        {{ $user->bio }}
                    </span>
                </div>

                <div class="flex flex-col gap-y-4">
                    @if ($user->id === auth()->id())
                        <x-buttons.secondary-button href="{{ route('settings.profile') }}" class="w-full">
                            <span class="flex items-center gap-x-2">
                                <i class="fa-solid fa-pencil w-5 h-5"></i>
                                Edit profile
                            </span>
                        </x-buttons.secondary-button>
                    @endif

                    @can(\App\Policies\UserPolicy::BAN, $user)
                        @if ($user->is_banned)
                            <x-buttons.secondary-button class="w-full" x-on:click.prevent="activeModal = 'unbanUser'">
                                <span class="flex items-center gap-x-2">
                                    <i class="fa-solid fa-check w-5 h-5"></i>
                                    Unban User
                                </span>
                            </x-buttons.secondary-button>
                            <x-modal identifier="unbanUser" :action="route('admin.users.unban', $user->username)" title="Unban {{ $user->username }}"
                                type="update">
                                <p>Unbanning this user will allow them to login again and post content.</p>
                            </x-modal>
                        @else
                            <x-buttons.danger-button class="w-full" x-on:click.prevent="activeModal = 'banUser'">
                                <span class="flex items-center gap-x-2">
                                    {{-- <x-icon-hammer class="w-5 h-5" /> --}}
                                    Ban User
                                </span>
                            </x-buttons.danger-button>
                            <x-modal identifier="banUser" :action="route('admin.users.ban', $user->username)" title="Ban {{ $user->username }}" type="update">
                                <p>Banning this user will prevent them from logging in, posting threads and replying to threads.
                                </p>
                            </x-modal>
                        @endif
                    @endcan

                    @can(\App\Policies\UserPolicy::DELETE, $user)
                        <x-buttons.danger-button class="w-full" x-on:click.prevent="activeModal = 'deleteUser'">
                            <span class="flex items-center gap-x-2">
                                <i class="fa-solid fa-trash w-5 h-5"></i>
                                Delete User
                            </span>
                        </x-buttons.danger-button>
                        <x-modal identifier="deleteUser" :action="route('admin.users.delete', $user->username)" title="Delete {{ $user->username }}">
                            <p>
                                Are you sure you want to delete {{ $user->username }}?
                            </p>
                        </x-modal>
                    @endcan
                </div>
            </div>

            <div class="w-full lg:w-2/3">
                <h2 class="text-3xl font-semibold">
                    Statistics
                </h2>

                <div class="mt-4 grid grid-cols-1 lg:grid-cols-2">

                    <div class="w-full flex justify-between px-5 py-2.5 bg-gray-100 lg:bg-white">
                        <span>Comments</span>
                        <span class="text-green-500">
                            {{ number_format($user->comments_count) }}
                        </span>
                    </div>

                    <div class="w-full flex justify-between px-5 py-2.5">
                        <span>Posts</span>
                        <span class="text-green-500">
                            {{ number_format($user->posts_count) }}
                        </span>
                    </div>

                    <div class="w-full flex justify-between px-5 py-2.5">
                        <span>Join communities</span>
                        <span class="text-green-500">
                            {{ number_format($user->join_communities_count) }}
                        </span>
                    </div>

                    <div class="w-full flex justify-between px-5 py-2.5 bg-gray-100 lg:bg-white">
                        <span>Communities created</span>
                        <span class="text-green-500">
                            {{ number_format($user->my_communities_count) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($posts->count() > 0)
        <div class="mt-10 px-4 lg:mt-28">
            <h2 class="text-3xl font-semibold mb-2">
                Posts
            </h2>
            <div class="grid grid-cols-4 gap-4">
                @foreach ($posts as $post)
                    <x-post :post="$post" />
                @endforeach
            </div>
        </div>
    @else
        <div class="mt-10 px-4 lg:mt-28">
            <h2 class="text-3xl font-semibold">
                No posts yet
            </h2>
        </div>
    @endif
    </div>
@endsection
