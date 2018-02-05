<?php

/*
|--------------------------------------------------------------------------
| Laravel File Manager
|--------------------------------------------------------------------------
| Client configuration
|
| You can find more information in (https://github.com/bondacom/laravel-file-manager)
*/

return [
    /*
    |--------------------------------------------------------------------------
    | Reader utility
    |--------------------------------------------------------------------------
    |
    | Handler: Default reader type. Options: csv|txt
    | Chunk: Default number of lines to return in callback.
    */
    'reader' => [
        'handler' => 'txt',

        'default' => [
            'chunk' => 1
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Writer utility
    |--------------------------------------------------------------------------
    |
    | Chunk: Default number of lines to return in callback.
    */
    'writer' => [
        'handler' => 'inform',

        'default' => [
            'move_to_s3' => true
        ]
    ],
];