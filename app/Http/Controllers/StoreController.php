<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\City;
use App\Models\Zone;
use App\Models\Area;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = Store::where('user_id',auth()->id())->get();
        return view('merchant.store.index')->with('stores',$stores);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::with('zones')->get();
        return view('merchant.store.create')->with('cities',$cities);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = $request->validate([
            'store_name'=>'required',
            'store_contact_name'=>'required',
            'secondary_contact_number'=>'required',
            'city'=>'required',
            'area'=>'required',
            'zone'=>'required',
            'store_address'=>'required',
        ]);

        $store  = new Store;

        $store->store_name = $request->store_name;
        $store->user_id = auth()->id();
        $store->store_contact_name = $request->store_contact_name;
        $store->contact_number = $request->contact_number;
        $store->secondary_contact_number = $request->secondary_contact_number;
        $store->city = $request->city;
        $store->zone = $request->zone;
        $store->area = $request->area;
        $store->address = $request->store_address;
        $store->save();
        return redirect()->route('store.index')->with('success','Store created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store)
    {

        $store  = Store::where('id',$store->id)->first();
        $cities = City::all();
        $zones = Zone::all();
        $areas = Area::all();
        return view('merchant.store.edit')->with('store',$store)->with('cities',$cities)->with('zones',$zones)->with('areas',$areas);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Store $store)
    {
        $validator = $request->validate([
            'store_name'=>'required',
            'store_contact_name'=>'required',
            'secondary_contact_number'=>'required',
            'city'=>'required',
            'area'=>'required',
            'zone'=>'required',
            'store_address'=>'required',
        ]);

        $store  =  Store::where('id',$store->id)->first();

        $store->store_name = $request->store_name;
        $store->user_id = auth()->id();
        $store->store_contact_name = $request->store_contact_name;
        $store->contact_number = $request->contact_number;
        $store->secondary_contact_number = $request->secondary_contact_number;
        $store->city = $request->city;
        $store->zone = $request->zone;
        $store->area = $request->area;
        $store->address = $request->store_address;
        $store->save();
        return redirect()->route('store.index')->with('success','Store updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getZone($cityId){
        $zones = Zone::with('city')->where('city_id',$cityId)->get();
        return response()->json($zones);
    }
    public function getArea($zoneId){
        $areas = Area::with('zone')->where('zone_id',$zoneId)->get();
        return response()->json($areas);
    }


    public function chnageStatus(Store $store){

        $store = Store::where('id',$store->id)->first();
        if ($store->store_status == 1) {
            $store->store_status = 0;
        }
        else{
            $store->store_status = 1;
        }
        $store->save();
        return redirect()->back();
    }
}
