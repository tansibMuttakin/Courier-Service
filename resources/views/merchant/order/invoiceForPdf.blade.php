<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="bg-white">
        <div class="flex-column form-element">
            <h2 class="mb-40">Order Invoice #CMS{{$order->id}}</h2>
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
        </div>
    </div>
</body>
</html>