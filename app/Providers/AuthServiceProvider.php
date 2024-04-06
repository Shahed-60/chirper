<?php

namespace App\Providers;

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
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('edit-chirp', function ($user, $chirp) {
            // Return true if the user is authorized to edit the chirp, false otherwise.
            // For example, you might check if the user is the owner of the chirp.
            return $user->id === $chirp->user_id;
        });
    }
    // 
}
