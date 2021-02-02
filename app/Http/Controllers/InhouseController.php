<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Guest;
use App\Models\Apartments;
use App\Models\GuestPayment;
use Illuminate\Database\QueryException;
use App\Models\ReservationPayment;
use App\Models\Inhouse;
use App\Http\Traits\ReservationTrait;
use Carbon\Carbon;
use App\Models\Rate;

class InhouseController extends Controller
{
    use ReservationTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inhouseGuests = Reservation::where('status', 'checkedin')->with('reservationPayments', 'guest', 'apartments')->get();
        if($request->is('api/inhouse-guests')):
            return response()->json(['data' => $inhouseGuests]);
        else:
            return view('front-desk.inhouse-guests')->with('guests', $inhouseGuests);
        endif;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $guests = Guest::all();
        $apartments = Apartments::where('status', 'available')->get();
        return view('front-desk.new-checkin')->with(['guests' =>$guests, 'apartments' => $apartments]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function addBill(Request $request, $id)
    {
        $request->validate([
            'service' => 'required',
            'price' => 'required|integer',
            'description' => 'required',
            'payment-time' => 'required'
        ]);
        try {
            $reservation = Reservation::findOrFail($id);
            $guest = $reservation->guest_id;
            $status = $request->input('payment-time') == 'Instant' ? 'paid' : 'unpaid';
            $reservation->guestBill()->create([
                'guest_id' => $guest,
                'service' => $request->input('service'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'status' => $status
            ]);
            if($status == 'paid'):
                $payment = new GuestPayment;
                $payment->reservation_id = $id;
                $payment->guest_id = $guest;
                $payment->type = $request->input('service').' Payment';
                $payment->description = $request->input('description');
                $payment->payment_method = $request->input('payment-method');
                $payment->amount = $request->input('price');
                $payment->save();
            elseif($status == 'unpaid'):
                $payments = ReservationPayment::where('reference', $reservation->reference)->firstOrFail();
                $balance = $payments->balance + $request->input('price');
                $payments->balance = $balance;
                $payments->save();
            endif;
            return back()->with('success', 'Guest bill updated successfully');
        } catch (QueryException $e) {
            return back()->with('error', $e->errorInfo[2]);
        }
    }

    public function addPayment(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|integer',
            'payment-method' => 'required'
        ]);
        try {
            $reservation = Reservation::findOrFail($id);
            $guest = $reservation->guest_id;
            $reservation->guestPayment()->create([
                'guest_id' => $guest,
                'payment_method' => $request->input('payment-method'),
                'type' => 'Additional Payment',
                'description' => $request->input('description'),
                'amount' => $request->input('amount')
            ]);
            $payments = ReservationPayment::where('reference', $reservation->reference)->firstOrFail();
            $balance = $payments->balance - $request->input('amount');
            $paid = $payments->paid + $request->input('amount');
            $payments->balance = $balance;
            $payments->paid = $paid;
            $payments->save();
            return back()->with('success', 'Guest payment updated successfully');
        } catch (QueryException $e) {
            return back()->with('error', $e->errorInfo[2]);
        }
    }

    public function extendStay(Request $request, $id)
    {
        $oldCheckout = Carbon::parse($request->input('old-checkout'));
        $newCheckout = Carbon::parse($request->input('new-checkout'));
        $discount = $request->input('discount');
        $checkAvailability = $this->checkAvailability($id, $oldCheckout, $newCheckout);
        $reservation = Reservation::find($id);
        try {
            if(empty($checkAvailability)):
                $oldNights = $reservation->nights;
                $newNights = $oldCheckout->diffInDays($newCheckout);
                $rate = Rate::find($reservation->rate_id);
                $ratePrice = $rate->amount;
                $amount = $ratePrice * $newNights;
                $amount -= $discount;
                $reservation->nights = $oldNights + $newNights;
                $reservation->checkout = $newCheckout;
                $reservation->save();
                // Update price
                $reference = $reservation->reference;
                $updatePrice = ReservationPayment::where('reference', $reference)->update(['balance', $amount], ['discount', $discount]);
            else:
                return back()->with('error', "Please set the checkout date to". $checkAvailability['availability_date'] ." the apartment is not available for preferred checkout");
            endif;
        } catch (QueryException $e) {
            return back()->withErrors([$e->errorInfo[2]]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reservation = Reservation::where('id', $id)->with('apartments', 'rate', 'reservationPayments', 'guest', 'guestBill')->first();
        $paidBills = Inhouse::where(['reservation_id' => $id, 'status' => 'paid'])->sum('price');
        return view('front-desk.folio')->with(['reservation' => $reservation, 'paidBills' => $paidBills]);
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
