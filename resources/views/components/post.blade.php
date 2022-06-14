<div class="{{ $class ?? '' }} pt-3">
    <div class="h-full border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
        <a href="{{ route('profile', $post->user) }}" class="inline-flex items-center pl-6 pt-6">
            <img alt="blog" src="https://dummyimage.com/103x103"
                class="w-12 h-12 rounded-full flex-shrink-0 object-cover object-center">
            <span class="pl-4 title-font font-medium text-gray-900">
                {{ $post->user->name }}
            </span>
        </a>
        <div class="p-6">
            <p class="text-sm text-gray-500">
                {{ $post->created_at->format('d M Y') }}
            </p>

            @if ($attributes->has('vote'))
                @livewire('post-votes', ['post' => $post])
            @endif

            <h2 class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1">
                {{ $post->community->name }}
            </h2>
            <h1 class="title-font text-lg font-medium text-gray-900 mb-3">
                {{ $post->title }}
            </h1>
            <p class="leading-relaxed mb-3">
                {{ \Illuminate\Support\Str::words($post->body, 10) }}
            </p>
            <div class="flex items-center flex-wrap">
                <a href="{{ route('posts.show', $post) }}"
                    class="text-green-500 inline-flex items-center md:mb-2 lg:mb-0">
                    Learn More
                    <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14"></path>
                        <path d="M12 5l7 7-7 7"></path>
                    </svg>
                </a>
                <a href="{{ route('posts.show', $post) }}"
                    class="text-gray-400 inline-flex items-center lg:ml-auto md:ml-0 ml-auto leading-none text-sm">
                    <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path
                            d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z">
                        </path>
                    </svg>
                    {{ $post->comments_count }}
                </a>
            </div>
        </div>
    </div>
</div>
