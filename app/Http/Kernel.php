<?php
namespace App\Http;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        // Global HTTP middleware
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            // ...existing web middleware...
        ],

        'api' => [
            // ...existing api middleware...
        ],
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // ...existing route middleware...
    ];
}
