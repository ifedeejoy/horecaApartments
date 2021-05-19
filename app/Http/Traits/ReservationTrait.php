<?php

namespace App\Http\Traits;
use App\Models\Reservation;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Apartments;
use Illuminate\Support\Facades\DB;

trait ReservationTrait
{
    public function checkAvailability($apartment, $start, $end) :object
    {
        // parse date
        $startObject = Carbon::createFromFormat('Y-m-d H:i', $start, 'Africa/Lagos');
        $endObject = Carbon::createFromFormat('Y-m-d H:i', $end, 'Africa/Lagos');
        $start = strtotime($startObject->format('Y-m-d'));
        $end = strtotime($endObject->format('Y-m-d'));

        // retrieve apartment reservations 
        $reservationsWithin = DB::table('reservations')->where('apartments_id', $apartment)->whereRaw("UNIX_TIMESTAMP(DATE(checkout)) >= $end AND UNIX_TIMESTAMP(DATE(checkin)) <= $start")->get();
        $checkins = DB::table('reservations')->where('apartments_id', $apartment)->whereRaw("UNIX_TIMESTAMP(DATE(checkin)) <= $end AND UNIX_TIMESTAMP(DATE(checkin)) >= $start")->get();
        $checkouts = DB::table('reservations')->where('apartments_id', $apartment)->whereRaw("UNIX_TIMESTAMP(DATE(checkout)) <= $end AND UNIX_TIMESTAMP(DATE(checkout)) >= $start")->get();

        // merger reservations that overlap the provided range
        $reservations = $checkouts->merge($reservationsWithin, $checkins);
        $result = collect();
        
        // process reservations
        if($reservations->count() > 0):
            // sort reservations and get last checkout date
            $sorted = $reservations->sortBy('checkout');
            $checkoutDates = $sorted->pluck('checkout');

            // process dates and get difference between checkout dates
            $firstCheckout = Carbon::parse($checkoutDates->first());
            $lastCheckout = Carbon::parse($checkoutDates->last());
            $difference = $firstCheckout->diffInDays($lastCheckout);

            // if difference is greater than zero then there's a alternative available date
            if($difference > 0):
                $result->put('checkin', ($firstCheckout->addHours(3))->format('Y-m-d H:m'));
                $result->put('checkout', ($lastCheckout->subHours(3))->format('Y-m-d H:m'));
                $result->put('nights', $difference);
            else:
                $result->put('checkin', Carbon::parse(($sorted->values()->last())->checkout)->format('Y-m-d H:m'));
                $result->put('checkout', (Carbon::parse(($sorted->values()->last())->checkout)->addDay())->format('Y-m-d H:m'));
                $result->put('nights', null);
            endif;
        endif;
        return $result;
    }

    public function websiteApartmentsAvailability(string $start, string $end, int $guests) :object
    {
        // parse date
        $startObject = Carbon::createFromFormat('m/d/Y', $start, 'Africa/Lagos');
        $endObject = Carbon::createFromFormat('m/d/Y', $end, 'Africa/Lagos'); 
        $start = strtotime($startObject->format('Y-m-d'));
        $end = strtotime($endObject->format('Y-m-d'));
       
        // retrieve reservations that overlap the provided date range
        $reservationsWithin = DB::table('reservations')->whereRaw("UNIX_TIMESTAMP(DATE(checkout)) >= $end AND UNIX_TIMESTAMP(DATE(checkin)) <= $start")->get();
        $checkins = DB::table('reservations')->whereRaw("UNIX_TIMESTAMP(DATE(checkin)) <= $end AND UNIX_TIMESTAMP(DATE(checkin)) >= $start")->get();
        $checkouts = DB::table('reservations')->whereRaw("UNIX_TIMESTAMP(DATE(checkout)) <= $end AND UNIX_TIMESTAMP(DATE(checkout)) >= $start")->get();

        // merge reservations that overlap the provided range
        $reservations = $checkouts->merge($reservationsWithin, $checkins);

        // merge reservations and return just the id of apartments that overlap the provided the date range
        $reservations = $checkouts->merge($reservationsWithin, $checkins);
        $exempt = collect();
        $exempted = collect();
        foreach($reservations as $reservation):
            $exempt->push($reservation->apartments_id);
            $exempted->push(['apartment' => $reservation->apartments_id, 'checkout' => $reservation->checkout]);
        endforeach;
        
        // retrieve available apartments
        $apartments = Apartments::whereNotIn('id', $exempt->all())->where('max_guests', '>=' ,$guests)->with('rates')->get();
        $availableApartments = collect();
        foreach($apartments as $apartment):
            $rate = $apartment->rates->first();
            $availableApartments->push([
                'id' => $apartment->id,
                'others' => false,
                'name' => $apartment->name,
                'description' => $apartment->description,
                'beds' => $apartment->beds,
                'address' => $apartment->address,
                'country' => $apartment->country,
                'images' => $apartment->images,
                'rate' => $rate->amount,
                'available_from' => Carbon::now()->diffForHumans(),
                'checkin' => $startObject->format('Y-m-d'),
                'checkout' => $endObject->format('Y-m-d'),
            ]);
        endforeach;

        // retrieve unavailable apartments to be suggested to the user based on their search 
        $exemptedApartments = Apartments::whereIn('id', $exempted->pluck('apartment'))->where('max_guests', '>=' ,$guests)->with('rates')->get();
        $unavailableApartments = collect();
        foreach($exemptedApartments as $apartment):
            $rate = $apartment->rates->first();
            $checkout = $exempted->where('apartment', $apartment->id)->pluck('checkout');
            $unavailableApartments->push([
                'id' => $apartment->id,
                'others' => true,
                'name' => $apartment->name,
                'description' => $apartment->description,
                'beds' => $apartment->beds,
                'address' => $apartment->address,
                'country' => $apartment->country,
                'images' => $apartment->images,
                'rate' => $rate->amount,
                'available_from' => Carbon::parse($checkout[0], 'Africa/Lagos')->diffForHumans(),
                'checkin' => Carbon::parse($checkout[0], 'Africa/Lagos')->addHours(4),
                'checkout' => Carbon::parse($checkout[0], 'Africa/Lagos')->addDays(3),
            ]);
        endforeach;
        return $availableApartments->merge($unavailableApartments);
    }
}