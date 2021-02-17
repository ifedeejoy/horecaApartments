<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\GoogleCalendar\Event;
use Google\Client as googleCLient;
use Google_Service_Calendar;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use App\Services\Google;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class gcalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $events = $user->events()
            ->orderBy('started_at', 'desc')
            ->get();

        return view('front-desk.events')->with('events', $events);
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

        // Use the given code to authenticate the user.
        $google->authenticate($request->get('code'));

        // Make a call to the Google+ API to get more information on the account.
        $account = $google->service('PeopleService')->people->get('people/me', array('personFields' => 'emailAddresses,names,photos'));
        // Store Auth Token
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
