@extends('admin.layout.master')
@section('content')
<form action="{{route('admin.order.store')}}" method="post">
    @csrf
    <div class="flex-space-between mt-25 h-460 mx-33">

        <div class="wrapper bg-white w-70 p-20  border">
            <div class="flex-space-between">
                <div>
                    <h4>Create Order</h4>
                    @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                </div>
                <div>
                    <ul class="">
                        <a href=""><button class="border" style="color:white;">Bulk Order</button></a>
                        <a href=""><button class="border" style="color:white;"><i class="fa fa-plus-circle fa-lg icon-mr-10" aria-hidden="true"></i>Partial</button></a>
                        <!-- <button class="border"><a href="" style="color:white;">Creat Order</a></button> -->
                        <!-- <li><a href=""><i class="fa fa-user fa-lg" aria-hidden="true"></i> Marchent</a></li> -->
                    </ul>
                </div>
    
            </div>
            <hr>
            <div class="form-wrapper">
                <!-- <form action="{{route('order.store')}}" method="post">
                    @csrf -->
                    <div class="form-row flex">
                        <div class="col-5">
                            <label for="merchant">Assign Merchant</label>
                            <select id="merchant" name="merchant">
                                <option value="">Choose..</option>
                                @foreach($users as $user)
                                    @if($user->approved == 1)
                                        <option class="merchant" value="{{$user->id}}">{{$user->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-5">
                            <label for="store">Store</label>
                            <select id="store" name="store">
                                <option value="">choose merchant first</option>
                            </select>
                        </div>
                        <div class="col-5">
                            <label for="country">Product Type</label>
                            <select id="country" name="product_type">
                                <option value="Document">Document</option>
                                <option value="Package">Package</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <label for="country">Merchant Order Id</label>
                            <input type="text" placeholder="Merchand order id" name="merchant_order_id">
                        </div>
                    </div>
                    <div class="form-row flex-space-between">
                        <div class="col-8">
                            <h4>Recipient details</h4>
                            <div clas="row" style="display:flex; justify-content:space-between; margin-top: 50px;">
                                <div class="col-6">
                                    <label>Recipient Name</label>
                                    <input type="text" name="recipient_name" placeholder="Recipient name" required>
                                </div>
                                <div class="col-6">
                                    <label>Recipient Phone</label>
                                    <input type="text" name="recipient_phone" placeholder="Recipient phone" required>
                                </div>
                            </div>
                            <div class="row">
                                <label>Recipient Address</label>
                                <input type="text" name="recipient_address" placeholder="Recipient Address" required>
                                <p><i>Only english character is allowed</i></p>
                            </div>
                            <div class="row flex-space-between">
                                <div class="col-6">
                                    <label for="city">Recipient City</label>
                                    <select id="city" name="recipient_city">
                                        <option value="">choose...</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}">{{$city->city_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="zone">Recipient Zone</label>
                                    <select id="zone" name="recipient_zone">
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="area">Recipient Area</label>
                                    <select id="area" name="recipient_area">
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <h4>Delivery information</h4>
                            <div class="form-row">
                                <label for="delivery_time">Delivery Time</label>
                                <select id="delivery_time" name="delivery_time">
                                    <option value="10 AM">10 AM</option>
                                    <option value="11 AM">11 AM</option>
                                    <option value="12 AM">12 AM</option>
                                    <option value="1 PM">1 PM</option>
                                    <option value="2 PM">2 PM</option>
                                    <option value="3 PM">3 PM</option>
                                </select>
                            </div>
                            <div class="row flex-space-between">
                                <div class="col-6">
                                    <label for="total_weight">Weight</label>
                                    <select id="total_weight" name="total_weight">
                                        <option value="0 to 1 kg">0 to 1 kg</option>
                                        <option value="2 to 5 kg">2 to 5 kg</option>
                                        <option value="5 to 8 kg">5 to 8 kg</option>
                                        <option value="8 to 10 kg">8 to 10 kg</option>
                                        <option value="10 to 15 kg">10 to 15 kg</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="country">Total Quantity</label>
                                    <input type="text" name="total_quantity" placeholder="Quantity" required>
                                </div>
                            </div>
                            <div class="row">
                                <label for="amount">Amount To Collect</label>
                                <input name="amount_to_collect" id="amount" type="text" required>
                            </div>
                            <div class="row">
                                <label for="country">Special Instruction</label>
                                <input type="text" name="special_instruction" placeholder="Enter Special Instruction">
                                <p><i>Only english character is allowed</i></p>
                            </div>
                            <div class="row">
                                <label for="country">Item Description & Item Price</label>
                                <input type="text" name="description_and_price" placeholder="Item Description & Item Price">
                                <p><i>Only english character is allowed</i></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-submit-button">
                        <button class="button-success" type="submit">Save</button>
                        <button class="button-danger" type="submit">Cancel</button>
                    </div>
                <!-- </form> -->
            </div>
        </div>
        <div class="bg-white border p-20" style="height:fit-content; width:20%;">
            <h3>Cost of Delivery</h3>
            <div class="flex-space-between">
                <div class="">
                    <p>Delivery Fee</p>
                    <p>COD</p>
                    <p>Promo</p>
                </div>
                <div class="">
                    <p id="p_delivery_fee">60</p>
                    <input type="hidden" name="delivery_fee" id="delivery_fee" value="60">
                    <p id="p_cod">0</p>
                    <input type="hidden" id="cod" name="cod" value="0">
                    <p id="p_promo">0</p>
                    <input type="hidden" name="promo" id="promo" value="0">
                </div>
            </div>
            <hr>
            <div class="flex-space-between">
                <h3>Total Cost</h3>
                <h3 id="p_total_cost">60</h3>
                <input type="hidden" name="total_cost" id="total_cost" value="">
            </div>
            <p>Cost might vary depending uppon the delivery situations and other circumstances.For details..</p>
            <a class="quick-links" href="" style="text-decoration:underline;">Check the price plan</a>
            <p>*** Pickup Last Entry Time 4pm</p>
            <p>*** On Demand Last Entry Time 12:30pm</p>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script src="{{asset('js/app.js')}}"></script>

<script>
    $( document ).ready(function() {
        document.querySelector("#merchant").addEventListener('change',function(){
            const userId = document.querySelector("#merchant").value;
            document.querySelector("#store").innerHTML= "";

            axios.get(`/admin/getStore/${userId}`)
            .then(function (response) {
                if (response.data.length === 0) {
                    let option = document.createElement("option");
                    option.innerText = "No store is assigned for this merchant";
                    let target = document.querySelector("#store"); 
                    target.appendChild(option);
                }
                else{
                    (response.data).forEach(store => {

                        let option = document.createElement("option");
                        option.value = store.id;
                        option.text = store.store_name;
                        let target = document.querySelector("#store");
                        target.appendChild(option);
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
        
        document.querySelector("#city").addEventListener('change',function(){

            const cityId = document.querySelector("#city").value;
            document.querySelector("#zone").innerHTML= "";

            axios.get(`/getZone/${cityId}`)
            .then(function (response) {
                if (response.data.length === 0) {
                    let option = document.createElement("option");
                    option.innerText = "No zone is available for this city";
                    let target = document.querySelector("#zone"); 
                    target.appendChild(option);

                    console.log(target);

                    let option2 = document.createElement("option");
                    option2.innerText = "No area is available";
                    let target2 = document.querySelector("#area");
                    target2.appendChild(option2);
                }
                else{
                    (response.data).forEach(zone => {
                    
                        // console.log(zone)
                        let option = document.createElement("option");
                        option.value = zone.id;
                        option.text = zone.zone_name;
                        let target = document.querySelector("#zone");
                        target.appendChild(option);
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


        document.querySelector("#zone").addEventListener('change',function(){

            const zoneId = document.querySelector("#zone").value;
            document.querySelector("#area").innerHTML= "";

            axios.get(`/getArea/${zoneId}`)
            .then(function (response) {
                (response.data).forEach(area => {
                    
                    // console.log(zone)
                    let option = document.createElement("option");
                    option.value = area.id;
                    option.text = area.area_name;
                    let target = document.querySelector("#area");
                    target.appendChild(option);
                    
                    console.log(target)
                    
                });
            })
            .catch(function (error) {
                console.log(error);
            })
            .then(function () {
                // always executed
            });  
        });

        document.querySelector("#amount").addEventListener('change',function(){
            let amount = document.querySelector("#amount").value;
            document.querySelector("#p_cod").innerHTML = amount;
            document.querySelector("#cod").value = amount;

            let total_cost = parseInt(document.querySelector("#cod").value)+ parseInt(document.querySelector("#delivery_fee").value)
                            +  parseInt(document.querySelector("#promo").value);
            document.querySelector("#p_total_cost").innerHTML = total_cost;
            document.querySelector("#total_cost").value = total_cost;
            

        });    
    });
</script>
@endpush