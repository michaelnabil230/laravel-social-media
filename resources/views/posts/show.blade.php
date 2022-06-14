@title("Post | $post->title")

@extends('layouts.app')

@section('content')
    <section class="pt-5 pb-10 px-4 container mx-auto flex flex-col gap-x-12 lg:flex-row lg:pt-10 lg:pb-0">
        <div class="w-full lg:w-3/4">
            <div class="relative">
                <div class="relative flex flex-col gap-y-6 z-20">
                    <div class="thread bg-white shadow rounded">
                        <div class="border-b">
                            <div class="px-6 pt-4 pb-0 lg:py-4">
                                <div class="flex flex-row justify-between items-start lg:items-center">
                                    <div class="flex flex-col lg:flex-row lg:items-center">
                                        <div class="flex items-center">
                                            <a href="{{ route('profile', $post->user->username) }}"
                                                class="hover:underline">
                                                <span class="text-gray-900 mr-5">
                                                    {{ $post->user->username }}
                                                </span>
                                            </a>
                                        </div>
                                        <span class="font-mono text-gray-700 mt-1 lg:mt-0">
                                            {{ $post->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-x-2">
                                        <div class="hidden flex-wrap gap-2 mt-2 lg:mt-0 lg:gap-x-4 lg:flex lg:flex-nowrap">
                                            <a href="{{ route('communities.show', $post->community) }}">
                                                {{ $post->community->name }}
                                            </a>
                                        </div>

                                        @canany([App\Policies\PostPolicy::UPDATE, App\Policies\PostPolicy::DELETE], $post)
                                            <div class="flex items-center gap-x-3">
                                                <div class="relative -mr-3" x-data="{ open: false }"
                                                    x-on:click.outside="open = false">
                                                    <button class="p-2 rounded hover:bg-gray-100" x-on:click="open = !open">
                                                        <i class="fa-solid fa-ellipsis-vertical w-6 h-6"></i>
                                                    </button>

                                                    <div x-cloak x-show="open"
                                                        class="absolute top-12 right-1 flex flex-col bg-white rounded shadow w-48">

                                                        @can(App\Policies\PostPolicy::UPDATE, $post)
                                                            <a class="flex gap-x-2 p-3 rounded hover:bg-gray-100"
                                                                href="{{ route('posts.edit', $post) }}">
                                                                <i class="fa-solid fa-pencil w-6 h-6"></i>
                                                                Edit
                                                            </a>
                                                        @endcan

                                                        @can(App\Policies\PostPolicy::DELETE, $post)
                                                            <button class="flex gap-x-2 p-3 rounded hover:bg-gray-100"
                                                                x-on:click="activeModal = 'deletePost'">
                                                                <i class="fa-solid fa-trash w-6 h-6 text-red-500"></i>
                                                                Delete
                                                            </button>
                                                            <x-modal identifier="deletePost" :action="route('posts.destroy', $post)" title="Delete Post">
                                                                <p>
                                                                    Are you sure you want to delete this post?
                                                                </p>
                                                            </x-modal>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                        @endcanany
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="prose prose-lio max-w-none p-6 break-words" x-data="{}"
                            x-init="$nextTick(function() { highlightCode($el); })" x-html="{{ json_encode(replace_links(md_to_html($post->body))) }}">
                        </div>

                        <div class="px-6 pb-6">
                            @can(App\Policies\PostPolicy::REPORT, $post)
                                <x-buttons.primary-button x-on:click="activeModal = 'reportPost'">
                                    Report
                                </x-buttons.primary-button>
                                <x-modal identifier="reportPost" :action="route('posts.report', $post)" title="Report Post">
                                    <p>
                                        Are you sure you want to report this post?
                                    </p>
                                </x-modal>
                            @endcan
                        </div>
                    </div>

                    @foreach ($post->comments as $comment)
                        <x-comment :post="$post" :comment="$comment" />
                    @endforeach
                </div>

                <div class="absolute h-full border-l border-green-500 ml-8 z-10 inset-y-0 left-0 lg:ml-16"></div>
            </div>

            @guest
                <p class="text-center py-8">
                    <a href="{{ route('login') }}"
                        class="text-green-500 border-b-2 pb-0.5 border-green-100 hover:text-green-600">
                        Sign in
                    </a>
                </p>
            @else
                <div class="my-8">
                    <form action="{{ route('posts.comments.store', $post) }}" method="POST"
                        @submitted="$event.currentTarget.submit()">
                        @csrf
                        <livewire:editor hasMentions hasButton buttonIcon="send" label="Write a post"
                            buttonLabel="Write a comment" />
                    </form>
                </div>
            @endguest
        </div>
    </section>
@endsection
@push('scripts')
    <script type="text/javascript">
        let postId = "{{ $post->id }}";
        window.Echo.channel("public-channel")
            .listen('.comment.created.' + postId, (e) => {
                alert('New comment' + e.comment.body);
            });
    </script>
@endpush
