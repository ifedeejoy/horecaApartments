<?php

namespace App\Http\Controllers;

use App\Models\GoogleCalendar;
use Illuminate\Http\Request;
use App\Services\Google;
use App\Models\User;
use App\Http\Traits\CalendarTrait;

class GoogleCalendarController extends Controller
{
    use CalendarTrait;
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
    public function store()
    {
        $user = User::find(auth()->user()->id);
        $client = $user->googleAccount;
        $calendars = $this->getCalendars();
        foreach ($calendars as $calendar):
            $updateCalendar = $user->calendar()
                                ->updateOrCreate(
                                    ['calendar_id' => $calendar->id],
                                    [
                                        'calendar_id' => $calendar->id,
                                        'name' => $calendar->summary,
                                        'color' => $calendar->backgroundColor,
                                        'timezone' => $calendar->timeZone,
                                        'google_id' => $client->google_id,
                                    ]
                                );
        endforeach;
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GoogleCalendar  $googleCalendar
     * @return \Illuminate\Http\Response
     */
    public function show(GoogleCalendar $googleCalendar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GoogleCalendar  $googleCalendar
     * @return \Illuminate\Http\Response
     */
    public function edit(GoogleCalendar $googleCalendar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GoogleCalendar  $googleCalendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GoogleCalendar $googleCalendar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GoogleCalendar  $googleCalendar
     * @return \Illuminate\Http\Response
     */
    public function destroy(GoogleCalendar $googleCalendar)
    {
        //
    }
}
