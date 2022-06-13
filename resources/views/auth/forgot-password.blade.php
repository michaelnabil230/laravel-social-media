@title('Sign in to your account')

@extends('layouts.small')

@section('small-content')
    <div class="mb-4 text-sm text-gray-600">
        Forgot your password? No problem. Just let us know your email address and we will email you a password reset link
        that will allow you to choose a new one.
    </div>

    <!-- Session Status -->
    <x-session-status class="mb-4" :status="session('status')" />

    <x-validation-errors class="mb-4" :errors="$errors" />

    <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
        @csrf

        <div class="mb-4">
            <x-forms.label for="email">
                Email
            </x-forms.label>
            <x-forms.inputs.email :value="old('email')" name="email" id="email" required />
        </div>

        <x-buttons.primary-button>
            Email Password Reset Link
            </x-buttons.primary-button>
    </form>
@endsection
