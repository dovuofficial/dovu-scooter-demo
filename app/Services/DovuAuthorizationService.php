<?php

namespace App\Services;

use App\User;
use App\DovuToken;
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
    * Get an access code after a successful login with the DOVU API
    * the auth code is used to retrived an access token where the service
    * will have permission to deliver actions based on the proposed scope
    * of the partner app.
    *
    * @param string authorization code from the login request from DOVU
    * @return string OAuth access token to be generated from code.
    **/
    public function requestAccessToken(string $auth_code)
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
    * Create a link from a user to a newly created DOVU access_token. The
    * responibility of persistance have been separated from requestAccessToken
    * as there could be alternative methods of storing these tokens.
    *
    * @param string user_id or reference to link to the DOVU token
    * @param string access token created via DOVU
    * @return \App\DovuToken reference to the newly created DOVU reference.
    **/
    public function createDovuTokenLink(string $user_id, string $token)
    {
        // error_log($token);

        return DovuToken::updateOrCreate(
            [ 'user_id' => $user_id ],
            [ 'token' => $token ]
        );
    }

    /**
    * Ensure that a given token connected to an third party app user is
    * valid and can correctly link to the DOVU ecosystem.
    *
    * @param \App\User
    **/
    public function validateToken(User $user)
    {
        if (!$user->dovu) {
            return false;
        }

        $auth_token_route = config('dovu.api_url') . '/api/token/authorized';

        $http = new Client;
        $response = $http->get($auth_token_route, [
            'http_errors' => false,
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $user->dovu->token,
            ],
        ]);

        return $response->getStatusCode() === Response::HTTP_OK;
    }
}
