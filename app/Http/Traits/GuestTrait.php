<?php

namespace App\Http\Traits;

use App\Models\Guest;
use App\Models\Reservation;
use App\Models\GuestPayment;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

trait GuestTrait
{
    public function getGuests()
    {
        $guests = Guest::all();
        return $guests;
    }

    public function getGuest($id)
    {
        $guest = Guest::find($id);
        return $guest;
    }

    public function guestReservations(int $id)
    {
        $guest = Guest::find($id);
        $reservations = Reservation::where('guest_id', $id)->with('reservationPayments', 'guestPayment')->get();
        $result = collect([$guest, $reservations]);
        return $result;
    }

    public function createGuest($data)
    {
        $validated = Validator::make($data, [
            'name' => 'required',
            'phone' => 'required|max:25'
        ]);
        if($validated->fails()):
            return back()->withErrors($validated->errors());
        endif;
        try {
            $guest = Guest::firstOrCreate(
                ['phone' => $data['phone']],
                [ 
                    'title' => $data['title'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'address' => $data['address'],
                    'country' => $data['country'],
                    'gender' => $data['gender'],
                    'id_type' => $data['id_type'],
                ]
            );
            $result = collect(['status' => 'successful', 'message' => 'Guest profile created', 'id' => $guest->id]);
        } catch (QueryException $e) {
            $result = collect(['status' => 'failed', 'message' => $e->errorInfo]);
        }
        return $result->all();
    }

    public function apiResponse($data)
    {
        if(validateJson($data) == true):
            return $data;
        else:
            return response()->json(['data' => $data]);
        endif;
    }
}