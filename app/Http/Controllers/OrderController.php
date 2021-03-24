<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\City;
use App\Models\DeliveryInfo;
use PDF;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with(['store','deliveryInfo'])->where('user_id',auth()->id())->get();
        $stores = Store::where('user_id',auth()->id())->get();
        // dd($orders);
        return view('merchant.order.index')->with('orders',$orders)->with('stores',$stores);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stores = Store::where('user_id',auth()->id())->get();
        $productTypes = Product::all();
        $cities = City::all();

        return view('merchant.order.create')->with('stores',$stores)->with('productTypes',$productTypes)->with('cities',$cities);
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
        $order->user_id = auth()->id();
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
        return redirect()->route('order.index')->with('success','Order created successfully');
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

    public function searchByStore($searchKey){
        $orders = Order::with(['store','deliveryInfo'])->where('store_id',$searchKey)->get();
        return response()->json($orders);
    }
    public function searchByName($searchKey){
        $orders = Order::with(['store','deliveryInfo'])->where('recipient_name',$searchKey)->orWhere('recipient_phone',$searchKey)->get();
        return response()->json($orders);
    }
    public function searchById($searchKey){
        $orders = Order::with(['store','deliveryInfo'])->where('id',$searchKey)->get();
        return response()->json($orders);
    }
    public function searchByDate($searchKey){
        $orders = Order::with(['store','deliveryInfo'])->get();
        $arr = [];
        foreach($orders as $order){
            $date = date("d-m-Y", strtotime($order->created_at));
            if($date == $searchKey){
                array_push($arr,$order);
            }
        }
        return response()->json($arr);
    }
    public function searchByPayment($searchKey){
        $orders = Order::with(['store','deliveryInfo'])
        ->whereHas('deliveryInfo',function($query) use($searchKey){
            $query->where('payment_status',$searchKey);
        })
        ->get();
        return response()->json($orders);
    }

    public function view($orderId){
        $order = Order::with(['user','store','deliveryInfo'])->where('id',$orderId)->first();
        return view('merchant.order.view',['order' => $order]);
    }
    public function invoice($orderId){
        $order = Order::with(['user','store','deliveryInfo'])->where('id',$orderId)->first();
        return view('merchant.order.invoice',['order' => $order]);
    }
    public function pdf($orderId){
        $order = Order::with(['user','store','deliveryInfo'])->where('id',$orderId)->first();
        $pdf = PDF::loadView('merchant.order.invoiceForPdf',compact('order'));

        // download PDF file with download method
        return $pdf->download('invoice.pdf');
    }
}
