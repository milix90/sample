<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Version;
use App\Observers\UserObserver;
use App\Observers\VersionObserver;
use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function boot()
    {
        User::observe(UserObserver::class);

        Response::macro('success', function ($payload, $status) {
            return response()->json(['data' => $payload], $status);
        });

        Response::macro('error', function ($payload, $status) {
            return response()->json(['error' => $payload], $status);
        });
    }
}
