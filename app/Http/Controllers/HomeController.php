<?php

namespace App\Http\Controllers;

use App\Services\DovuAuthorizationService;

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

        return view('home', ['valid_dovu_token' => $valid_dovu_token]);
    }
}
