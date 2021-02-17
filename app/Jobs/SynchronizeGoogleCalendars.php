<?php

namespace App\Jobs;

use App\Jobs\SynchronizeGoogleResource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\Google;

class SynchronizeGoogleCalendars extends SynchronizeGoogleResource implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $googleAccount;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($googleAccount)
    {
        $this->googleAccount = $googleAccount;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function getGoogleService()
    {
        return app(Google::class)
        ->connectUsing($this->googleAccount->token)
        ->service('Calendar');
    }

    public function getGoogleRequest($service, $options)
    {
        return $service->calendarList->listCalendarList($options);
    }

    public function syncItem($googleCalendar)
    {
        if ($googleCalendar->deleted) {
            return $this->googleAccount->calendars()
                ->where('google_id', $googleCalendar->id)
                ->get()->each->delete();
        }
    
        $this->googleAccount->calendars()->updateOrCreate(
            [
                'google_id' => $googleCalendar->id,
            ],
            [
                'name' => $googleCalendar->summary,
                'color' => $googleCalendar->backgroundColor,
                'timezone' => $googleCalendar->timeZone,
            ]
        );
    }
}
