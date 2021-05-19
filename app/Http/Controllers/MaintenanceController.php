<?php

namespace App\Http\Controllers;

use App\Http\Traits\VendorTrait;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use App\Models\Apartments;
use App\Models\Vendor;
use App\Models\Credit;
use Illuminate\Database\QueryException;
use CloudinaryLabs\CloudinaryLaravel\MediaAlly;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class MaintenanceController extends Controller
{
    use MediaAlly, VendorTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartments = Apartments::all();
        $vendors = Vendor::where('type', 'maintenance')->get();
        $maintenance = Maintenance::where('status', '!=', 'resolved')->with(['apartment', 'vendor'])->get();
        return view('admin.apartments.maintenance')->with(['apartments' => $apartments, 'vendors' => $vendors, 'issues' => $maintenance]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'apartment' => 'required',
            'issue' => 'required'
        ]);
        $apartment = Apartments::find($request->input('apartment'));
        try{
            if(empty($request->input('vendor'))):
                $vendor = null;
            elseif($request->input('vendor') == 0):
                $vendor = $this->createVendor($request, 'maintenance');
            else:
                $vendor = Vendor::find($request->input('vendor'));
            endif;
            $vendorId = empty($vendor) ? null : $vendor->id;
            $apartment->status = 'out_of_order';
            $apartment->maintenance_status = 'active';
            $images = collect();
            if($request->hasFile('issue-images')):
                foreach($request->file('issue-images') as $image):
                    $upload = Cloudinary::uploadFile($image->path(), array('folder' => 'horeca-apartments/maintenance-pictures'))->getSecurePath();
                    $images->push($upload);
                endforeach;
                $apartment->images = $images->toJson();
            endif;
            $apartment->maintenance()->create([
                'issue' => $request->input('issue'),
                'status' => 'reported',
                'vendor_id' => $vendorId,
                'images' => $images->toJson()
            ]);
            $apartment->save();
            return back()->with('success', 'Issue reported successfully');
        }catch(QueryException $e){
            return back()->with('error', $e->errorInfo[2]);
        }   
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function show(Maintenance $maintenance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function edit(Maintenance $maintenance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function assignVendor(Request $request, Maintenance $maintenance)
    {
        $request->validate([
            'vendor' => 'required',
            'cost' => 'integer|required',
            'cost-breakdown' => 'required',
            'apartment' => 'required'
        ]);
        try{ 
            $issue = $maintenance->find($request->input('issue_id'));
            if($request->input('vendor') == 0):
                $vendor = $this->createVendor($request, 'maintenance');
            else:
                $vendor = Vendor::find($request->input('vendor'));
            endif;
            $issue->payment()->create([
                'apartments_id' => $request->input('apartment'),
                'vendor_id' => $vendor->id,
                'cost' => $request->input('cost'),
                'cost_breakdown' => $request->input('cost-breakdown'),
                'paid' => $request->input('paid'),
                'balance' => $request->input('cost') - $request->input('paid'),
                'payment_method' => $request->input('payment-method'), 
            ]);
            if($request->input('payment-method') == 'credit'):
               $vendor->credit()->create([
                   'service' => $request->input('cost-breakdown'),
                   'initial_amount' => $request->input('cost'),
                   'amount' => $request->input('paid'),
                   'created_by' => auth()->user()->id,
                   'reference' => mt_rand()
               ]);
            endif;
            $issue->vendor_id = $vendor->id;
            $issue->save();
            return back()->with('success', 'Vendor assigned successfully');
        } 
        catch (QueryException $e)
        {
            dd($e);
            // return back()->with('error', $e->errorInfo[2]);
        }
        
    }

    public function update(Request $request, Maintenance $maintenance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Maintenance $maintenance)
    {
        //
    }
}
