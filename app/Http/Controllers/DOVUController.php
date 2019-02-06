<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Session;

class DovuController extends Controller
{

    public function wallet() {
        // Build the query parameter string to pass auth information to our request
        $query = http_build_query([
            'client_id' => env('DOVU_API_CLIENT_ID'),
            'redirect_uri' => env('APP_URL') . '/callback',
            'response_type' => 'code',
            'scope' => 'reward'
        ]);

        // Redirect the user to the OAuth authorization page
        return redirect(env('DOVU_API_URL') . '/oauth/authorize?' . $query);
    }

    public function callback (Request $request) {
        $http = new Client;

        $response = $http->post(env('DOVU_API_URL') . '/oauth/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => env('DOVU_API_CLIENT_ID'),
                'client_secret' => env('DOVU_API_CLIENT_SECRET'),
                'redirect_uri' => env('APP_URL') . '/callback',
                'code' => $request->code // Get code from the callback
            ]
        ]);

        $token = json_decode((string) $response->getBody(), true)['access_token'];
        Session::put('access_token', $token);
        return redirect('/issue/create');
    }
}
