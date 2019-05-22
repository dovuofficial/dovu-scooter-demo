<?php

namespace App\Services;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Response;

/**
* Authorization Service for DOVU. This focuses on methods to generate and
* validate user tokens to link a DOVU user with a third party.
**/
class DovuAuthorizationService {

    /**
    * Generate an authentication link that will be used as an
    * OAuth login via the DOVU service. A partner service may link
    * and reward a DOVU user.
    *
    * @return string OAuth authentication link
    **/
    public function generateAuthenticationRequest()
    {
        $query = http_build_query([
            'client_id' => config('dovu.client_id'),
            'redirect_uri' => config('dovu.app_callback'),
            'response_type' => 'code',
            'scope' => config('dovu.app_scopes'),
        ]);

        return config('dovu.api_url') . '/oauth/authorize?' . $query;
    }

    /**
    * Retrieve an access code after a successful login with the DOVU API
    * the auth code is used to retrived an access token where the service
    * will have permission to deliver actions based on the proposed scope
    * of the partner app.
    *
    * @param string authorization code from the login request from DOVU
    **/
    public function retrieveAccessToken(string $auth_code)
    {
        $http = new Client;
        $response = $http->post(config('dovu.api_url') . '/oauth/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => config('dovu.client_id'),
                'client_secret' => config('dovu.client_secret'),
                'redirect_uri' => config('dovu.app_callback'),
                'code' => $auth_code,
            ]
        ]);

        $result = json_decode($response->getBody()->getContents());

        return $result->access_token;
    }

    /**
    * Ensure that a given token connected to an third party app user is
    * valid and can correctly link to the DOVU ecosystem.
    *
    * @param \App\User
    **/
    public function validateToken(User $user)
    {
        $dovu_token = $user->dovu_user_token;

        if (!$dovu_token) {
            return false;
        }

        $auth_token_route = config('dovu.api_url') . '/api/token/authorized';

        $http = new Client;
        $response = $http->get($auth_token_route, [
            'http_errors' => false,
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $dovu_token,
            ],
        ]);

        return $response->getStatusCode() === Response::HTTP_OK;
    }
}
