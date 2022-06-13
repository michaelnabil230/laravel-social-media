@title('Sign in to your account')

@extends('layouts.small')

@section('small-content')
    <x-validation-errors class="mb-4" :errors="$errors" />

    <div class="mb-4 text-sm text-gray-600">
        This is a secure area of the application. Please confirm your password before continuing.
    </div>

    <form action="{{ route('password.confirm') }}" method="POST" class="space-y-6">
        @csrf

        <div class="mb-4">
            <x-forms.label for="password">
                Password
            </x-forms.label>
            <x-forms.inputs.password name="password" id="password" required />
        </div>

        <x-buttons.primary-button>
            Confirm
        </x-buttons.primary-button>
    </form>
@endsection
