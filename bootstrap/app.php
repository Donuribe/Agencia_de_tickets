<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (NotFoundHttpException $e, $request) {
            if ($request->expectsJson()) {
                return null;
            }

            return response()->view('errors.404', [], 404);
        });

        $exceptions->render(function (AccessDeniedHttpException $e, $request) {
            if ($request->expectsJson()) {
                return null;
            }

            return response()->view('errors.403', [], 403);
        });

        $exceptions->render(function (TokenMismatchException $e, $request) {
            if ($request->expectsJson()) {
                return null;
            }

            return response()->view('errors.419', [], 419);
        });

        $exceptions->render(function (ServiceUnavailableHttpException $e, $request) {
            if ($request->expectsJson()) {
                return null;
            }

            return response()->view('errors.503', [], 503);
        });

        $exceptions->render(function (HttpException $e, $request) {
            if ($request->expectsJson()) {
                return null;
            }

            if ($e->getStatusCode() === 500) {
                return response()->view('errors.500', [], 500);
            }

            return null;
        });
    })->create();
