<?php

function env($key, $value = null) {
    if (!defined($key))
        define($key, $value);
    return $key;
}

function storage_path($path) {}

function resource_path() {}

function database_path($sql_type) {}

return [

    /*
    |--------------------------------------------------------------------------
    | Allowed host connections
    |--------------------------------------------------------------------------
    |
    */

    'allowed_hosts' => [
        'psphoto.pl',
        'www.psphoto.pl',
        'klient.psphoto.pl',
        'www.klient.psphoto.pl',
        '9literfilmy.pl',
        'www.9literfilmy.pl',
        'youngfreshcinema.pl',
        'www.youngfreshcinema.pl',
        'localhost',
        // access to local serwer at home - to remove for secure
        '192.168.1.20',
        // access to local serwer in patryk - to remove for secure
        '192.168.1.15',
        '192.168.1.22'
    ]
];
