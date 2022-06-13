@title('Your Posts')

@extends('layouts.app')

@section('subnav')
    <div class="bg-white border-b">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-xl py-4 text-gray-900 break-all">
                {{ $title }}
            </h1>

            <div class="flex">
                <x-buttons.primary-button href="{{ route('posts.create') }}">
                    Create Article
                </x-buttons.primary-button>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col gap-y-4 mb-4">
            @forelse($posts as $post)
                <x-post :post="$post" :mode="'edit'" />
            @empty
                <p class="text-gray-600 text-base">
                    You haven't created any posts yet
                </p>
            @endforelse
        </div>

        {{ $posts->links() }}
    </div>
@endsection
