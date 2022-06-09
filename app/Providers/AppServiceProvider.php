<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Community;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        if (!app()->runningInConsole()) {
            View::share('newestPosts', Post::with('community')->latest()->take(5)->get());
            View::share('newestCommunities', Community::withCount('posts')->latest()->take(5)->get());
        }
    }
}
