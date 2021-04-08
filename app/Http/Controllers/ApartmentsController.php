<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApartmentTrait;
use App\Http\Traits\UserTrait;
use App\Models\Apartments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\MediaAlly;
use App\Models\Reservation;

class ApartmentsController extends Controller
{
    use ApartmentTrait, UserTrait, MediaAlly;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $apartments = $this->getApartments();
        $owners = User::where('type', 'owner')->get();
        if($request->is('api/apartments')):
            return response()->json($apartments);
        endif;
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
            // process files
            $images = collect();
            if($request->hasFile('apartment-images')):
                foreach($request->file('apartment-images') as $image):
                    $upload = cloudinary()->uploadFile($image->path())->getSecurePath();
                    $images->push($upload);
                endforeach;
            endif;
            // insert data
            $user->apartments()->create([
                'name' => $data['apartment-name'],
                'type' => $data['apartment-type'],
                'description' => $data['apartment-description'],
                'max_guests' => $data['max-guests'],
                'beds' => $data['beds'],
                'address' => $data['apartment-address'],
                'country' => $data['apartment-country'],
                'images' => $images->toJson(),
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
        $reservations = Reservation::where('apartments_id', $request->id)->with('apartments', 'rate', 'reservationPayments', 'guest', 'staff')->get();
        $owners = $this->getUsers('owner');
        if($request->is('api/apartment-reservations/*')):
            return response()->json(['data' => $reservations]);
        elseif($request->is('api/apartment/*')):
            return response()->json($apartment);
        endif;
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
        // process files
        $images = collect();
        if($request->hasFile('apartment-images')):
            foreach($request->file('apartment-images') as $image):
                $upload = cloudinary()->uploadFile($image->path())->getSecurePath();
                $images->push($upload);
            endforeach;
            $apartment->images = $images->toJson();
        endif;
        // update data
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
