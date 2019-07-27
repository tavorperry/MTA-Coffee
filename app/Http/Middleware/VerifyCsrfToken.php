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
        'wallet/confirm-charge-with-tranzila',
        'https://coffee-stg.mta.ac.il/wallet/confirm-charge-with-tranzila',
        'https://coffee.mta.ac.il/wallet/confirm-charge-with-tranzila',
        'nayax/sale'
    ];
}
