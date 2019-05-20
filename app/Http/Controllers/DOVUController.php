<?php

namespace App\Http\Controllers;

use App\Services\DovuAuthorizationService;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class DovuController extends Controller
{

    private $dovu_service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->dovu_service = new DovuAuthorizationService();
    }

    public function wallet()
    {
        $authentication_link = $this->dovu_service->generateAuthenticationRequest();

        return redirect($authentication_link);
    }

    public function callback(Request $request)
    {
        $access_token = $this->dovu_service->retrieveAccessToken($request->code);

        $user = \Auth::User();
        $user->saveDovuUserToken($access_token);

        return redirect('/issue/create');
    }
}
