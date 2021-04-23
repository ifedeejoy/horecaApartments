<?php

namespace App\Http\Controllers;

use App\Models\GoogleAccount;
use Illuminate\Http\Request;
use Google_Client;
use App\Models\User;
use App\Services\Google;

class GoogleAccountController extends Controller
{
    protected $client;

    public function __construct()
    {

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Google $google)
    {
        if(!$request->has('code')):
            return redirect($google->createAuthUrl());
        endif;

        $google->fetchAccessTokenWithAuthCode($request->get('code'));
        $account = $google->service('PeopleService')->people->get('people/me', array('personFields' => 'emailAddresses,names,photos'));
        $user = User::find(auth()->user()->id);
        $user->googleAccount()->updateOrCreate(
            [
                // Map the account's id to the `google_id`.
                'google_id' => $account->names[0]->metadata->source->id,
            ],
            [
                'google_id' => $account->names[0]->metadata->source->id,

                // Use the first email address as the Google account's name.
                'email' => head($account->emailAddresses)->value,
                
                // Last but not least, save the access token for later use.
                'token' => $google->getAccessToken(),
            ]
        );
        return redirect()->route('calendar'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GoogleAccount  $googleAccount
     * @return \Illuminate\Http\Response
     */
    public function show(GoogleAccount $googleAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GoogleAccount  $googleAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(GoogleAccount $googleAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GoogleAccount  $googleAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GoogleAccount $googleAccount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GoogleAccount  $googleAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(GoogleAccount $googleAccount)
    {
        //
    }
}
