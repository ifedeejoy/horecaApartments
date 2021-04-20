<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Traits\UserTrait;
use App\Models\Reservation;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    use UserTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->type;
        $users = $this->getUsers($type);
        if($request->is('api/users/*')):
            $response = $this->apiResponse($users);
            return $response;
        else:
            if($request->is('admin/users/owners')):
                return view('admin.users.owners');
            elseif($request->is('admin/users/agents')):
                return view('admin.users.agents');
            elseif($request->is('admin/users/employees')):
                return view('admin.users.employees');
            elseif($request->is('admin/users/managers')):
                return view('admin.users.managers');
            elseif($request->is('admin/users/admin')):
                return view('admin.users.admin');
            endif;
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
        $validated = $this->validateUserData($request->all());
        try {
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->address = $request->input('address');
            $user->country = $request->input('country');
            $user->password = Hash::make('12345678');
            $user->type = $request->input('type');
            $user->save();

            // foreach($request->input('permissions') as $permission):
            //     $check = Permission::where('name', $permission)->count();
            //     if($check < 1):
            //         Permission::create(['name' => $permission]);
            //     endif;
            // endforeach;

            if($request->input('type') == 'super-admin'):
                $user->assignRole($request->input('type'));
            else:
                $user->givePermissionTo($request->input('permissions'));
            endif;
            return back()->with('success', 'User created successfully');
        } catch (QueryException $e) {
            return back()->with('error', 'User not created');
        }
    }
    

    /**
     * Display the specified resource.
     *
     */
    public function show(Request $request)
    {
        $user = User::find($request->id);
        $reservations = Reservation::where('createdBy', $user->id)->with('reservationPayments', 'guest', 'apartments')->get();
        if($request->is('api/user-reservations/*')):
            return response()->json(['data' => $reservations]);
        endif;
        return view('admin.users.user')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $user = User::find($request->user);
        return view('admin.users.edit-user')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        try {
            $user = User::find($request->id);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->address = $request->input('address');
            $user->country = $request->input('country');
            $user->type = $request->input('role');
            $user->save();
            $user->givePermissionTo($request->input('permissions'));
            return back()->with('success', 'User updated successfully');
        } catch (QueryException $e) {
            return back()->with('error', 'User not updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
