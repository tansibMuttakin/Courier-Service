<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\City;
use App\Models\Zone;
use App\Models\Area;
use App\Models\DeliveryInfo;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::with(['store','deliveryInfo'])->get();
        $stores = Store::all();
        return view('admin.order.index')->with('orders',$orders)->with('stores',$stores);
    }
    public function create()
    {
        $users = User::where('type','merchant')->where('approved',1)->get();
        $stores = Store::all();
        $productTypes = Product::all();
        $cities = City::all();

        return view('admin.order.create')->with('stores',$stores)
        ->with('productTypes',$productTypes)->with('cities',$cities)->with('users',$users);
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'merchant'=>'required',
            'store'=>'required',
            'recipient_name'=>'required',
            'recipient_phone'=>'required',
            'recipient_address'=>'required',
            'recipient_city'=>'required',
            'recipient_area'=>'required',
            'recipient_zone'=>'required',
            'delivery_time'=>'required',
            'total_weight'=>'required',
            'total_quantity'=>'required|numeric',
            'amount_to_collect'=>'required',
            'special_instruction'=>'required',
            'description_and_price'=>'required',
        ]);
        $order  = new Order;
        $delivery_info  = new DeliveryInfo;
        $order->user_id = $request->merchant;
        $order->store_id = $request->store;
        $order->product_type = $request->product_type;
        $order->merchant_order_id = $request->merchant_order_id;
        $order->recipient_name = $request->recipient_name;
        $order->recipient_phone = $request->recipient_phone;
        $order->recipient_address = $request->recipient_address;
        $order->recipient_city = $request->recipient_city;
        $order->recipient_zone = $request->recipient_zone;
        $order->recipient_area = $request->recipient_area;
        $order->save();

        $order = Order::latest()->first();
        $delivery_info->order_id = $order->id;
        $delivery_info->delivery_time = $request->delivery_time;
        $delivery_info->total_wight = $request->total_weight;
        $delivery_info->quantity = $request->total_quantity;
        $delivery_info->cost_of_delivery = $request->amount_to_collect;
        $delivery_info->instruction = $request->special_instruction;
        $delivery_info->item_description_price = $request->description_and_price;
        $delivery_info->delivery_status = 0;
        $delivery_info->payment_status = 0;
        $delivery_info->save();
        return redirect()->route('admin.order.index')->with('success','Order created successfully');
    }
    public function edit($orderId){
        $users = User::where('type','merchant')->where('approved',1)->get();
        $stores = Store::all();
        $productTypes = Product::all();
        $cities = City::all();
        $zones = Zone::all();
        $areas = Area::all();

        $order = Order::with(['deliveryInfo','store','user'])->where('id',$orderId)->first();
        return view('admin.order.edit')->with('order',$order)->with('stores',$stores)
        ->with('productTypes',$productTypes)->with('cities',$cities)->with('users',$users)
        ->with('zones',$zones)->with('areas',$areas);
    }

    public function update(Request $request, $orderId)
    {
        
        $validator = $request->validate([
            'merchant'=>'required',
            'store'=>'required',
            'recipient_name'=>'required',
            'recipient_phone'=>'required',
            'recipient_address'=>'required',
            'recipient_city'=>'required',
            'recipient_area'=>'required',
            'recipient_zone'=>'required',
            'delivery_time'=>'required',
            'total_weight'=>'required',
            'total_quantity'=>'required|numeric',
            'amount_to_collect'=>'required',
            'special_instruction'=>'required',
            'description_and_price'=>'required',
        ]);
        $order  = Order::with('deliveryInfo')->where('id',$orderId)->first();
        $order->user_id = $request->merchant;
        $order->store_id = $request->store;
        $order->product_type = $request->product_type;
        $order->merchant_order_id = $request->merchant_order_id;
        $order->recipient_name = $request->recipient_name;
        $order->recipient_phone = $request->recipient_phone;
        $order->recipient_address = $request->recipient_address;
        $order->recipient_city = $request->recipient_city;
        $order->recipient_zone = $request->recipient_zone;
        $order->recipient_area = $request->recipient_area;

        
        $order->deliveryInfo->order_id = $order->id;
        $order->deliveryInfo->delivery_time = $request->delivery_time;
        $order->deliveryInfo->total_wight = $request->total_weight;
        $order->deliveryInfo->quantity = $request->total_quantity;
        $order->deliveryInfo->cost_of_delivery = $request->amount_to_collect;
        $order->deliveryInfo->instruction = $request->special_instruction;
        $order->deliveryInfo->item_description_price = $request->description_and_price;
        $order->deliveryInfo->delivery_status = 0;
        $order->deliveryInfo->payment_status = 0;
        $order->save();
        return redirect()->route('admin.order.index')->with('success','Order created successfully');
    }

    public function getStore($userId){
        $stores = Store::where('user_id',$userId)->where('store_status',1)->get();
        return response()->json($stores);
    }
    public function destroy($orderId){
        $order = Order::where('id',$orderId)->first();
        $order->delete();
        return redirect()->route('admin.order.index');
    }
}
