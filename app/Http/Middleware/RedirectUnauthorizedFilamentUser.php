<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectUnauthorizedFilamentUser
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        $user = $request->user();


        /*
        |--------------------------------------------------------------------------
        | BELUM LOGIN
        |--------------------------------------------------------------------------
        |
        | Biarkan Filament Authenticate yang menangani.
        |
        */

        if (! $user) {
            return $next($request);
        }


        /*
        |--------------------------------------------------------------------------
        | SUPER ADMIN
        |--------------------------------------------------------------------------
        */

        if ($user->hasRole('super_admin')) {
            return $next($request);
        }


        /*
        |--------------------------------------------------------------------------
        | STAFF IT
        |--------------------------------------------------------------------------
        */

        if ($user->hasRole('staff_it')) {
            return $next($request);
        }


        /*
        |--------------------------------------------------------------------------
        | USER DENGAN PERMISSION
        |--------------------------------------------------------------------------
        */

        if (
            $user
                ->getAllPermissions()
                ->isNotEmpty()
        ) {
            return $next($request);
        }


        /*
        |--------------------------------------------------------------------------
        | USER TANPA PERMISSION
        |--------------------------------------------------------------------------
        |
        | Jangan izinkan user 0 permission masuk ke Panel Filament.
        |
        | Langsung keluar dari /admin dan masuk ke halaman
        | Permintaan IT yang berada DI LUAR Filament.
        |
        */

        return redirect()->route(
            'it-requests.index'
        );
    }
}
