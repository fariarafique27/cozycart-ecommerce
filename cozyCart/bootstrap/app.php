<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\PreventBackHistory;
use Illuminate\Session\TokenMismatchException; 

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Your existing admin alias stays exactly here
        $middleware->alias([
            'admin' => AdminMiddleware::class,
        ]);

        // 🎯 3. Force your browser cache-buster middleware on all web routes
        $middleware->web(append: [
            PreventBackHistory::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // 🎯 4. Catch 419 errors from the back-button logout submissions
        $exceptions->render(function (TokenMismatchException $e, $request) {
            if ($request->is('logout') || $request->is('login')) {
                return redirect('/login')->with('error', 'Your session expired. Please log in again.');
            }
        });
    })->create();