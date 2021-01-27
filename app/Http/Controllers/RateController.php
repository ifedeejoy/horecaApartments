<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use Illuminate\Http\Request;
use App\Http\Traits\RateTrait;
use App\Models\Apartments;
use Facade\FlareClient\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class RateController extends Controller
{
    use RateTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->is('api/rates/*')):
            $rates = $this->getRates($request->apartment);
            $response = $this->apiResponse($rates);
            return $response;
        elseif($request->is('api/rates')):
            $rates = $this->getRates();
            $response = $this->apiResponse($rates);
            return $response;
        elseif($request->is('admin/rates')):
            $apartments = Apartments::all();
            return view('admin.apartments.rates', ['apartments' => $apartments]);
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
        try {
            $validate = $request->validate([
                'name' => 'required',
                'amount' => 'required',
                'apartment' => 'required'
            ]);
            $apartment = Apartments::find($request->input('apartment'));
            $rate = $apartment->rates()->create([
                'name' => $request->input('name'),
                'amount' => $request->input('amount')
            ]);
            return redirect('admin/rates')->with('success', 'Rate created successfully');
        } catch (QueryException $e) {
            return redirect('admin/rates')->with(['error'=>$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // exclusively returns JSON response
        $rate = $this->getRate($request->rate);
        $rate = $this->apiResponse($rate);
        return $rate;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function edit(Rate $rate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rate $rate)
    {
        $rates = $rate->find($request->input('rate'));
        $oldPrice = $rates->amount;
        $rates->amount = $request->input('rate-price');
        $save = $rates->save();
        if($save == true):
            DB::table('rate_updates')->insert([
                'rate_id' => $rates->id,
                'new_price' => $request->input('rate-price'),
                'old_price' => $oldPrice
            ]);
        endif;
        return redirect("admin/apartment/$rates->apartments_id")->with('success', 'Rate updated succesfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rate $rate, Request $request)
    {
        $rates = $rate->find($request->rate);
        $rates->delete();
        if($rates->trashed()):
            return response()->json(['success' => 'Rate deleted succesfully']);
        else:
            return response()->json(['error' => 'Rate not deleted']);
        endif;
        
    }
}
