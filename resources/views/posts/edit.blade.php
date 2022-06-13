@extends('layouts.app')

@section('content')
    <x-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('posts.update', $post) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <x-forms.label for="title">
                Title
            </x-forms.label>
            <x-forms.inputs.input type="text" :value="$post->title" name="title" id="title" required />
        </div>

        <div class="grow space-y-6">
            <div class="space-y-1">
                <x-forms.label for="communities">
                    Communities
                </x-forms.label>
                <select name="community_id" x-init="$nextTick(function() { choices($el) })">
                    @foreach ($communities as $community)
                        <option value="{{ $community->id }}" @selected($community->id == $post->community_id)>
                            {{ $community->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grow space-y-6">
            <div class="space-y-1">
                <x-forms.label for="body">
                    Body
                </x-forms.label>
                <livewire:editor :body="$post->body" placeholder="Compose your body..." hasMentions  />
            </div>
        </div>

        <x-buttons.primary-button>
            Edit Post
        </x-buttons.primary-button>
    </form>
@endsection
