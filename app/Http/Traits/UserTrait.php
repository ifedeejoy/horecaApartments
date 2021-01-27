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
        $users = User::where('type', $type)->get();
        return $users;
    }

    public function apiResponse($data)
    {
        return response(['data' => UserResource::collection($data)], 200);
    }
}