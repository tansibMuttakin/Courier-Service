<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\MerchantAccountInfo;
use App\Models\MerchantBusinessInfo;
use App\Models\MerchantPaymentInfo;
use App\Models\MerchantVerificationInfo;
use App\Notifications\AdminNewUserNotification;

class MerchantRegisterController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('login-registration.registration');
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
            'name'=>'required',
            'mobile'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required',
            'confirm_password'=>'required',
            'country_of_operation'=>'required',
            'business_name'=>'required',
            'business_address'=>'required',
            'payment_type'=>'required',
            'wallet_provider'=>'required',
            'account_number'=>'required',
            'id_type'=>'required',
            'id_number'=>'required',
            'id_front_image'=>'required',
            'tac_agreement'=>'required',

        ]);
        dd('hi');

        if (!($request->password === $request->confirm_password)) {
            return redirect()->back()->with('error', 'Password is not matching');
        }
        
        
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $user = User::latest()->first();

        $account_info = new MerchantAccountInfo;
        $account_info->user_id = $user->id;
        $account_info->name = $request->name;
        $account_info->email = $request->email;
        $account_info->mobile = $request->mobile;
        $account_info->country_of_operation = $request->country_of_operation;
        $account_info->save();
        
        $business_info = new MerchantBusinessInfo;
        $business_info->user_id = $user->id;
        $business_info->business_name = $request->business_name;
        $business_info->business_address = $request->business_address;
        $business_info->save();
        
        $payment_info = new MerchantPaymentInfo;
        $payment_info->user_id = $user->id;
        $payment_info->payment_type = $request->payment_type;
        $payment_info->wallet_provider = $request->wallet_provider;
        $payment_info->branch_name = $request->branch_name;
        $payment_info->routing_number = $request->routing_number;
        $payment_info->account_type = $request->account_type;
        $payment_info->account_holder_name = $request->account_holder_name;
        $payment_info->account_number = $request->account_number;
        $payment_info->save();
        
        $verification_info = new MerchantVerificationInfo;
        $verification_info->user_id = $user->id;
        $verification_info->id_type = $request->id_type;
        $verification_info->id_number = $request->id_number;
        if ($request->hasFile('id_front_image')) {
            $image = $request->file('id_front_image');
            $imageName = $user->id.'.'.$image->getClientOriginalName();
            $verification_info->id_front_image = $imageName;
            $image->move(public_path('uploads'), $imageName);
        }
        $verification_info->save();

        $administrator = User::where('type','admin')->first();
        $administrator->notify(new AdminNewUserNotification($user));

        return redirect()->route('merchant.login')->with('status','Request for Approval has been sent to Admin.
         Once its approved you will be notified.');
        
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
