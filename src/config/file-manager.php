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
    | Handler: Default reader type. Options: csv|txt
    | Move to S3: Set to true if wants to automatically move local file to Amazon Storage S3
    | using Laravel filesystem disk configuration
    */
    'writer' => [
        'handler' => 'txt',

        'default' => [
            'move_to_s3' => false
        ]
    ],
];