<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Traits\UserTrait;
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
        if($request->is('api/users/*')):
            $type = $request->type;
            $users = $this->getUsers($type);
            $response = $this->apiResponse($users);
            return $response;
        else:
            if($request->is('admin/owners')):
                $users = User::where('type', 'owner');
                return view('admin.users.owners')->with('users', $users);
            elseif($request->is('admin/agents')):
                $users = User::where('type', 'agents');
                return view('admin.users.agents')->with('users', $users);
            elseif($request->is('admin/employees')):
                $users = User::where('type', 'staff');
                return view('admin.users.employees')->with('users', $users);
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
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->country = $request->country;
            $user->password = Hash::make('12345678');
            $user->type = $request->type;
            $user->save();
            $user->assignRole($request->type);
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
        // 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
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
        //
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
