@extends('merchant.layout.master')
@section('content')
<div class="bg-white border form-center">
    <h3>Create Store</h3>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <form action="{{route('store.store')}}" method="post" style="margin-top:50px;">
    @csrf
        <div class="row flex-space-between">
            <div class="col-6">
                <label for="country">Store Name</label>
                <input type="text" name="store_name" placeholder="store name" required>
                <p><i>Only english character is allowed</i></p>
            </div>
            <div class="col-6">
                <label for="country">Store Contact Name</label>
                <input type="text" name="store_contact_name" placeholder="store contact name" required>
            </div>
        </div>
        <div class="row flex-space-between">
            <div class="col-6">
                <label for="country">Contact Number</label>
                <input type="text" name="contact_number" placeholder="contact number" required>
            </div>
            <div class="col-6">
                <label for="country">Secondary Contact Number</label>
                <input type="text" name="secondary_contact_number" placeholder="secondary contact number" required>
            </div>
        </div>
        <div class="row flex-space-between">
            <div class="col-4">
                <label for="city">Select City</label>
                <select id="city" name="city">
                    <option selected>choose...</option>
                    @foreach($cities as $city)
                    <option value="{{$city->id}}">{{$city->city_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-4">
                <label for="zone">Select Zone</label>
                <select id="zone" name="zone">
                    <option selected>choose city first</option>
                </select>
            </div>
            <div class="col-4">
                <label for="area">Select Area</label>
                <select id="area" name="area">
                
                </select>
            </div>
        </div>
        <div>
            <label for="country">Store Address</label>
            <input type="text" name="store_address" paceholder="Enter Store Address" required>
            <p><i>Only english character is allowed</i></p>
        </div>
        <div class="form-submit-button">
            <button class="button-success" type="submit">Save</button>
            <button class="button-danger" type="submit">Cancel</button>
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
    });
</script>
@endpush