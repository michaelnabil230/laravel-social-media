@title('Settings')

@extends('layouts.app')

@section('content')
    <main class="max-w-4xl mx-auto pt-10 pb-12 px-4 lg:pb-16">
        <div class="lg:grid lg:gap-x-5">
            <div class="sm:px-6 lg:px-0 lg:col-span-9">
                @include('users.settings.profile')
                @include('users.settings.password')
                @include('users.settings.remove')
            </div>
        </div>
    </main>
@endsection
