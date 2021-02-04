<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApartmentTrait;
use App\Http\Traits\UserTrait;
use App\Models\Apartments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class ApartmentsController extends Controller
{
    use ApartmentTrait, UserTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartments = $this->getApartments();
        $owners = User::where('type', 'owner')->get();
        return view('admin.apartments.apartments', ['apartments' => $apartments, 'owners' => $owners]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validateData = $this->validateApartmentData($data);
        try {
            $user = User::find($data['apartment-owner']);
            $user->apartments()->create([
                'name' => $data['apartment-name'],
                'type' => $data['apartment-type'],
                'description' => $data['apartment-description'],
                'max_guests' => $data['max-guests'],
                'beds' => $data['beds'],
                'address' => $data['apartment-address'],
                'country' => $data['apartment-country'],
            ]);
            return redirect('admin/apartments')->with('success', 'Apartment created successfully');
        } catch (QueryException $e) {
            return redirect('admin/apartments')->with(['error'=>$e->errorInfo[2]]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apartments  $apartments
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $apartment = $this->getApartment($request->id);
        $owner = $apartment->user;
        $rates = $apartment->rates;
        $owners = $this->getUsers('owner');
        return view('admin.apartments.apartment', ['apartment' => $apartment, 'owner' => $owner, 'rates' => $rates, 'owners' => $owners]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Apartments  $apartments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apartments $apartments)
    {
        $data = $request->all();
        $validateData = $this->validateApartmentData($data);
        $apartment = $apartments->find($request->id);
        $apartment->user_id = $request->input('apartment-owner');
        $apartment->name = $request->input('apartment-name');
        $apartment->type = $request->input('apartment-type');
        $apartment->description = $request->input('apartment-description');
        $apartment->max_guests = $request->input('max-guests');
        $apartment->beds = $request->input('beds');
        $apartment->address = $request->input('apartment-address');
        $apartment->country = $request->input('apartment-country');
        $apartment->save();
        return redirect()->route('apartment', $request->id)->with('success', 'Apartment edited succesfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apartments  $apartments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartments $apartments, Request $request)
    {
        $apartment = $apartments->find($request->id);
        $apartment->delete();
        return redirect()->route('apartments')->with('success', "Apartment deleted succesfully");
    }
}
