@extends('admin.layout.master')
@section('content')
<div class="bg-white border form-center">
    <h3>Update Store Info</h3>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
<form action="{{route('admin.store.update',$store)}}" method="post" style="margin-top:50px;">
    @csrf
        <div class="row flex-space-between">
            <div class="col-6">
                <label for="country">Store Name</label>
                <input type="text" name="store_name" placeholder="store name" value="{{$store->store_name}}" required>
                <p><i>Only english character is allowed</i></p>
            </div>
            <div class="col-6">
                <label for="country">Store Contact Name</label>
                <input type="text" name="store_contact_name" value="{{$store->store_contact_name}}" placeholder="store contact name" required>
            </div>
        </div>
        <div class="row flex-space-between">
            <div class="col-6">
                <label for="country">Contact Number</label>
                <input type="text" name="contact_number" value="{{$store->contact_number}}" placeholder="contact number" required>
            </div>
            <div class="col-6">
                <label for="country">Secondary Contact Number</label>
                <input type="text" name="secondary_contact_number" value="{{$store->secondary_contact_number}}" placeholder="secondary contact number" required>
            </div>
        </div>
        <div class="row flex-space-between">
            <div class="col-4">
                <label for="city">Select City</label>
                <select id="city" name="city">
                    @foreach($cities as $city)
                        @if($store->city==$city->id)
                        <option value="{{$city->id}}" selected>{{$city->city_name}}</option>
                        @else
                        <option value="{{$city->id}}">{{$city->city_name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-4">
                <label for="zone">Select Zone</label>
                <select id="zone" name="zone">
                    @foreach($zones as $zone)
                        @if($store->zone == $zone->id)
                        <option value="{{$zone->id}}" selected>{{$zone->zone_name}}</option>
                        @else
                        <option value="{{$zone->id}}">{{$zone->zone_name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-4">
                <label for="area">Select Area</label>
                <select id="area" name="area">
                    @foreach($areas as $area)
                        @if($store->area == $area->id)
                        <option value="{{$area->id}}" selected>{{$area->area_name}}</option>
                        @else
                        <option value="{{$area->id}}">{{$area->area_name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <label for="country">Store Address</label>
            <input type="text" name="store_address" value="{{$store->address}}" paceholder="Enter Store Address" required>
            <p><i>Only english character is allowed</i></p>
        </div>
        <div class="row col-4">
            <label for="country">Assign Avilable Merchant</label>
            <select id="merchant" name="merchant">
                <option>choose...</option>
                @foreach($users as $user)
                    @if($user->id == $store->user->id)
                    <option value="{{$user->id}}" selected>{{$user->name}}</option>
                    @else
                    <option value="{{$user->id}}">{{$user->name}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-submit-button">
            <button class="button-success" type="submit">Save</button>
        <a href="{{route('admin.store.index')}}"><button class="button-danger" type="button">Cancel</button></a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/app.js')}}"></script>

<script>
    $( document ).ready(function() {
        
        document.querySelector("#city").addEventListener('change',function(){

            const cityId = document.querySelector("#city").value;
            document.querySelector("#zone").innerHTML= "";

            axios.get(`/getZone/${cityId}`)
            .then(function (response) {
                
                (response.data).forEach(zone => {
                    
                    // console.log(zone)
                    let option = document.createElement("option");
                    option.value = zone.id;
                    option.text = zone.zone_name;
                    let target = document.querySelector("#zone");
                    target.appendChild(option);
                });
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
    });
</script>
@endpush