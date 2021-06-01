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
        $maintenance = Maintenance::whereNotIn('status', ['completed', 'failed'])->with(['apartment', 'vendor'])->get();
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
                'images' => $images->toJson(),
                'user_id' => auth()->user()->id,
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
    public function show(Request $request)
    {
        $maintenance = Maintenance::where('id', $request->maintenance)->with('lastPayment', 'vendor', 'apartment')->get();
        if($request->is('api/maintenance/issue/*')):
            return response()->json(['data' => $maintenance]);
        endif;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function edit(Maintenance $maintenance, Request $request)
    {
        $request->validate([
            'vendor' => 'required',
            'cost' => 'required|regex:/^\d*(\.\d{2})?$/',
            'cost-breakdown' => 'required',
            'apartment' => 'required'
        ]);
        try{ 
            $issue = $maintenance->find($request->input('edited_issue'));
            if($request->input('vendor') == 0):
                $vendor = $this->createVendor($request, 'maintenance');
            else:
                $vendor = Vendor::find($request->input('vendor'));
            endif;
            $oldbreakdown = $issue->payment->last();
            $issue->payment()->latest()->update([
                'apartments_id' => $request->input('apartment'),
                'vendor_id' => $vendor->id,
                'cost' => $request->input('cost'),
                'cost_breakdown' => $request->input('cost-breakdown'),
                'paid' => $request->input('paid'),
                'balance' => $request->input('cost') - $request->input('paid'),
                'payment_method' => $request->input('payment-method'), 
            ]);
            if(strtolower($request->input('payment-method')) == 'credit'):
               $vendor->credit()->updateOrCreate(
                   ['initial_amount' => $request->input('cost'), 'service' => $oldbreakdown->cost_breakdown],
                   [
                        'service' => $request->input('cost-breakdown'),
                        'initial_amount' => $request->input('cost'),
                        'amount' => $request->input('paid'),
                        'created_by' => auth()->user()->id,
                        'reference' => mt_rand()
                   ]
                );
            endif;
            $issue->issue = $request->input('issue');
            $issue->vendor_id = $vendor->id;
            $issue->modified_by = auth()->user()->id;
            $issue->save();
            return back()->with('success', 'Issue edited successfully');
        } catch (QueryException $e)
        {
            return back()->with('error', $e->errorInfo[2]);
        }
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
            $issue->status = 'assigned';
            $issue->vendor_id = $vendor->id;
            $issue->save();
            return back()->with('success', 'Vendor assigned successfully');
        } 
        catch (QueryException $e)
        {
            return back()->with('error', $e->errorInfo[2]);
        }
        
    }

    public function update(Request $request, Maintenance $maintenance)
    {
        $request->validate([
            'vendor' => 'required',
            'cost' => 'required|regex:/^\d*(\.\d{2})?$/',
            'cost-breakdown' => 'required',
            'apartment' => 'required'
        ]);
        try{ 
            $issue = $maintenance->find($request->input('updated-issue'));
            $vendor = Vendor::find($request->input('vendor'));
            $oldbreakdown = $issue->payment->last();
            if((!empty($request->input('paid')) && $request->input('paid') > 0) || ($request->input('status') == 'completed' && $oldbreakdown->balance > 0)):
                $issue->payment()->create([
                    'apartments_id' => $request->input('apartment'),
                    'vendor_id' => $vendor->id,
                    'cost' => $request->input('cost'),
                    'cost_breakdown' => $request->input('cost-breakdown'),
                    'paid' => $request->input('paid'),
                    'balance' => $request->input('balance') - $request->input('paid'),
                    'payment_method' => $request->input('payment-method'), 
                ]);
                if(strtolower($request->input('payment-method')) == 'credit'):
                    $vendor->credit()->updateOrCreate(
                        ['initial_amount' => $request->input('cost'), 'service' => $oldbreakdown->cost_breakdown],
                        [
                                'service' => $request->input('cost-breakdown'),
                                'initial_amount' => $request->input('balance'),
                                'amount' => $request->input('paid'),
                                'created_by' => auth()->user()->id,
                                'reference' => mt_rand()
                        ]
                    );
                endif;
            endif;
            $issue->status = $request->input('status');
            $issue->modified_by = auth()->user()->id;
            $issue->save();
            return back()->with('success', 'Issue updated successfully');
        } catch (QueryException $e)
        {
            return back()->with('error', $e->errorInfo[2]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Maintenance $maintenance)
    {
        $maintenance->delete();
        return back()->with('success', 'Issue deleted');
    }
}
