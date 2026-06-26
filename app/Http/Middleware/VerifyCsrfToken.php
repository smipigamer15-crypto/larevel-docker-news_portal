<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
    'api/*',
    'api/login',
    'api/register',
    'api/refresh',
    'api/logout',
    'sanctum/csrf-cookie',
];
}
