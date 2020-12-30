<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/login',
        '/register',
        '/user/search',
        '/user',
        '/user/follow',
        '/content/contentbaseresponder',
        '/content/contentuser',
        '/content/insertcontent'
    ];
}
