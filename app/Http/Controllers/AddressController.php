<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressCreateRequest;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function create(AddressCreateRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user()->id;
        $check = Address::where('user_id', $user)->first();
        if ($check) {
            return response()->json([
                "status" => false,
                "statusCode" => 400,
                "message" => "You already have an address."
            ], 400);
        }
        $address = new Address($data);
        $address->user_id = $user;
        $address->save();

        return response()->json([
            "message" => "success"
        ]);
    }
}
