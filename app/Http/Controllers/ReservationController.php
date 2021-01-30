<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\Apartments;
use App\Http\Traits\GuestTrait;
use App\Models\ReservationPayment;
use Illuminate\Database\QueryException;

class ReservationController extends Controller
{
    use GuestTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $reservations = Reservation::where('status', 'reserved')->with('reservationPayments', 'guest', 'apartments')->get();
        if($request->is('api/reservations')):
            return response()->json(['data' => $reservations]);
        else:
            return view('front-desk.reservations')->with('reservations', $reservations);
        endif;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $guests = Guest::all();
        $apartments = Apartments::where('status', 'available')->get();
        return view('front-desk.new-reservation')->with(['guests' =>$guests, 'apartments' => $apartments]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // create guest profile
        $createGuest = $this->createGuest($request->all());
        if(is_array($createGuest)):
            if($createGuest['status'] == 'successful'):
                $guest = $createGuest['id'];
            else:
                return back()->with('error', $createGuest['message']);
            endif;
        else:
            return $createGuest;
        endif;
        
        // // insert reservation details
        try {
            $reservations = new Reservation;
            $reference = mt_rand();
            for($i = 0; $i < count($request->input('apartment')); $i++):
                $reservations->reference = $reference;
                $reservations->apartments_id = $request->input('apartment')[$i];
                $reservations->rate_id = $request->input('rates')[$i];
                $reservations->checkin = $request->input('arrival')[$i];
                $reservations->checkout = $request->input('departure')[$i];
                $reservations->nights = $request->input('nights')[$i];
                $reservations->occupants = $request->input('occupants')[$i];
                $reservations->status = $request->input('status')[$i];
                $reservations->extras = $request->input('extras')[$i];
                $reservations->source = $request->input('reservation-source');
                $reservations->guest_id = $guest;
                $reservations->createdBy = 1;
                $reservations->save();
            endfor;
            // Insert reservation payment
            $payment = new ReservationPayment;
            $payment->reference = $reference;
            $payment->guest_id = $guest;
            $payment->payment_status = $request->input('payment-status');
            $payment->payment_method = $request->input('payment-method');
            $payment->service_charge = $request->input('service-charge');
            $payment->discount_reason = $request->input('discount-reason');
            $payment->discount_amount = $request->input('discount');
            $payment->total = removeCommas($request->input('total'));
            $payment->paid = removeCommas($request->input('deposit'));
            $payment->balance = removeCommas($request->input('balance'));
            $payment->createdBy = 1;
            $payment->save();
            return redirect('front-desk/invoice/'.$reservations->reference)->with('success', 'Reservation made successfully');
        } catch (QueryException $e) {
            return back()->withErrors([$e->errorInfo[2]]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkinGuest(Request $request)
    {
        try {
            $reservation = Reservation::find($request->input('reservation'));
            $reservation->status = 'checkedin';
            $reservation->save();
            $apartment = Apartments::find($reservation->apartments_id);
            $apartment->status = 'occupied';
            $apartment->save();
            if($request->is('checkin-guest/*')):
                return response()->json(['status' => 'success', 'message' => 'Guest checked in succesfully']);
            else:
                return redirect('front-desk/inhouse-guests')->with('success', 'Guest checked in succesfully');
            endif;
        } catch (QueryException $e) {
            if($request->is('checkin-guest/*')):
                return response()->json(['status' => 'error', 'message' => $e->errorInfo[2]]);
            else:
                return redirect('front-desk/inhouse-guests')->with('error', $e->errorInfo[2]);
            endif;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation, Request $request)
    {
        if($request->is('front-desk/invoice/*') || $request->is('print-invoice/*')):
            $reservation = Reservation::where('reference', $request->reference)->with('apartments', 'rate', 'reservationPayments', 'guest')->get();
            $view = $request->is('print-invoice/*') ? 'front-desk.print-invoice' : 'front-desk.invoice';
            return view($view)->with('reservations', $reservation);
        else:
            $reservation = Reservation::where('id', $request->id)->with('apartments', 'rate', 'reservationPayments', 'guest')->first();
            return view('front-desk.reservation')->with('reservation', $reservation);
        endif;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
