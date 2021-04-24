<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\Google;
use App\Http\Traits\CalendarTrait;
use App\Models\Event;
use App\Models\GoogleCalendar;
use App\Models\User;

class EventController extends Controller
{
    use CalendarTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $events = Event::all();
        return response()->json(['data' => $events]);
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
    public function store(Request $request, Event $event, GoogleCalendar $gcal, Google $google)
    {
        $service  = $this->setService();
        $calendars = $this->getCalendars();
        $options = array(
            'maxResults' => 30,
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => date('c'),
        );
        // get events
        $listEvents = collect();
        foreach ($calendars as $calendar):
            $events = $service->events->listEvents($calendar->id, $options);
            foreach ($events as $event):
                $listEvents->push($event);
            endforeach;
        endforeach;
        $listEvents->all();
        // events
        $events = collect();
        dd($listEvents);
        foreach($listEvents as $event):
            if($event->status == 'cancelled'):
                $event->where('google_id', $event->id)->delete();
            endif;
            if(!empty($event->description) || !empty($event->summary)):
                $checkEvent = Event::where('google_id', $event->id)->count();
                $description = is_null($event->description) ? $event->description : $event->summary;
                if($checkEvent < 1):
                    $calendar->event()->updateOrCreate(
                        ['google_id' => $event->id],
                        [
                            'name' => $event->summary,
                            'description' => $description,
                            'allday' => $this->isAllDayEvent($event), 
                            'started_at' => $this->parseDatetime($event->start), 
                            'ended_at' => $this->parseDatetime($event->end), 
                            'user_id' => auth()->user()->id,
                            'calendar_id' => $event->creator->email,
                            'google_id' => $event->id,
                        ]
                    );
                endif;
            endif;
        endforeach;
        return redirect('front-desk/calendar');
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
