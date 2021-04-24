<?php

namespace App\Http\Controllers;

use App\Models\Apartments;
use Spatie\Permission\Models\Permission;
use App\Models\Guest;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::where('status', '!=', 'checkedout')->with('apartments', 'guest')->get();
        if(Auth::check() == true):
            $user = User::find(auth()->user()->id);
            $googleAccount = $user->googleAccount;
            if(is_null($googleAccount) && $user->hasPermissionTo('create calendars')):
                $connect = Permission::where('name', 'connect google account')->count();
                if($connect < 1):
                    Permission::create(['name' => 'connect google account']);
                endif;
                $user->givePermissionTo('connect google account');
                $connected = false;
            else:
                $connected = true;
            endif;
        endif;
        if(request()->is('front-desk/calendar')):
            return view('front-desk.calendar')->with('connected', $connected);
        else:
            return response()->json(['reservations' => $reservations]);
        endif;
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
    public function store(Request $request)
    {
        //
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
