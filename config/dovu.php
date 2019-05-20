<?php

return [

    /*
    |--------------------------------------------------------------------------
    | DOVU API URL
    |--------------------------------------------------------------------------
    |
    | The DOVU API endpoint that the Third Party App will connect to. For
    | production applications for partners this will use the default value.
    | For development purposes add the DOVU_API_URL key to your .env file
    | to test and develop locally.
    |
    */

    'api_url' => env('DOVU_API_URL', 'dovu.app'),

    /*
    |--------------------------------------------------------------------------
    | Client Authorization Callback
    |--------------------------------------------------------------------------
    |
    | When making authorization requests to the DOVU platform a client callback
    | endpoint is required to correctly process the user request code and to
    | link the DOVU platform to the third party app.
    |
    */

    'app_callback' => env('DOVU_API_CLIENT_CALLBACK', config('app.url') . '/callback'),

    /*
    |--------------------------------------------------------------------------
    | DOVU API Client Id
    |--------------------------------------------------------------------------
    |
    | The Client Id that has been created from the DOVU portal, as a parter
    | creating an app to connect users to the DOVU platform.
    |
    */

    'client_id' => env('DOVU_API_CLIENT_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | DOVU API Client Secret
    |--------------------------------------------------------------------------
    |
    | The Client Secret for a third party app to connect users to the DOVU platform.
    | Do not commit the secret to source control.
    |
    */

    'client_secret' => env('DOVU_API_CLIENT_SECRET'),

];
