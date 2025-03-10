<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\Cors;
use App\Http\Middleware\NormalizeDatatablesSearchAndFilterRequests;
use App\Http\Middleware\Permission;
use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::prefix('/')->group(base_path('routes/dashboard.php'));
            Route::prefix('api')->group(base_path('routes/api.php')); // end user routes
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append([Cors::class, SetLocale::class]);
        $middleware->alias([
            'permission' => Permission::class,
            'auth' => Authenticate::class,
            'set_locale' => SetLocale::class,
            'normalize_datatables_search_and_filter_requests' => NormalizeDatatablesSearchAndFilterRequests::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
