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
        $user = \Auth::user();
        $dovu = $this->dovu_service;
        $token = $dovu->requestAccessToken($request->code);

        $dovu->createDovuTokenLink($user->id, $token);

        return redirect('/home');
    }
}
