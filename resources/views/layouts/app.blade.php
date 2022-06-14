<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        {{ isset($title) ? $title . ' | ' : '' }}
        {{ config('app.name', 'Laravel') }}
    </title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    @livewireStyles

</head>

<body class="bg-gray-50 text-gray-600 body-font" x-bind:class="{ 'overflow-hidden': lockScroll }" x-data="{ lockScroll: false, activeModal: false }"
    @keyup.escape="activeModal = false">
    <header x-data="{ nav: false }" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
        <div class="px-4 py-5 mx-auto space-y-4 lg:space-y-0 lg:flex lg:items-center lg:justify-between lg:space-x-10">
            <div class="flex justify-between">
                <a href="/" class="text-gray-800 dark:text-gray-200">
                    <p class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">
                        {{ config('app.name') }}
                    </p>
                </a>
                <div class="flex items-center space-x-2 lg:hidden">
                    <button x-on:click="nav=!nav"
                        class="p-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 focus:bg-gray-100 dark:focus:bg-gray-800 focus:outline-none">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 text-gray-700 dark:text-gray-300">
                            <path fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="flex flex-col space-y-4 lg:hidden" x-show="nav">
                <div class="flex flex-col space-y-3 lg:space-y-0 lg:flex-row lg:space-x-6 xl:space-x-8 lg:items-center">
                    <a href="{{ route('home') }}"
                        class="text-gray-500 dark:text-gray-200 hover:text-gray-800 dark:hover:text-gray-400 transition-colors duration-300">
                        Home
                    </a>
                    <a href="{{ route('communities.index') }}"
                        class="text-gray-500 dark:text-gray-200 hover:text-gray-800 dark:hover:text-gray-400 transition-colors duration-300">
                        Communities
                    </a>
                    <a href="{{ route('posts.create') }}"
                        class="text-gray-500 dark:text-gray-200 hover:text-gray-800 dark:hover:text-gray-400 transition-colors duration-300">
                        Create Post
                    </a>
                    @auth
                        <a href="{{ route('notifications') }}"
                            class="text-gray-500 dark:text-gray-200 hover:text-gray-800 dark:hover:text-gray-400 transition-colors duration-300">
                            <i class="fa-solid fa-bell"></i>
                            <span>Notifications</span>
                        </a>
                        <div class="flex flex-col space-y-3 lg:hidden">
                            <a href="{{ route('settings.profile') }}"
                                class="text-gray-500 dark:text-gray-200 hover:text-gray-800 dark:hover:text-gray-400">
                                Edit Profile
                            </a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button
                                    class="flex items-center space-x-3 text-gray-500 dark:text-gray-200 hover:text-gray-800 dark:hover:text-gray-400 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    <span>Log Out</span>
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
                <div class="flex flex-col space-y-4 lg:space-y-0 lg:flex-row lg:items-center lg:space-x-4">
                    <button type="button" aria-label="Color Mode"
                        class="flex justify-center p-2 text-gray-500 transition duration-150 ease-in-out bg-gray-100 border border-transparent rounded-md lg:bg-white lg:dark:bg-gray-900 dark:text-gray-200 dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-700 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-5 h-5 transform -rotate-90">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                    </button>
                    <form action="/search" class="flex flex-wrap justify-between md:flex-row">
                        <input type="search" name="query" placeholder="Search" required="required"
                            class="w-full h-12 px-4 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg lg:w-20 xl:transition-all xl:duration-300 xl:w-36 xl:focus:w-44 lg:h-10 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-green-500 dark:focus:border-green-500 focus:outline-none focus:ring focus:ring-green-500 dark:placeholder-gray-400 focus:ring-opacity-20">
                    </form>
                    @guest
                        <a href="{{ route('register') }}"
                            class="flex items-center justify-center h-12 px-4 text-sm font-medium text-center text-white transition-colors duration-300 transform rounded-md lg:h-10 bg-green-500 hover:bg-green-500/70">
                            Register
                        </a>
                        <a href="{{ route('login') }}"
                            class="flex items-center justify-center h-12 px-4 mt-2 text-sm text-center text-gray-600 transition-colors duration-300 transform border rounded-lg lg:h-10 dark:text-gray-300 dark:border-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">
                            Login
                        </a>
                    @endguest
                </div>
            </div>
            <div class="hidden lg:flex lg:flex-row lg:items-center lg:justify-between lg:flex-1 lg:space-x-2">
                <div class="flex flex-col space-y-3 lg:space-y-0 lg:flex-row lg:space-x-6 xl:space-x-8 lg:items-center">
                    <a href="{{ route('home') }}"
                        class="text-gray-500 dark:text-gray-200 hover:text-gray-800 dark:hover:text-gray-400 transition-colors duration-300">
                        Home
                    </a>
                    <a href="{{ route('communities.index') }}"
                        class="text-gray-500 dark:text-gray-200 hover:text-gray-800 dark:hover:text-gray-400 transition-colors duration-300">
                        Communities
                    </a>
                    <a href="{{ route('posts.create') }}"
                        class="text-gray-500 dark:text-gray-200 hover:text-gray-800 dark:hover:text-gray-400 transition-colors duration-300">
                        Create Post
                    </a>
                </div>
                <div class="flex flex-col space-y-4 lg:space-y-0 lg:flex-row lg:items-center lg:space-x-4">
                    <button type="button" aria-label="Color Mode"
                        class="flex justify-center p-2 text-gray-500 transition duration-150 ease-in-out bg-gray-100 border border-transparent rounded-md lg:bg-white lg:dark:bg-gray-900 dark:text-gray-200 dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-700 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-5 h-5 transform -rotate-90">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                    </button>
                    <form action="/search" class="flex flex-wrap justify-between md:flex-row">
                        <input type="search" name="query" placeholder="Search" required="required"
                            class="w-full h-12 px-4 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg lg:w-20 xl:transition-all xl:duration-300 xl:w-36 xl:focus:w-44 lg:h-10 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-green-500 dark:focus:border-green-500 focus:outline-none focus:ring focus:ring-green-500 dark:placeholder-gray-400 focus:ring-opacity-20">
                    </form>
                    @auth
                        <a href="{{ route('notifications') }}" class="hover:text-green-600">
                            <i class="fa-solid fa-bell"></i>
                        </a>
                        <div class="relative lg:inline-block" x-data="{ dropDown: false }">
                            <div>
                                <button x-on:click="dropDown=!dropDown"
                                    class="flex items-center space-x-2 focus:outline-none">
                                    <img src="https://www.gravatar.com/avatar/d9b562166e42a7cff1422818760c9e43"
                                        class="object-cover w-8 h-8 rounded-full xl:w-10 xl:h-10">
                                    <span class="font-medium text-gray-800 dark:text-gray-200 lg:hidden">
                                        {{ auth()->user()->name }}
                                    </span>
                                </button>
                            </div>
                            <div x-bind:class="{ 'hidden': !dropDown }"
                                class="absolute left-0 z-20 py-1 mt-2 bg-white border border-gray-100 rounded-md shadow-xl dark:border-gray-700 lg:left-auto lg:right-0 dark:bg-gray-800">
                                <div class="w-48">
                                    <a href="{{ route('profile', auth()->user()->username) }}"
                                        class="block px-4 py-2 text-sm text-gray-700 capitalize transition-colors duration-300 transform dark:text-gray-300 hover:text-primary dark:hover:text-primary">
                                        Signed in as
                                        <br>
                                        <span class="font-medium">{{ auth()->user()->name }}</span>
                                    </a>
                                    <a href="{{ route('settings.profile') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 capitalize transition-colors duration-300 transform dark:text-gray-300 hover:text-primary dark:hover:text-primary">
                                        Edit Profile
                                    </a>
                                    <hr class="border-gray-200 dark:border-gray-700">
                                    <form action="{{ route('logout') }}" method="POST" class="leading-none">
                                        @csrf
                                        <button
                                            class="flex items-center px-4 py-2 space-x-3 text-sm text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                                </path>
                                            </svg>
                                            <span>Log Out</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <x-buttons.primary-button href="{{ route('register') }}">
                            Register
                        </x-buttons.primary-button>
                        <span class="inline-flex rounded-md shadow-sm">
                            <a href="{{ route('login') }}"
                                class="rounded py-2 px-4 inline-flex justify-center text-base text-black focus:outline-none border dark:text-gray-300 dark:border-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium">
                                Login
                            </a>
                        </span>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <div id="app" class="container mx-auto">
        @include('layouts._alerts')
        @yield('content')
    </div>

    @livewireScripts
    @stack('modals')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"></script>
    <script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    <script type="text/javascript">
        window.Echo.channel("public-channel")
            .listen('.post.created', (e) => {
                alert('New post created' + e.post.title);
            });
    </script>
    @stack('scripts')
</body>

</html>
