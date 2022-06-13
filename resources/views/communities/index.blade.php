@extends('layouts.app')

@section('content')
    <div class="pt-4">
        <div class="px-2">
            <x-buttons.primary-button href="{{ route('communities.create') }}">
                Create Community
            </x-buttons.primary-button>
        </div>
        <div class="relative mx-auto px-2 focus:outline-none mt-4" x-data="{ showMore: false, showLassMore: false }"
            @scroll.window="showLassMore = (window.pageYOffset > 800) ? true : false">
            <div class="grid grid-cols-1 gap-6 lg:gap-8 sm:grid-cols-2 lg:grid-cols-3"
                :class="{ 'max-h-[120vh] overflow-hidden': !showMore }">
                @foreach ($communities->chunk(3) as $communitiesGroup)
                    <ul class="space-y-8">
                        @foreach ($communitiesGroup as $community)
                            <li class="text-sm leading-6">
                                <a href="{{ route('communities.show', $community) }}"
                                    class="flex items-center p-3 text-base font-bold text-gray-900 bg-white rounded-lg hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
                                    <span class="flex-1 ml-3 flex-wrap">
                                        {{ $community->name }}
                                    </span>
                                    @if ($community->posts_count >= $communities->avg('posts_count'))
                                        <span
                                            class="inline-flex items-center justify-center px-2 py-0.5 ml-3 text-xs font-medium text-gray-500 bg-gray-200 rounded dark:bg-gray-700 dark:text-gray-400">
                                            Popular
                                        </span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </div>
            <div x-show="!showMore" x-cloak
                class="inset-x-0 bottom-0 flex justify-center bg-gradient-to-t from-white pt-32 pb-8 pointer-events-none dark:from-green-900 absolute">
                <button @click="showMore = !showMore" type="button"
                    class="relative bg-green-900 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2 text-sm text-white font-semibold h-12 px-6 rounded-lg flex items-center dark:bg-green-700 dark:hover:bg-green-600 pointer-events-auto">
                    Show more...
                </button>
            </div>
            <div x-show="showMore" x-cloak :class="{ 'opacity-100': showLassMore, 'opacity-0': !showLassMore }"
                class="inset-x-0 bottom-4 flex justify-center bg-gradient-to-t from-white pt-32 pb-8 pointer-events-none dark:from-green-900 sticky -mt-52 transition-opacity duration-300">
                <button type="button" :class="{ 'pointer-events-auto': showLassMore }"
                    class="relative bg-green-900 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2 text-sm text-white font-semibold h-12 px-6 rounded-lg flex items-center dark:bg-green-700 dark:hover:bg-green-600 transition-transform translate-y-4">
                    Okay, I get the point
                </button>
            </div>
        </div>
    </div>
@endsection
