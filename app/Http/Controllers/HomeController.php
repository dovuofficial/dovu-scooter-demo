<?php

namespace App\Http\Controllers;

use App\User;
use App\Services\DovuAuthorizationService;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = \Auth::User();
        $valid_dovu_token = (new DovuAuthorizationService())->validateToken($user);

        if ($valid_dovu_token) {
            return redirect('/issue/create');
        }

        return view('home');
    }
}
