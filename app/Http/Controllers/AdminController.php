<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;
use App\Models\Order;
use App\Models\Package;
use App\Notifications\MerchantApprovalNotification;
use App\Notifications\MerchantDisapprovalNotification;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class AdminController extends Controller
{
    public function index(){

        $total_stores = Store::all()->count();
        $active_stores = Store::where('store_status',1)->get()->count();
        $total_packages = Package::all()->count();
        $total_order_completed=0;
        foreach (Order::with('deliveryInfo')->get() as $order) {
            if ($order->deliveryInfo->delivery_status == 1) {
                $total_order_completed ++;
            }
        }
        $total_users = User::where('type','merchant')->get()->count();
        $latest_user = User::with('stores')->where('type','merchant')->orderBy('created_at','desc')->get();
        $active_merchants = User::where('type','merchant')->where('approved',1)->get()->count();

        $stores = Store::with('user')->latest()->take(3)->get();
        $orders = Order::with(['deliveryInfo','store','user'])->latest()->take(3)->get();
        return view('admin.dashboard',compact(['total_users','latest_user','active_merchants','total_stores','active_stores','total_packages','total_order_completed','stores','orders']));
    }

    public function users(){
        $packages = Package::all();
        $users = User::with('packages')->where('type','merchant')->get();
        return view('admin.users.index')->with('users',$users)->with('packages',$packages);
    }

    public function merchantDetails($userId){
        $packages = Package::all();
        $user = User::with('packages','businessInfo','paymentInfo','verificationInfo')->where('id',$userId)->first();
        return view('admin.users.details')->with('user',$user)->with('packages',$packages);
    }

    public function update(Request $request,$userId){
        $user = User::where('id',$userId)->first();
        $user->packages()->detach();
        foreach ($request->packages as $package) {
            $packageId = json_decode($package)->id;
            $user->packages()->attach($packageId);
        }
        return redirect()->route('admin.users');
    }

    public function updateApproval($userId){
        $user = User::where('id',$userId)->first();
        $administrator = User::where('type','admin')->first();
        if($user->approved == 0){
            $user->approved = 1;
            $user->notify(new MerchantApprovalNotification($administrator));
        }
        else{
            $user->approved = 0;
            $user->notify(new MerchantDisapprovalNotification($administrator));
        }
        $user->save();
        return redirect()->route('admin.users');
    }

    public function destroy($userId){
        $user = User::where('id',$userId)->first();
        if (!($user->id_front_image == null)) {
            unlink(public_path('uploads/'.$user->id_front_image));
        }
        $user->delete();
        return redirect()->route('admin.users');
    }


    public function searchByPackage($searchKey){
        $users = User::with('packages')->whereHas('packages',function($query) use($searchKey){
            $query->where('packages.id', $searchKey);
        })->get();

        
        // $users = [];
        // $user_ids = \DB::table('package_user')->where('package_id', $searchKey)->pluck('user_id');
        // foreach($user_ids as $user_id){
        //     array_push($users, User::with('packages')->findOrFail($user_id));
        // }

        // $users = User::with('packages')->where('packages.id',3)->get();
        
        return response()->json($users);
    }
    public function searchById($searchKey){
        $users = User::with('packages')->where('type','merchant')->where('id',$searchKey)->get();
        return response()->json($users);
    }
    public function searchByName($searchKey){
        $users = User::with('packages')->where('type','merchant')->where('name',$searchKey)->get();
        return response()->json($users);
    }
    public function searchByEmail($searchKey){
        $users = User::with('packages')->where('type','merchant')->where('email',$searchKey)->get();
        return response()->json($users);
    }
    public function searchByApproval($searchKey){
        $users = User::with('packages')->where('type','merchant')->where('approved',$searchKey)->get();
        return response()->json($users);
    }

}
