<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();


        Gate::before(function ($admin, $slug)
        {
            if ( str_contains($slug, '@') ) {

                [$permission, $module] = explode('@', $slug);

                if(Auth::guard('admin')->check() && can($module, $permission))
                    return true;
            }

            return false;

        });
    }
}
