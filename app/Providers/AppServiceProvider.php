<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
        /**
         * ======================================================
         * SUPER ADMIN BYPASS
         * ======================================================
         *
         * super_admin otomatis memiliki seluruh permission.
         *
         * Tidak perlu:
         *
         * $superAdmin->givePermissionTo(...)
         *
         * untuk setiap permission.
         *
         * Selama user mempunyai role:
         *
         * super_admin
         *
         * maka seluruh Gate / permission akan dianggap TRUE.
         */
        Gate::before(
            function (User $user, string $ability) {

                if (
                    $user->hasRole('super_admin')
                ) {
                    return true;
                }

                return null;
            }
        );
    }
}
