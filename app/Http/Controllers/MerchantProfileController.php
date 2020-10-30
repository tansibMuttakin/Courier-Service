<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;


class MerchantProfileController extends Controller
{
    public function edit($userId){
        if (auth()->id() === (int)$userId) {
            $merchant = User::where('id',$userId)->first();
            return view('merchant.profile.update')->with('merchant',$merchant);
        }
        return redirect()->back();
    }
    public function update(Request $request, $userId){
        if (auth()->id() === (int)$userId) {
            
            $merchant = User::where('id',$userId)->first();
            if (! $merchant->password === (Hash::make($request->old_password))) {
                return redirect()->back()->with('status','This is not your old password');
            }
            if (! $request->new_password === $request->confirm_password) {
                return redirect()->back()->with('status','password does not match');
            }
            // $merchant = User::where('id',$merchant->user_id)->first();
    
            // $user->name = $request->name;
            // $user->email = $request->email;
            // $user->password = Hash::make($request->new_password);
            // $user->save();
    
            $merchant->name = $request->name;
            $merchant->email = $request->email;
            $merchant->password = Hash::make($request->new_password);
            $merchant->save();
    
            return redirect()->route('dashboard')->with('status','Info updated');
        }
        return redirect()->back();

    }    
}   
