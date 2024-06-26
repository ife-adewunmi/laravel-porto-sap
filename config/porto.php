<?php

return [
    /*
     |--------------------------------------------------------------------------
     | IPorto Settings
     |--------------------------------------------------------------------------
     |
     | IPorto is disabled by default.
     | You can enable porto putting PORTO_ENABLED=true
     | in your .env file.
     |
     */

    'enabled' => env("PORTO_SAP_ENABLED", false),

    /*
     |--------------------------------------------------------------------------
     | Path Settings
     |--------------------------------------------------------------------------
     |
     | Porto need to know your directory path.
     | The default path is set app. You can easy to change this path in .env file.
     | When you building porto structure in the console, your custom path will be
     | overwritten in the .env file
     |
     */

    'path' => env('PORTO_SAP_PATH', 'app'),

    /*
     |--------------------------------------------------------------------------
     | Root Settings
     |--------------------------------------------------------------------------
     |
     | Root path implements base path plus directory path
     |
     */

    'root' => base_path(env('PORTO_SAP_PATH', 'app'))
];
