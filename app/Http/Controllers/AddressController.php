<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAddressRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAddressRequest $request)
    {
        $data = $request->except('token', '_method');
        $data['user_id'] = JWTAuth::user()->id;
        if ($data['is_default'] == 1) {
            Address::where('is_default', 1)->where('user_id', JWTAuth::user()->id)->update(['is_default' => 0]);
        }
        Address::create($data);
        return response()->json(['status' => true, 'message' => 'Address created successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $address = Address::where('user_id', JWTAuth::user()->id)->get();
        return response()->json(['address' => $address, 'status' => true], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAddressRequest  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAddressRequest $request, Address $address)
    {
        if ($address->user_id == JWTAuth::user()->id) {
            $address->update($request->except('token', '_method'));
            return response()->json(['status' => true, 'message' => 'Address updated successfully'], 200);
        }

        return response()->json(['status' => false, 'message' => 'Address not found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        if ($address->user_id == JWTAuth::user()->id) {
            $address->delete();
            return response()->json(['status' => true, 'message' => 'Address deleted successfully'], 200);
        }

        return response()->json(['status' => false, 'message' => 'Address not found'], 404);
    }

    public function makeDefault(Address $address)
    {
        Address::where('is_default', 1)->where('user_id', JWTAuth::user()->id)->update(['is_default' => 0]);
        $address->update(['is_default' => 1]);
        return response()->json(['address' => $address, 'status' => true], 200);
    }

    public function addresses(Request $request)
    {
        $address = Address::where('user_id', JWTAuth::user()->id)->get();
        return response()->json(['address' => $address, 'status' => true], 200);
    }
}
