@extends('admin.layout.master')
@section('content')
<div class="bg-white border order-wrapper">
    <div class="flex-space-between">
        <h3>All Deliveries</h3>
        <div class="flex-space-between item-center">
            <a href=""><button class="border" style="color:white;">Bulk Deliveries</button></a>
            <a href=""><button class="border" style="color:white;">Partial</button></a>
        </div>
    </div>
    <div class="row flex-space-between item-center">
        <div class="w-17">
            <input type="text" id="order_id" placeholder="Consignment/Orde Id">
        </div>
        <div class="w-17">
            <input type="text" id="recipient_name" placeholder="Receiver Name/Phone">
        </div>
        <div class="w-17">
            <input type="text" id="date" placeholder="DD-MM-YYYY">
        </div>
        <div class="w-17">
            <select id="store" name="store">
                <option value="" selected>Store Name</option>
                @foreach($stores as $store)
                <option value="{{$store->id}}">{{$store->store_name}}</option>
                @endforeach
            </select>
        </div>
        <div class="w-17">
            <select id="payment" name="payment">
                <option class="payment_option" value="1">Paid</option>
                <option class="payment_option" value="0">Unpaid</option>
            </select>
        </div>
        <div>
            <a href="{{route('admin.order.csv')}}"><button  class="border" style="color:white;">Export CSV</button></a>
        </div>
    </div>
</div>
<div class="border order-wrapper" style="padding:0;">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Merchant Order Id</th>
                <th>Store</th>
                <th>Recipient Info</th>
                <th>Delivery Status</th>
                <th>Amount</th>
                <th>Payment Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id ="t-body" class="bg-white">
            @foreach($orders as $order)
            <tr class="table-body-row">
                <td class="text-center w-10">
                    {{$order->id}}
                    <p>Type: <b>{{$order->product_type}}</b></p>
                </td>
                <td class="text-center w-10">{{$order->merchant_order_id}}</td>
                <td class="text-center">{{$order->store->store_name}}</td>
                <td class="text-center">
                    <ul>
                        <li><i class="fa fa-user-circle-o" aria-hidden="true"></i> {{$order->recipient_name}}</li>
                        <li><i class="fa fa-address-book" aria-hidden="true"></i> {{$order->recipient_address}}</li>
                        <li><i class="fa fa-phone-square" aria-hidden="true"></i> {{$order->recipient_phone}}</li>
                    </ul>
                </td>
                <td class="text-center w-17">
                    @if($order->deliveryInfo->delivery_status == 0)
                    <a href=""><button class="border" style="color:white; background-color:red;">Cancelled</button></a>
                    @else
                    <a href=""><button class="border" style="color:white; background-color:green;">Pickedup</button></a>
                    @endif
                </td>
                <td class="text-center">{{$order->deliveryInfo->cost_of_delivery}}</td>
                <td class="text-center w-17">
                    @if($order->deliveryInfo->payment_status == 0)
                    <a href=""><button class="border" style="color:white; background-color:red;">unpaid</button></a>
                    @else
                    <a href=""><button class="border" style="color:white; background-color:green;">paid</button></a>
                    @endif
                </td>
                <td>
                    <div class="flex justify-center">
                        <a href="{{route('admin.order.edit',$order->id)}}" class="mx-7"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <a href="{{route('admin.order.destroy',$order->id)}}" class="mx-7"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/app.js')}}"></script>
<script>

$(document).ready(function(){

    // search by store name
    document.querySelector("#store").addEventListener('change',function(){


        const storeId = document.querySelector("#store").value;
        document.querySelector("#t-body").innerHTML = '';

        axios.get(`/merchant/order/search-store/${storeId}`)
        .then(function (response) {
            if (response.data.length === 0) {
                console.log("no order found on that store");
            }
            else{
                (response.data).forEach(order => {
                    let tbody = document.querySelector("#t-body");
                    tbody.innerHTML += `
                    <tr class="table-body-row">
                        <td class="text-center w-10">
                            ${order.id}
                            <p>Type: <b>${order.product_type}</b></p>
                        </td>
                        <td class="text-center w-10">${order.merchant_order_id}</td>
                        <td class="text-center">${order.store.store_name}</td>
                        <td class="text-center">
                            <ul>
                                <li><i class="fa fa-user-circle-o" aria-hidden="true"></i> ${order.recipient_name}</li>
                                <li><i class="fa fa-address-book" aria-hidden="true"></i> ${order.recipient_address}</li>
                                <li><i class="fa fa-phone-square" aria-hidden="true"></i> ${order.recipient_phone}</li>
                            </ul>
                        </td>
                        <td class="text-center w-25">
                            <a href=""><button id="delivery_status${order.id}" class="border" style="color:white;">Text</button></a>
                        </td>
                        <td class="text-center">${order.delivery_info.cost_of_delivery}</td>
                        <td class="text-center">
                            <a href=""><button id="payment_status${order.id}" class="border" style="color:white;">Text</button></a>
                        </td>
                    </tr>`
                    if(order.delivery_info.delivery_status == 0){
                        let pNode = document.querySelector(`#delivery_status${order.id}`);
                        pNode.innerHTML = "";
                        pNode.innerText = "pickup cancel";
                        pNode.style.backgroundColor  = "red";
                    }
                    if(order.delivery_info.delivery_status == 1){
                        let pNode = document.querySelector(`#delivery_status${order.id}`);
                        pNode.innerText = "picked up";
                        pNode.style.backgroundColor  = "green";
                    }
                    if(order.delivery_info.payment_status == 0){

                        let pNode = document.querySelector(`#payment_status${order.id}`);
                        pNode.innerText = "unpaid";
                        pNode.style.backgroundColor  = "red";
                    }
                    if(order.delivery_info.payment_status == 1){
                        let pNode = document.querySelector(`#payment_status${order.id}`);
                        pNode.innerText = "paid";
                        pNode.style.backgroundColor  = "green";
                    }

                });
            }
        })
        .catch(function (error) {
            console.log(error);
        })
        .then(function () {
            // always executed
        });  
    });
    // search by payment
    document.querySelector("#payment").addEventListener('change',function(){


        const payment = document.querySelector("#payment").value;
        document.querySelector("#t-body").innerHTML = '';

        axios.get(`/merchant/order/search-payment/${payment}`)
        .then(function (response) {
            if (response.data.length === 0) {
                console.log("no order found on that store");
            }
            else{
                (response.data).forEach(order => {
                    let tbody = document.querySelector("#t-body");
                    tbody.innerHTML += `
                    <tr class="table-body-row">
                        <td class="text-center w-10">
                            ${order.id}
                            <p>Type: <b>${order.product_type}</b></p>
                        </td>
                        <td class="text-center w-10">${order.merchant_order_id}</td>
                        <td class="text-center">${order.store.store_name}</td>
                        <td class="text-center">
                            <ul>
                                <li><i class="fa fa-user-circle-o" aria-hidden="true"></i> ${order.recipient_name}</li>
                                <li><i class="fa fa-address-book" aria-hidden="true"></i> ${order.recipient_address}</li>
                                <li><i class="fa fa-phone-square" aria-hidden="true"></i> ${order.recipient_phone}</li>
                            </ul>
                        </td>
                        <td class="text-center w-25">
                            <a href=""><button id="delivery_status${order.id}" class="border" style="color:white;">Text</button></a>
                        </td>
                        <td class="text-center">${order.delivery_info.cost_of_delivery}</td>
                        <td class="text-center">
                            <a href=""><button id="payment_status${order.id}" class="border" style="color:white;">Text</button></a>
                        </td>
                    </tr>`
                    if(order.delivery_info.delivery_status == 0){
                        let pNode = document.querySelector(`#delivery_status${order.id}`);
                        pNode.innerHTML = "";
                        pNode.innerText = "pickup cancel";
                        pNode.style.backgroundColor  = "red";
                    }
                    if(order.delivery_info.delivery_status == 1){
                        let pNode = document.querySelector(`#delivery_status${order.id}`);
                        pNode.innerText = "picked up";
                        pNode.style.backgroundColor  = "green";
                    }
                    if(order.delivery_info.payment_status == 0){

                        let pNode = document.querySelector(`#payment_status${order.id}`);
                        pNode.innerText = "unpaid";
                        pNode.style.backgroundColor  = "red";
                    }
                    if(order.delivery_info.payment_status == 1){
                        let pNode = document.querySelector(`#payment_status${order.id}`);
                        pNode.innerText = "paid";
                        pNode.style.backgroundColor  = "green";
                    }

                });
            }
        })
        .catch(function (error) {
            console.log(error);
        })
        .then(function () {
            // always executed
        });  
    });

    //search by id
    document.querySelector("#order_id").addEventListener('change',function(){


        const order_id = document.querySelector("#order_id").value;
        document.querySelector("#t-body").innerHTML = '';

        axios.get(`/merchant/order/search-id/${order_id}`)
        .then(function (response) {
            if (response.data.length === 0) {
                console.log("no order found on that store");
            }
            else{
                (response.data).forEach(order => {
                    console.log(order);
                    let tbody = document.querySelector("#t-body");
                    tbody.innerHTML += `
                    <tr class="table-body-row">
                        <td class="text-center w-10">
                            ${order.id}
                            <p>Type: <b>${order.product_type}</b></p>
                        </td>
                        <td class="text-center w-10">${order.merchant_order_id}</td>
                        <td class="text-center">${order.store.store_name}</td>
                        <td class="text-center">
                            <ul>
                                <li><i class="fa fa-user-circle-o" aria-hidden="true"></i> ${order.recipient_name}</li>
                                <li><i class="fa fa-address-book" aria-hidden="true"></i> ${order.recipient_address}</li>
                                <li><i class="fa fa-phone-square" aria-hidden="true"></i> ${order.recipient_phone}</li>
                            </ul>
                        </td>
                        <td class="text-center w-25">
                            <a href=""><button id="delivery_status${order.id}" class="border" style="color:white;">Text</button></a>
                        </td>
                        <td class="text-center">${order.delivery_info.cost_of_delivery}</td>
                        <td class="text-center">
                            <a href=""><button id="payment_status${order.id}" class="border" style="color:white;">Text</button></a>
                        </td>
                    </tr>`
                    if(order.delivery_info.delivery_status == 0){
                        let pNode = document.querySelector(`#delivery_status${order.id}`);
                        pNode.innerHTML = "";
                        pNode.innerText = "pickup cancel";
                        pNode.style.backgroundColor  = "red";
                    }
                    if(order.delivery_info.delivery_status == 1){
                        let pNode = document.querySelector(`#delivery_status${order.id}`);
                        pNode.innerText = "picked up";
                        pNode.style.backgroundColor  = "green";
                    }
                    if(order.delivery_info.payment_status == 0){

                        let pNode = document.querySelector(`#payment_status${order.id}`);
                        pNode.innerText = "unpaid";
                        pNode.style.backgroundColor  = "red";
                    }
                    if(order.delivery_info.payment_status == 1){
                        let pNode = document.querySelector(`#payment_status${order.id}`);
                        pNode.innerText = "paid";
                        pNode.style.backgroundColor  = "green";
                    }
                });
            }
        })
        .catch(function (error) {   
            console.log(error);
        })
        .then(function () {
            // always executed
        });  
    });

    //search by recipient name
    document.querySelector("#recipient_name").addEventListener('change',function(){


        const storeId = document.querySelector("#recipient_name").value;
        document.querySelector("#t-body").innerHTML = '';

        axios.get(`/merchant/order/search-name/${storeId}`)
        .then(function (response) {
            if (response.data.length === 0) {
                console.log("no order found on that store");
            }
            else{
                (response.data).forEach(order => {
                    console.log(order);
                    let tbody = document.querySelector("#t-body");
                    tbody.innerHTML += `
                    <tr class="table-body-row">
                        <td class="text-center w-10">
                            ${order.id}
                            <p>Type: <b>${order.product_type}</b></p>
                        </td>
                        <td class="text-center w-10">${order.merchant_order_id}</td>
                        <td class="text-center">${order.store.store_name}</td>
                        <td class="text-center">
                            <ul>
                                <li><i class="fa fa-user-circle-o" aria-hidden="true"></i> ${order.recipient_name}</li>
                                <li><i class="fa fa-address-book" aria-hidden="true"></i> ${order.recipient_address}</li>
                                <li><i class="fa fa-phone-square" aria-hidden="true"></i> ${order.recipient_phone}</li>
                            </ul>
                        </td>
                        <td class="text-center w-25">
                            <a href=""><button id="delivery_status${order.id}" class="border" style="color:white;">Text</button></a>
                        </td>
                        <td class="text-center">${order.delivery_info.cost_of_delivery}</td>
                        <td class="text-center">
                            <a href=""><button id="payment_status${order.id}" class="border" style="color:white;">Text</button></a>
                        </td>
                    </tr>`
                    if(order.delivery_info.delivery_status == 0){
                        let pNode = document.querySelector(`#delivery_status${order.id}`);
                        pNode.innerHTML = "";
                        pNode.innerText = "pickup cancel";
                        pNode.style.backgroundColor  = "red";
                    }
                    if(order.delivery_info.delivery_status == 1){
                        let pNode = document.querySelector(`#delivery_status${order.id}`);
                        pNode.innerText = "picked up";
                        pNode.style.backgroundColor  = "green";
                    }
                    if(order.delivery_info.payment_status == 0){

                        let pNode = document.querySelector(`#payment_status${order.id}`);
                        pNode.innerText = "unpaid";
                        pNode.style.backgroundColor  = "red";
                    }
                    if(order.delivery_info.payment_status == 1){
                        let pNode = document.querySelector(`#payment_status${order.id}`);
                        pNode.innerText = "paid";
                        pNode.style.backgroundColor  = "green";
                    }
                });
            }
        })
        .catch(function (error) {   
            console.log(error);
        })
        .then(function () {
            // always executed
        });  
    });

    //search by date
    document.querySelector("#date").addEventListener('change',function(){


        const storeId = document.querySelector("#date").value;
        document.querySelector("#t-body").innerHTML = '';

        axios.get(`/merchant/order/search-date/${storeId}`)
        .then(function (response) {
            if (response.data.length === 0) {
                console.log("no order found on that store");
            }
            else{
                (response.data).forEach(order => {
                    console.log(order);
                    let tbody = document.querySelector("#t-body");
                    tbody.innerHTML += `
                    <tr class="table-body-row">
                        <td class="text-center w-10">
                            ${order.id}
                            <p>Type: <b>${order.product_type}</b></p>
                        </td>
                        <td class="text-center w-10">${order.merchant_order_id}</td>
                        <td class="text-center">${order.store.store_name}</td>
                        <td class="text-center">
                            <ul>
                                <li><i class="fa fa-user-circle-o" aria-hidden="true"></i> ${order.recipient_name}</li>
                                <li><i class="fa fa-address-book" aria-hidden="true"></i> ${order.recipient_address}</li>
                                <li><i class="fa fa-phone-square" aria-hidden="true"></i> ${order.recipient_phone}</li>
                            </ul>
                        </td>
                        <td class="text-center w-25">
                            <a href=""><button id="delivery_status${order.id}" class="border" style="color:white;">Text</button></a>
                        </td>
                        <td class="text-center">${order.delivery_info.cost_of_delivery}</td>
                        <td class="text-center">
                            <a href=""><button id="payment_status${order.id}" class="border" style="color:white;">Text</button></a>
                        </td>
                    </tr>`
                    if(order.delivery_info.delivery_status == 0){
                        let pNode = document.querySelector(`#delivery_status${order.id}`);
                        pNode.innerHTML = "";
                        pNode.innerText = "pickup cancel";
                        pNode.style.backgroundColor  = "red";
                    }
                    if(order.delivery_info.delivery_status == 1){
                        let pNode = document.querySelector(`#delivery_status${order.id}`);
                        pNode.innerText = "picked up";
                        pNode.style.backgroundColor  = "green";
                    }
                    if(order.delivery_info.payment_status == 0){

                        let pNode = document.querySelector(`#payment_status${order.id}`);
                        pNode.innerText = "unpaid";
                        pNode.style.backgroundColor  = "red";
                    }
                    if(order.delivery_info.payment_status == 1){
                        let pNode = document.querySelector(`#payment_status${order.id}`);
                        pNode.innerText = "paid";
                        pNode.style.backgroundColor  = "green";
                    }
                });
            }
        })
        .catch(function (error) {   
            console.log(error);
        })
        .then(function () {
            // always executed
        });  
    });


});

</script>
@endpush