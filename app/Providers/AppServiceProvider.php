<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{

    protected $policies = [
       \App\Models\PgStudent::class => \App\Policies\PgStudentPolicy::class,
       \App\Models\PgSupervisor::class => \App\Policies\PgSupervisorPolicy::class,
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();
    }
}
