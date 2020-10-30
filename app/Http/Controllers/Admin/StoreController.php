<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;
use App\Models\City;
use App\Models\Zone;
use App\Models\Area;


class StoreController extends Controller
{
    public function index(){
        $stores = Store::with('user')->get();
        return view('admin.store.index')->with('stores',$stores);
    }
    public function create()
    {
        $users = User::where('type','merchant')->where('approved',1)->get();
        $cities = City::with('zones')->get();
        return view('admin.store.create')->with('cities',$cities)->with('users',$users);
    }

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
            'merchant'=>'required',
        ]);

        $store  = new Store;

        $store->store_name = $request->store_name;
        $store->user_id = (int)$request->merchant;
        $store->store_contact_name = $request->store_contact_name;
        $store->contact_number = $request->contact_number;
        $store->secondary_contact_number = $request->secondary_contact_number;
        $store->city = $request->city;
        $store->zone = $request->zone;
        $store->area = $request->area;
        $store->address = $request->store_address;
        $store->save();
        return redirect()->route('admin.store.index')->with('success','Store created successfully');

    }
    public function edit(Store $store)
    {

        $store  = Store::with('user')->where('id',$store->id)->first();
        $users = User::where('type','merchant')->where('approved',1)->get();
        $cities = City::all();
        $zones = Zone::all();
        $areas = Area::all();
        return view('admin.store.edit')->with('store',$store)
        ->with('cities',$cities)->with('zones',$zones)->with('areas',$areas)->with('users',$users);
    }

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
        $store->user_id = (int)$request->merchant;
        $store->store_contact_name = $request->store_contact_name;
        $store->contact_number = $request->contact_number;
        $store->secondary_contact_number = $request->secondary_contact_number;
        $store->city = $request->city;
        $store->zone = $request->zone;
        $store->area = $request->area;
        $store->address = $request->store_address;
        $store->save();
        return redirect()->route('admin.store.index')->with('success','Store updated successfully');
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

    public function destroy($storeId)
    {
        $store = Store::where('id',$storeId)->first();
        $store->delete();
    }
}