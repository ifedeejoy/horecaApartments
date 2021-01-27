<?php

namespace App\Http\Traits;
use App\Models\Apartments;
use Illuminate\Support\Facades\Validator;

trait ApartmentTrait 
{
    public function getApartments()
    {
        // Get all apartments
        $apartments = Apartments::all();
        // return apartments
        return $apartments;
    }

    public function getApartment(int $id)
    {
        $apartment = Apartments::find($id);
        return $apartment;
    }

    public function validateApartmentData(array $data)
    {
        $validateData = Validator::make($data,[
            'name' => 'required',
            'type' => 'required',
            'owner_id' => 'integer|required'
        ]);
        // validate input
        return $validateData;
    }
}