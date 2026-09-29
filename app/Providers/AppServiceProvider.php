<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($root = config('app.url')) {
            URL::forceRootUrl($root);
        }

        RateLimiter::for('contact', function (Request $request) {
            $tooMany = fn () => redirect()
                ->to(url('/').'#contact')
                ->withInput()
                ->withErrors(['message' => 'Too many messages sent. Please wait a few minutes and try again.']);

            return [
                Limit::perMinute(3)->by($request->ip())->response($tooMany),
                Limit::perHour(10)->by($request->ip())->response($tooMany),
            ];
        });
    }
}
