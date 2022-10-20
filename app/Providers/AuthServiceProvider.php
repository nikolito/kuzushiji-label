<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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

        //管理者 1
        Gate::define('admin', function(User $user) {
            return ($user->user_level === 1);
        });

        //清書を許可するユーザー 2
        Gate::define('checker', function (User $user) {
            return ($user->user_level >= 1);
        });

        //一般ユーザー 0
        Gate::define('user', function (User $user) {
            return ($user->user_level === 0);
        });
    }
}
