<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Traits\VendorTrait;

class VendorController extends Controller
{
    use VendorTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->type)):
            $vendors = Vendor::where('type', $request->type)->get();
        else:
            $vendors = Vendor::all();
        endif;
        return view('admin.vendors.vendors')->with('vendors', $vendors);
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
        $this->createVendor($request, $request->input('type'));
        return back()->with('success', 'Vendor profile created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        $purchases = null;
        $issues = null;
        $payments = $vendor->payment;
        if($vendor->type == 'maintenance'):
            $issues = $vendor->maintenance;
        elseif($vendor->type == 'purchases'):
            $purchases = $vendor->purchases;
        elseif($vendor->type == 'all'):
            $issues = $vendor->maintenance;
            $purchases = $vendor->purchases;
        endif;
        return view('admin.vendors.vendor')->with(['vendor' => $vendor, 'payments' => $payments, 'issues' => $issues, 'purchases' => $purchases]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        //
    }
}
