<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Trust proxy headers so request IP/device headers are accurate behind CDN/load balancers.
        $middleware->trustProxies(at: '*');

        // Consent cookie is written from JavaScript (plain), so it must be excluded from encryption
        // to be readable in TrackPageView middleware.
        $middleware->encryptCookies(except: [
            'cookies_accepted',
        ]);

        $middleware->web(append: [
            \App\Http\Middleware\TrackPageView::class,
        ]);

        // Register alias middleware for RBAC
        $middleware->alias([
            'permission' => \App\Http\Middleware\CheckPermission::class,
            'role' => \App\Http\Middleware\CheckRole::class,
            'any-permission' => \App\Http\Middleware\CheckAnyPermission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create()
    ->usePublicPath(realpath(__DIR__.'/../../'));
