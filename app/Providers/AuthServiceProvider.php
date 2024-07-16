<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Employee;
use App\Policies\EmployeePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Employee::class => EmployeePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Passport::tokensExpireIn(now()->addDays(15));
        // Route : .../oauth/token/refresh
        Passport::refreshTokensExpireIn(now()->addDays(30));

        //
    }
}
