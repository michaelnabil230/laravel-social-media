@extends('layouts.app')

@section('content')
    <div class="flex px-4 lg:px-0">
        <div class="hidden lg:block lg:w-1/3">
            <div class="py-12 mt-48 sticky top-0">
                <div class="p-4 max-w-sm bg-white rounded-lg border shadow-md sm:p-6 dark:bg-gray-800 dark:border-gray-700">
                    <h5 class="mb-3 text-base font-semibold text-gray-900 lg:text-xl dark:text-white">
                        Communities
                    </h5>
                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">
                        Community with one of our available. You can join or create your own community.
                        <a href="{{ route('communities.index') }}" class="text-green-500 hover:text-green-700">
                            <span class="underline">
                                View all communities
                            </span>
                        </a>
                    </p>
                    <br>
                    <div tabindex="-1" class="relative focus:outline-none" x-data="{ showMore: false, showLassMore: false }"
                        @scroll.window="showLassMore = (window.pageYOffset > 400) ? true : false">
                        <div class="gap-6 lg:gap-8 sm:grid-cols-2" :class="{ 'max-h-[50vh] overflow-hidden': !showMore }">
                            <ul class="space-y-4">
                                @foreach ($communities as $community)
                                    <li class="text-sm leading-6">
                                        <a href="{{ route('communities.show', $community) }}"
                                            class="flex items-center p-3 text-base font-bold text-gray-900 bg-gray-50 rounded-lg hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
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
                        </div>
                        <div x-show="!showMore" x-cloak
                            class="inset-x-0 bottom-0 flex justify-center bg-gradient-to-t from-white pt-32 pb-8 pointer-events-none dark:from-green-900 absolute">
                            <button @click="showMore = !showMore" type="button"
                                class="relative bg-green-900 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2 text-sm text-white font-semibold h-12 px-6 rounded-lg flex items-center dark:bg-green-700 dark:hover:bg-green-600 pointer-events-auto">
                                Show more...
                            </button>
                        </div>
                        <div x-show="showMore" x-cloak :class="{ 'opacity-100': showLassMore, 'opacity-0': !showLassMore }"
                            class="inset-x-0 bottom-0 flex justify-center bg-gradient-to-t from-white pt-32 pb-8 pointer-events-none dark:from-green-900 sticky -mt-52 transition-opacity duration-300">
                            <button type="button" :class="{ 'pointer-events-auto': showLassMore }"
                                class="relative bg-green-900 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2 text-sm text-white font-semibold h-12 px-6 rounded-lg flex items-center dark:bg-green-700 dark:hover:bg-green-600 transition-transform translate-y-4">
                                Okay, I get the point
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full pt-4 lg:w-3/4 lg:pt-10">
            <div class="flex flex-col gap-x-4 gap-y-3 lg:flex-row lg:justify-between mb-10">
                <div class="flex flex-col gap-x-4 gap-y-3 lg:flex-row">
                </div>
            </div>
            @foreach ($posts as $post)
                <x-post :post="$post" />
            @endforeach
        </div>
    </div>
@endsection
