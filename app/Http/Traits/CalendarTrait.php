<?php

namespace App\Http\Traits;
use App\Services\Google;
use Carbon\Carbon;

trait CalendarTrait
{
    protected $google;

    public function __construct(Google $google)
    {
        $this->google = $google;
    }

    public function setService()
    {
        $client = auth()->user()->googleAccount;
        $service = $this->google->connectUsing($client->token)->service('Calendar');
        return $service;
    }

    public function getCalendars()
    {
        $service = $this->setService();
        $calendars = $service->calendarList->listCalendarList();
        return $calendars;
    }

    protected function isAllDayEvent($googleEvent)
    {
        return ! $googleEvent->start->dateTime && ! $googleEvent->end->dateTime;
    }

    protected function parseDatetime($googleDatetime)
    {
        $rawDatetime = $googleDatetime->dateTime ?: $googleDatetime->date;

        return Carbon::parse($rawDatetime)->setTimezone('UTC');
    }
}