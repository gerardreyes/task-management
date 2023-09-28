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

        // Define multiple abilities with the same authorization logic
        $abilities = ['create-task', 'update-task'];
        foreach ($abilities as $ability) {
            Gate::define($ability, function ($user) use ($ability) {
                // Check if the user has the permission to create or update a task, e.g., based on roles or other criteria.
                return $user->hasPermission($ability);
            });
        }

        Gate::define('delete-task', function ($user, $task) {
            // Return true if authorized, false otherwise.
            return $user->id === $task->user_id; // Only allow deletion only if the user owns the task.
        });
    }
}
