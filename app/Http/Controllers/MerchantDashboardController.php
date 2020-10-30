<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryInfo;
use App\Models\Order;
use DB;

class MerchantDashboardController extends Controller
{
    
    public function index(){

        $pending_delivery = 0;
        $total_delivered = 0;
        $total_returned = 0;
        $delivery_due_amount = 0;
        $payment_under_process = 0;
        $payment_processed = 0;

        $orderInfoes = DB::table('delivery_infos')
        ->join('orders', function ($join) {
            $join->on('delivery_infos.order_id', '=', 'orders.id')
                 ->where('orders.user_id', '=', auth()->id());
        })
        ->get();

        // $orderInfoes = DeliveryInfo::whereHas('order',function($query){
        //     $query->where('user_id',auth()->id())->get();
        // });
        // $orderInfoes = DeliveryInfo::with('order')->where('')->get();
        // dd($orderInfoes);
        foreach($orderInfoes as $orderInfo){
            if ($orderInfo->delivery_status == 0) {
                $pending_delivery ++;
            }
            if ($orderInfo->delivery_status == 1) {
                $total_delivered ++;
            }
            if ($orderInfo->payment_status == 0) {
                $payment_under_process ++;
                $delivery_due_amount += $orderInfo->cost_of_delivery;
            }
            if ($orderInfo->payment_status == 1) {
                $payment_processed++;
            }
        }
        return view('merchant.dashboard',compact(['pending_delivery','total_delivered','total_returned','delivery_due_amount','payment_under_process','payment_processed']));
    }
}
