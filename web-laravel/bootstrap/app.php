<?php

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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Throwable $e) {
            echo "<div style='background:#f8d7da;color:#721c24;padding:20px;font-family:monospace;white-space:pre-wrap;'>";
            echo "<h1>CRITICAL ERROR DETECTED</h1>";
            echo "<b>Message:</b> " . $e->getMessage() . "<br><br>";
            echo "<b>File:</b> " . $e->getFile() . " on line " . $e->getLine() . "<br><br>";
            echo "<b>Stack Trace:</b>\n" . $e->getTraceAsString();
            echo "</div>";
            die();
        });
    })->create();
