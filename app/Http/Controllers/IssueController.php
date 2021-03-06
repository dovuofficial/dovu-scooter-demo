<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateIssueRequest;
use Illuminate\Http\Request;
use App\Issue;
use GuzzleHttp\Client;
use Auth;

class IssueController extends Controller
{
    private $client;

    public function __construct ()
    {

        $this->client = new Client;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('issue.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateIssueRequest $request)
    {
        Issue::create([
            'scooter_id' => $request->scooter_id,
            'body' => $request->body,
            'user_id' => Auth::id()
        ]);

        // Pay DOV
        $token = \Auth::user()->dovu->token;
        $response = $this->client->post(env('DOVU_API_URL') . '/api/reward', [
            'headers' => ['Authorization' => 'Bearer '.$token],
            'form_params' => [
                'amount' => 10
            ]
        ]);
        flash('Thanks for submitting an issue. We have sent you a reward!')->important();
        return view('issue.create');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
