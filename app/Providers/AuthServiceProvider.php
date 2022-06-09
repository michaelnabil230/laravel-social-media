<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('edit-post', function (User $user, Post $post) {
            return $post->user_id == $user->id;
        });

        Gate::define('delete-post', function (User $user, Post $post) {
            return $user->is_admin || in_array($user->id, [$post->user_id, $post->community->user_id]);
        });
    }
}
