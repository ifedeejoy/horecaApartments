<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use App\Http\Traits\GuestTrait;

class GuestController extends Controller
{
    use GuestTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $guests = Guest::all();
        if($request->is('api/guests')):
            return response()->json(['data' => $guests]);
        else:
            return view('admin.users.guests')->with('guests', $guests);
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
        $createGuest = $this->createGuest($request);
        if($request->is('api/create-guest')):
            return response()->json($createGuest);
        endif;
        return $createGuest;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Guest  $guest
     * @return \Illuminate\Http\Response
     */
    public function show(Guest $guest, Request $request)
    {
        $guest = $this->guestReservations($request->id);
        if($request->is('api/guest/*')):
            return response()->json(['data' => $guest]);
        else:
            return view('admin.users.guest')->with('guest', $guest);
        endif;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Guest  $guest
     * @return \Illuminate\Http\Response
     */
    public function edit(Guest $guest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Guest  $guest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Guest $guest)
    {
        $guest = Guest::find($request->id);
        $guest->title = $request->input('title');
        $guest->name = $request->input('name');
        $guest->email = $request->input('email');
        $guest->phone = $request->input('phone');
        $guest->address = $request->input('address');
        $guest->country = $request->input('country');
        $guest->gender = $request->input('gender');
        if($guest->save() == true):
            return back()->with('success', 'Guest info updated successfully');
        else:
            return back()->with('error', 'Guest info not updated');
        endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guest  $guest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guest $guest, Request $request)
    {
        $guests = $guest->find($request->guest);
        $guests->delete();
        $deleted = $guests->trashed();
        $response = $deleted ? ['success' => 'Rate deleted succesfully'] : ['error' => 'Rate not deleted'];
        if($request->is('admin/guest/delete/*')):
            return response()->json([$response]);
        else:
            return redirect('admin/guests')->with($response);
        endif;
    }
}
