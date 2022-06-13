@title('Sign in to your account')

@extends('layouts.small')

@section('small-content')
    <x-validation-errors class="mb-4" :errors="$errors" />

    <form action="{{ route('register') }}" method="POST" class="space-y-6">
        @csrf

        <div class="mb-4">
            <x-forms.label for="name">
                Name
            </x-forms.label>
            <x-forms.inputs.input type="text" :value="old('name')" name="name" id="name" required />
        </div>

        <div class="mb-4">
            <x-forms.label for="email">
                Email
            </x-forms.label>
            <x-forms.inputs.email :value="old('email')" name="email" id="email" required />
        </div>

        <div class="mb-4">
            <x-forms.label for="username">
                UserName
            </x-forms.label>
            <x-forms.inputs.input type="text" :value="old('username')" name="username" id="username" required />
        </div>

        <div class="mb-4">
            <x-forms.label for="password">
                Password
            </x-forms.label>
            <x-forms.inputs.password name="password" id="password" required />
        </div>

        <div class="mb-4">
            <x-forms.label for="password_confirmation">
                Password confirmation
            </x-forms.label>
            <x-forms.inputs.password name="password_confirmation" id="password_confirmation" required />
        </div>

        <div class="flex items-center justify-between">
            <x-forms.inputs.checkbox name="remember" id="remember">
                Remember me
            </x-forms.inputs.checkbox>

            <div class="text-sm">
                <a class="font-medium text-green-600 hover:text-green-500" href="{{ route('login') }}">
                    Already registered?
                </a>
            </div>
        </div>

        <x-buttons.primary-button>
            Register
        </x-buttons.primary-button>
    </form>
@endsection
