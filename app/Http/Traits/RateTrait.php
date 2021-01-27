<?php

namespace App\Http\Traits;

use App\Http\Resources\RateResource;
use App\Models\Rate;
use App\Models\Apartments;

trait RateTrait
{
    public function getRates(int $apartment = null)
    {
        if(is_null($apartment)):
            $rates = Rate::with('apartments')->get();
            return $rates;
        else:
            $apartment =  Apartments::where('id', $apartment)->with('rates')->get();
            if(is_null($apartment)):
                $rates = null;
            else:
                return $apartment;
            endif;
        endif;
    }

    public function getRate(int $rate)
    {
        $rate = Rate::find($rate);
        return $rate;
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