<?php

namespace App\Providers;

use App\Models\Department;
use App\Models\Problem;
use App\Models\User;
use App\Policies\ActivityPolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\ProblemPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Activity::class, ActivityPolicy::class);
        Gate::policy(Problem::class, ProblemPolicy::class);
        Gate::policy(Department::class, DepartmentPolicy::class);
        Gate::policy(User::class, UserPolicy::class);
    }
}
