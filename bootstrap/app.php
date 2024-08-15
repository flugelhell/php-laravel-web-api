<?php

use App\Http\Middleware\SetApiDriverMiddleware;
use App\Http\Middleware\AuthApiMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Add Middleware API
        // $middleware->append(AuthApiMiddleware::class);

        // Declare Alias
        $middleware->alias([
            'set.driver.api' => SetApiDriverMiddleware::class,
            'auth.api' => AuthApiMiddleware::class
        ]);

        // Append middleware into api group middleware
        $middleware->api(append: [
            SetApiDriverMiddleware::class,
            AuthApiMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Add Exception For API
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], 401);
            }
        });
    })->create();
