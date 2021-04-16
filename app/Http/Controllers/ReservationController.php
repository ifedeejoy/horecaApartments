<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\Apartments;
use App\Http\Traits\GuestTrait;
use App\Models\ReservationPayment;
use Illuminate\Database\QueryException;
use App\Http\Traits\ReservationTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    use GuestTrait, ReservationTrait;
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

    public function availabilityCheck(Request $request)
    {
        $availability = $this->checkAvailability($request->input('apartment'), $request->input('start'), $request->input('end'));
        return response()->json(['data' => $availability]);
    }

    public function webAvailability(Request $request)
    {
        $guests = $request->input('guests');
        $availability = $this->websiteApartmentsAvailability($request->input('start'), $request->input('end'), $guests);
        return response()->json([
            'status' => true,
            'message' => "reservations retrieved",
            'data' => $availability,
            'start' => Carbon::createFromFormat('m/d/Y', $request->input('start'), 'Africa/Lagos')->format('Y-m-d'),
            'end' => Carbon::createFromFormat('m/d/Y', $request->input('end'), 'Africa/Lagos')->format('Y-m-d')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $guests = Guest::all();
        $apartments = Apartments::all();
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
        try {
                if($request->is('api/new-reservation')):
                    $reference = $request->input('reference');
                    $guest = $request->input('guest');
                    $user = $request->input('createdBy');
                else:
                    $reference = mt_rand();
                    $user = Auth::user()->id;
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
                endif;

                $deposit = empty($request->input('deposit')) ? 0 : $request->input('deposit');
                $discount = empty($request->input('discount')) ? 0 : $request->input('discount');
                
                //insert reservation details
                DB::beginTransaction();
                    for($i = 0; $i < count($request->input('apartment')); $i++):
                        DB::table('reservations')->insert([
                            'reference' => $reference,
                            'apartments_id' => $request->input('apartment')[$i],
                            'rate_id' => $request->input('rates')[$i],
                            'checkin' => $request->input('arrival')[$i],
                            'checkout' => $request->input('departure')[$i],
                            'nights' => $request->input('nights')[$i],
                            'occupants' => $request->input('occupants')[$i],
                            'status' => $request->input('status')[$i],
                            'extras' => $request->input('extras')[$i],
                            'source' => $request->input('reservation-source'),
                            'guest_id' => $guest,
                            'createdBy' => $user,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                        DB::table('reservation_payments')->insert([
                            'reference' => $reference,
                            'guest_id' => $guest,
                            'payment_status' => $request->input('payment-status'),
                            'payment_method' => $request->input('payment-method'),
                            'service_charge' => $request->input('service-charge'),
                            'discount_reason' => $request->input('discount-reason'),
                            'discount_amount' => $discount,
                            'total' => removeCommas($request->input('total')),
                            'paid' => removeCommas($deposit),
                            'balance' => removeCommas($request->input('balance')),
                            'createdBy' => $user,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                    endfor;
                DB::commit();
            if($request->is('api/new-reservation')):
                return response()->json([
                    'status' => 'success',
                    'message' => 'Reservation made successfully',
                    'redirect_url' => 'http://hcapartments.test/invoice/'.$reference, 
                ]);
            else:
                return redirect('front-desk/invoice/'.$reference)->with('success', 'Reservation made successfully');
            endif;
        } catch (QueryException $e) {
            DB::rollBack();
            if($request->is('api/new-reservation')):
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Reservation not made',
                    'error' => $e->errorInfo[2], 
                ]);
            else:
                return back()->withErrors([$e->errorInfo[2]]);
            endif;
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
        if($request->is('front-desk/invoice/*') || $request->is('print-invoice/*') || $request->is('invoice/*')):
            $reservation = Reservation::where('reference', $request->reference)->with('apartments', 'rate', 'reservationPayments', 'guest', 'staff')->get();
            if($request->is('invoice/*')):
                $view = 'invoice';
            else:
                $view = $request->is('print-invoice/*') ? 'front-desk.print-invoice' : 'front-desk.invoice';
            endif;
            return response(view($view, ['reservations' => $reservation]))
                    ->header('X-FRAME-OPTIONS', 'ALLOW FROM https://kimberlys.ng/*');
        else:
            $apartments = Apartments::where('status', 'available')->get();
            $reservation = Reservation::where('id', $request->id)->with('apartments', 'rate', 'reservationPayments', 'guest', 'staff')->first();
            return view('front-desk.reservation')->with(['reservation' => $reservation, 'apartments' => $apartments]);
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
        try {
            $reference = $request->input('reference');

            // fetch previous reservation 
            $previousPayment = ReservationPayment::where('reference', $reference)->first();
            $reservationDetail = $reservation->find($request->id);
            $rate = $reservationDetail->rate->amount;
            $nights = $reservationDetail->nights;
            $oldPrice = $rate * $nights;

            // payment calculation
            $newTotal = removeCommas($request->input('total'));
            $deductedTotal = $previousPayment->total - $oldPrice;
            $finalTotal = $deductedTotal + $newTotal;

            //update reservation details
            $deposit = empty($request->input('deposit')) ? 0 : $request->input('deposit');
            $discount = empty($request->input('discount')) ? 0 : $request->input('discount');
            DB::beginTransaction();
                DB::table('reservations')->where('id', $request->id)->update([
                    'apartments_id' => $request->input('apartment'),
                    'rate_id' => $request->input('rates'),
                    'checkin' => $request->input('arrival'),
                    'checkout' => $request->input('departure'),
                    'nights' => $request->input('nights'),
                    'occupants' => $request->input('occupants'),
                    'status' => $request->input('status'),
                    'extras' => $request->input('extras'),
                    'source' => $request->input('reservation-source'),
                    'modifiedBy' => Auth::user()->id,
                    'updated_at' => Carbon::now()
                ]);
                DB::table('reservation_payments')->where('reference', $reference)->update([
                    'payment_status' => $request->input('payment-status'),
                    'payment_method' => $request->input('payment-method'),
                    'discount_amount' => $discount,
                    'total' => $finalTotal,
                    'paid' => removeCommas($deposit),
                    'balance' => removeCommas($request->input('balance')),
                    'createdBy' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            DB::commit();
            return redirect('front-desk/reservation/'.$request->id)->with('success', 'Reservation updated successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return back()->withErrors([$e->errorInfo[2]]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation, Request $request)
    {
        $res = $reservation->find($request->id);
        $reference = $res->reference;
        $countReservations = $res->where('reference', $reference)->count();
        if($countReservations > 1):
            $previousPayment = ReservationPayment::where('reference', $reference)->first();
            $rate = $res->rate->amount;
            $nights = $res->nights;
            $reservationPrice = $rate * $nights;
            $newTotal = $previousPayment->total - $reservationPrice;
            $balance = $previousPayment->balance != 0 ? $newTotal - $previousPayment->paid : $previousPayment->balance;
            $paid = $previousPayment->paid >= $previousPayment->total ? $previousPayment->paid - $newTotal : $previousPayment->paid;
            $previousPayment->update(['total' => $newTotal, 'balance' => $balance, 'paid' => $paid]);
            if($previousPayment->wasChanged()):
                return redirect('front-desk/reservations')->with('success', 'Reservation deleted successfully');
            else:
                return redirect('front-desk/reservations')->with('success', 'Error deleting reservation');
            endif;
        else:
            $res->delete();
            ReservationPayment::where('reference', $reference)->delete();
            return redirect('front-desk/reservations')->with('success', 'Reservation deleted successfully');
        endif;
    }
}
