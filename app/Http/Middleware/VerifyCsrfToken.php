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
        'admin/ajax/file/upload-file',
        'admin/ajax/gallery/upload',
        'ajax/searching/search-data',
        'ajax/searchForm'
    ];
}
