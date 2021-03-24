@extends('merchant.layout.master')
@section('content')
<div class="bg-white">
    <div class="flex-column form-element">
        <h2 class="mb-40">Order ID #{{$order->id}}</h2>
        <br>
        <div id="account-info" class="flex-space-between cursor-pointer">
            <p class="sub-heading">Recipient Information</p>
            <div>
                <i class="fa fa-chevron-up"></i>
            </div>
        </div>
        <div>
            <hr>
        </div>
        <div class="account-info-content">
            <p>Recipient Name:&nbsp;<b>{{$order->recipient_name}}</b></p> 
            <p>Address:&nbsp; <b>{{$order->recipient_address}}</b></p>
            <p>Contact Number:&nbsp; <b>{{$order->recipient_phone}}</b></p>
        </div>
        <div id="business-info" class="flex-space-between cursor-pointer">
            <p class="sub-heading">Order & Delivery Information</p>
            <div>
                <i class="fa fa-chevron-up"></i>
            </div>
        </div>
        <div>
            <hr>
        </div>
        <div>
            <p>Merchant Name:&nbsp; <b>{{$order->user->name}}</b></p> 
            <p>Store Name:&nbsp; <b>{{$order->store->store_name}}</b></p>
            <p>Order type: &nbsp; <b>{{$order->product_type}}</b></p>
            <p>Order Quantity: &nbsp; <b>{{$order->deliveryInfo->quantity}}</b></p>
            <p>Approximate Weight: &nbsp; <b>{{$order->deliveryInfo->total_wight}}</b></p>
            <p>Order price & description: &nbsp; <b>{{$order->deliveryInfo->item_description_price}}</b></p>
            <p>Delivery status:&nbsp; <b>{{$order->deliveryInfo->delivery_status ? 'Delivered' : 'Pending'}}</b></p>
        </div>
        <div id="payment-info" class="flex-space-between cursor-pointer">
            <p class="sub-heading">Payment Information</p>
            <div>
                <i class="fa fa-chevron-up"></i>
            </div>
        </div>
        <div>
            <hr>
        </div>
        <div>
            <p>Product Cost: &nbsp; <b>{{$order->deliveryInfo->cost_of_delivery}}</b></p>
            <p>Delivery Fee: &nbsp;<b>60</b></p>
            <p>Total Cost: &nbsp; <b>{{$order->deliveryInfo->cost_of_delivery+60}}</b></p>
            <p>Payment status:&nbsp; <b>{{$order->deliveryInfo->payment_status ? 'Paid' : 'Not Paid'}}</b></p>
        </div>
        @if ($order->deliveryInfo->instruction)
            <div class="flex-space-between cursor-pointer">
                <p class="sub-heading">Instructions</p>
                <div>
                    <i class="fa fa-chevron-up"></i>
                </div>
            </div>
            <div>
                <hr>
            </div>
            <div>
                <p><b>{{$order->deliveryInfo->instruction}}</b></p>
            </div>
        @endif
    </div>
</div>
@endsection