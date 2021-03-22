@extends('admin.layout.master')
@section('content')
<div class="flex-container mt-27">
    <div class="bg-white text-center h-80-w-150 p-20 border display-block">
        <h5>Merchnants</h5>
        <h1>{{$total_users}}</h1>
    </div>
    <div class="bg-white text-center h-80-w-150 p-20 border display-block">
        <h5>Active Merchants</h5>
        <h1>{{$active_merchants}}</h1>
    </div>
    <div class="bg-white text-center h-80-w-150 p-20 border display-block">
        <h5>Total Stores</h5>
        <h1>{{$total_stores}}</h1>
    </div>
    <div class="bg-white text-center h-80-w-150 p-20 border display-block">
        <h5>Active Stores</h5>
        <h1>{{$active_stores}}</h1>
    </div>
    <div class="bg-white text-center h-80-w-150 p-20 border display-block">
        <h5>Packages</h5>
        <h1>{{$total_packages}}</h1>
    </div>
    <div class="bg-white text-center h-80-w-150 p-20 border display-block">
        <h5>Total Order Completed</h5>
        <h1>{{$total_order_completed}}</h1>
    </div>
</div>
<div class="flex mt-25 text-center">
    <div class="col-6 bg-white mx-33">
        <h3 class="text-center">Recent Registered Merchant</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Merchant name</th>
                    <th>Merchant store</th>
                    <th>Merchant status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($latest_user as $user)
                    <tr class="text-center">
                        <td>{{++$loop->index}}</td>
                        <td><p>{{$user->name}}</p></td>
                        @if (count($user->stores))
                            <td>
                                @foreach ($user->stores as $store)
                                    <p>{{$store->store_name}}</p>
                                @endforeach
                            </td>
                        @else
                            <td>
                                <p>no stores</p>
                            </td>
                        @endif
                        <td>
                            @if($user->approved== 0)
                            <a href=""><button class="border" style="color:white; background-color:red;">Deactive</button></a>
                            @else
                            <a href=""><button class="border" style="color:white; background-color:green;">Active</button></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-6 bg-white mx-33">
        <h3 class="text-center">Recent Added Store</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Store name</th>
                    <th>Merchant name</th>
                    <th>Address</th>
                    <th>Store Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stores as $store)
                    <tr>
                        <td>{{++$loop->index}}</td>
                        <td><p>{{$store->store_name}}</p></td>
                        <td><p>{{$store->user->name}}</p></td>
                        <td><p>{{$store->address}}</p></td>
                        <td>
                            @if($store->store_status == 0)
                            <a href=""><button class="border" style="color:white; background-color:red;">Deactive</button></a>
                            @else
                            <a href=""><button class="border" style="color:white; background-color:green;">Active</button></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
{{-- <div class="col-6 bg-white mx-33">
    <h3>Recent Orders</h3>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Store name</th>
                <th>Order Type</th>
                <th>Merchant name</th>
                <th>Order Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{++$loop->index}}</td>
                    <td><p>{{$order->store->store_name}}</p></td>
                    <td><p>{{$order->product_type}}</p></td>
                    <td><p>{{$order->user->name}}</p></td>
                    <td>
                        @if($order->deliveryInfo->delivery_status == 0)
                        <a href=""><button class="border" style="color:white; background-color:red;">Pickup cancel</button></a>
                        @else
                        <a href=""><button class="border" style="color:white; background-color:green;">Pickedup</button></a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div> --}}
@endsection
{{-- 
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
@endpush --}}