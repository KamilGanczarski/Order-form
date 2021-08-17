<?php

function env($key, $value = null) {
    if (!defined($key))
        define($key, $value);
    return $key;
}

return [

    /*
    |--------------------------------------------------------------------------
    | Allowed host connections
    |--------------------------------------------------------------------------
    |
    */

    'allowed_hosts' => [
        'localhost'
    ]
];
