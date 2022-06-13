@extends('layouts.app')

@section('content')
    <x-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('communities.store') }}" class="space-y-6">
        @csrf

        <div class="mb-4">
            <x-forms.label for="name">
                Name
            </x-forms.label>
            <x-forms.inputs.input type="text" :value="old('name')" name="name" id="name" required />
        </div>

        <div class="grow space-y-6">
            <div class="space-y-1">
                <x-forms.label for="topics">
                    Topics
                </x-forms.label>
                <select name="topics[]" multiple x-init="$nextTick(function() { choices($el) })">
                    @foreach ($topics as $topic)
                        <option value="{{ $topic->id }}" @selected(in_array($topic->id, old('topics', [])))>
                            {{ $topic->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grow space-y-6">
            <div class="space-y-1">
                <x-forms.label for="description">
                    Description
                </x-forms.label>
                <x-forms.inputs.textarea :value="old('description')" name="description" id="description" required />
            </div>
        </div>

        <x-buttons.primary-button>
            Create Community
        </x-buttons.primary-button>
    </form>
@endsection
