<?php

namespace App\Http\Traits;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

trait UserTrait 
{

    public function validateUserData($request)
    {
        $validated = Validator::make($request, [
            'name' => 'required',
            'email' => 'required|unique:users|max:255',
            'type' => 'required',
            'phone' => 'required|max:20'
        ]);
        if($validated->fails()):
            return back()->withErrors($validated->errors());
        endif;
        // validate input
    }

    public function getUsers(string $type)
    {
        switch(true):
            case  ($type == "admin"):
                $usertype = 'super-admin';
                break;
            case ($type == "owners" || $type == "owner"):
                $usertype = 'owner';
                break;
            case ($type == "managers" || $type == "property manager"):
                $usertype = 'property manager';
                break;
            case ($type == "agents"):
                $usertype = 'agents';
                break;
            case ($type == "employees" || $type == "staff"):
                $usertype = 'staff';
                break;
        endswitch;
        $users = User::where('type', $usertype)->get();
        return $users;
    }

    public function apiResponse($data)
    {
        return response(['data' => UserResource::collection($data)], 200);
    }
}