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
use App\Models\Debt;
use App\Models\Postmaster;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
                $updatePrice = ReservationPayment::where('reference', $reference)->update(['total' => DB::raw("total + $amount"), 'balance' => DB::raw("balance + $amount"), 'discount_amount' => DB::raw("discount_amount + $discount")]);
                return back()->with('success', "Guest stay extended by $newNights night(s)");
            else:
                return back()->with('error', "Please set the checkout date to". $checkAvailability['available_date'] ." the apartment is not available for preferred checkout");
            endif;
        } catch (QueryException $e) {
            return back()->withErrors([$e->errorInfo[2]]);
        }
    }

    public function roomMove(Request $request, $id)
    {
        $reservation = Reservation::find($id);
        try{
            $type = $request->input('type');
            $updateOld = Apartments::where('id', $reservation->apartments_id)->update(['status' => 'available']);
            $updateNew = Apartments::where('id', $request->input('new-apartment'))->update(['status' => 'occupied']);
            $reservation->apartments_id = $request->input('new-apartment');
            $reason = empty($request->input('reason')) ? 'Guest upgraded room' : $request->input('reason');
            if($type == 'upgrade'):
                $balance = $request->input('balance');
                $updatePayment = ReservationPayment::where('reference', $reservation->reference)->update(['balance' => DB::raw("balance + $balance"), 'total' => DB::raw("total + $balance")]);
            elseif($type == 'switch'):
                $reservation->extras = $reason;
                $reservation->save();
            endif;
            DB::table('apartment_upgrades')->insert(['old_apartment' => $reservation->apartments_id, 'new_apartment' => $request->input('new-apartment'), 'reason' => $reason, 'upgradedBy' => Auth::user()->id]);
            $reservation->apartments_id = $request->input('new-apartment');
            $reservation->save();
            return back()->with('success', 'Apartment update successfully');
        }catch (QueryException $e){
            return back()->withErrors([$e->errorInfo[2]]);
        }
    }

    public function checkout(Request $request, $id)
    {
        $reservation = Reservation::find($id);
        $reference = $reservation->reference;
        $payments =  ReservationPayment::where('reference', $reference)->first();
        try {
            $type = $request->input('type');
            if($type == 'refund'):
                $amount = $payments->paid - $payments->total;
                $updatePayments = $payments->update(['refund' => $amount, 'paid' => DB::raw("paid - $amount")]);
                DB::table('refunds')->insert([
                    'guest_id' => $reservation->guest_id,
                    'reference' => $reference,
                    'amount' => $amount,
                    'refundedBy' => Auth::user()->id
                ]);
            elseif($type == 'debt'):
                $amount = $payments->balance;
                $updateDebt = Debt::create([
                    'reference' => $reference,
                    'guest_id' => $reservation->guest_id,
                    'amount' => $amount,
                    'balance' => $amount,
                    'status' => 'active',
                    'created_by' => Auth::user()->id
                ]);
            elseif($type == 'postmaster'):
                $amount = $payments->paid - $payments->total;
                $updatePostmaster = Postmaster::updateOrInsert([
                    ['guest_id' => $reservation->guest_id],
                    ['balance' => DB::raw("balance + $amount"), 'created_by' => Auth::user()->id]
                ]);
            elseif($type == 'checkout'):
                if($payments->balance > 0):
                    return response()->json(['status' => 'error', 'message' => "Guest has unpaid bills and cannot be checkedout"]);
                elseif($payments->paid > $payments->total):
                    return response()->json(['status' => 'error', 'message' => "Guest cannot be checkedout, please check guest bill for options"]);
                endif;
            endif;
            $updateApartment = Apartments::where('id', $reservation->apartments_id)->update(['status' => 'available']);
            $reservation->status = 'checkedout';
            $reservation->save();
            return redirect('front-desk/receipt/'.$reservation->id)->with('success', 'Guest checked out succesfully');
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
    public function show(Request $request, $id)
    {
        $reservation = Reservation::where('id', $id)->with('apartments', 'rate', 'reservationPayments', 'guest', 'guestBill', 'staff')->first();
        $paidBills = Inhouse::where(['reservation_id' => $id, 'status' => 'paid'])->sum('price');
        $avaiableApartments = Apartments::where('status', 'available')->get();
        if($request->is('front-desk/receipt/*')):
            return view('front-desk.receipt')->with(['reservation' => $reservation, 'paidBills' => $paidBills]);
        endif;
        return view('front-desk.folio')->with(['reservation' => $reservation, 'paidBills' => $paidBills, 'available_apartments' => $avaiableApartments]);
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
