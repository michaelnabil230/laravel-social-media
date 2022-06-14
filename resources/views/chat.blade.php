@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="text-4xl font-bold">
            {{ $community->name }}
        </div>
        <chat-app community="{{ $community->toJson() }}" user="{{ Auth::user()->toJson() }}"></chat-app>
    </div>
@endsection

@push('scripts')
    <script>
        new Vue({
            el: '#app',
        });
    </script>
@endpush
