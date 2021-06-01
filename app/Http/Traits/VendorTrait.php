<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Validator;
use App\Models\Vendor; 

trait VendorTrait
{
    public function createVendor(object $data, string $type) :object
    {
        $validator = Validator::make($data->all(), [
            'name' => 'required|max:255',
            'phone' => 'required|unique:vendors|max:14',
            'address' => 'required',
        ]);
        if($validator->fails()):
            return back()->withErrors($validator)->withInput();
        endif;

        $vendor = Vendor::create([
            'name' => $data->input('name'),
            'phone' => $data->input('phone'),
            'email' => $data->input('email'),
            'address' => $data->input('address'),
            'business_name' => $data->input('business-name'),
            'type' => $type
        ]);

        return $vendor;
    }
}