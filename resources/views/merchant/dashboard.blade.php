@extends('merchant.layout.master')
@section('content')
<div class="flex-container mt-27">
    <div class="bg-white text-center h-80-w-150 p-20 border display-block">
        <h5>Pending Delivery</h5>
        <h1>{{$pending_delivery}}</h1>
    </div>
    <div class="bg-white text-center h-80-w-150 p-20 border display-block">
        <h5>Total Delivered</h5>
        <h1>{{$total_delivered}}</h1>
    </div>
    <div class="bg-white text-center h-80-w-150 p-20 border display-block">
        <h5>Total Returned</h5>
        <h1>{{$total_returned}}</h1>
    </div>
    <div class="bg-white text-center h-80-w-150 p-20 border display-block">
        <h5>Delivery Due Amount</h5>
        <h1>{{$delivery_due_amount}}</h1>
    </div>
    <div class="bg-white text-center h-80-w-150 p-20 border display-block">
        <h5>Payment Under Process</h5>
        <h1>{{$payment_under_process}}</h1>
    </div>
    <div class="bg-white text-center h-80-w-150 p-20 border display-block">
        <h5>Payment Procesed</h5>
        <h1>{{$payment_processed}}</h1>
    </div>
</div>
<div class="flex-space-between mt-25 h-460 mx-33">
    <div class="bg-white w-70  border">
        <h4 class="m-0">
            delivery vs returned
        </h4>
    </div>
    <div class="bg-white w-25 border" style="height:fit-content">
        <h3 style="padding-left:7px;">Quick Links</h3>
        <ul>
            <li>
                <a class="quick-links" href="{{route('store.create')}}"><i class="fa fa-shopping-basket icon-mr-10" aria-hidden="true"></i>Create Store</a>
            </li>
            <li>
                <a class="quick-links" href=""><i class="fa fa-money icon-mr-10" aria-hidden="true"></i>Pricing Plans</a>
            </li>      
        </ul>
    </div>
</div>
@endsection