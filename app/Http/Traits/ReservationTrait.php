<?php

namespace App\Http\Traits;
use App\Models\Reservation;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

trait ReservationTrait
{
    public function checkAvailability($apartment, $start, $end)
    {
        $period = CarbonPeriod::create($start, $end);
        $result = collect([]);
        $previousDate = null;
        foreach ($period as $date):
            $date->format('Y-m-d H:i:s');
            $checkins = Reservation::where([['apartments_id', $apartment], ['status', 'reserved']])->whereDate('checkin', $date)->count();
            $checkouts = Reservation::where('apartments_id', $apartment)->whereDate('checkout', $date)->where('status', 'reserved')->orWhere('status', 'checkedin')->count();
            $available = $checkins > $checkouts ? $checkins - $checkouts : $checkouts - $checkins;
            if($checkins > 0):
                $result->put('current_date', $date->format('Y-m-d'));
                $result->put('reservations', $available);
                $result->put('available_date', $previousDate);
                return $result->all();
            endif;
            $previousDate = $date->format('Y-m-d');
        endforeach;  
        return $result->all();
    }
}