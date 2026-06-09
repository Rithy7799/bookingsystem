<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\authenticateMiddleware;
use App\Http\Middleware\StaffMiddleware;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
         $middleware->alias([
           'authenticate'=> authenticateMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role'       => RoleMiddleware::class   
         ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();