@extends('login-registration.layout')
@section('content')
<div class="register-container">
    <div class="bg-white">
        @if ($errors->any())
            <div class="alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{route('merchant.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="flex-column form-element">
                <h2 class="mb-40">Merchant Regsitration</h2>
                <br>
                <div id="account-info" class="flex-space-between cursor-pointer">
                    <p class="sub-heading">Account Information</p>
                    <div>
                        <i class="fa fa-chevron-up"></i>
                    </div>
                </div>
                <div>
                    <hr>
                </div>
                <div class="account-info-content">
                    <div class=" row flex-space-between">
                        <div class="col-6">
                            <label for="name">Owner's Full Name</label>
                            <input type="text" name="name" placeholder="Enter Owners name" required> 
                        </div>
                        <div class="col-6">
                            <label for="mobile">Mobile</label>
                            <input type="text" name="mobile" placeholder="Enter Mobile Number" required> 
                        </div>
                    </div>
                    <div class="row flex-space-between">
                        <div class="col-6">
                            <label for="email">Email</label>
                            <input type="text" name="email" placeholder="Enter Email" required> 
                        </div>
                        <div class="col-6">
                            <label for="">Countey Of Operation</label>
                            <select name="country_of_operation" id="">
                                <option value="Bangladesh">Bangladesh</option>
                            </select>
                        </div>
                    </div>
                    <div class="row flex-space-between">
                        <div class="col-6">
                            <label for="password">Password</label>
                            <input type="password" name="password" placeholder="Enter Password" required> 
                        </div>
                        <div class="col-6">
                            <label for="retype-password">Retype Password</label>
                            <input type="password" name="confirm_password" placeholder="Enter Password Again" required> 
                        </div>
                    </div>
                </div>
                <div id="business-info" class="row flex-space-between cursor-pointer">
                    <p class="sub-heading">Business Information</p>
                    <div>
                        <i class="fa fa-chevron-up"></i>
                    </div>
                </div>
                <div>
                    <hr>
                </div>
                <div class="business-info-content row flex-column">
                    <div class="row col-6">
                        <label for="business-name">Name Of Your Business</label>
                        <input type="text" name="business_name" placeholder="Business Name" required>
                    </div>
                    <div class="row">
                        <label for="business-address">Address</label>
                        <textarea name="business_address" id="" cols="30" rows="3" placeholder="Enter Business Address" required></textarea>
                    </div>
                </div>
                <div id="payment-info" class="row flex-space-between cursor-pointer">
                    <p class="sub-heading">Payment Information</p>
                    <div>
                        <i class="fa fa-chevron-up"></i>
                    </div>
                </div>
                <div>
                    <hr>
                </div>
                <div class="payment-info-content">
                    <div clas="row">
                        <p>Payment Type</p>
                        <input type="radio" name="payment_type" id="bank" value="bank" checked>
                        <label for="">Bank</label>
                        <input style="margin-left: 0;" type="radio" name="payment_type" id="mobile" value="mobile">
                        <label for="">Mobile</label>
                    </div>
                    <div id="bank-info">
                        <div class="row flex-space-between">
                            <div class="col-6">
                                <label for="">Wallet Provider</label>
                                <select name="wallet_provider" id="wallet_provider">
                                    <option value="">Select An Wallet Provider</option>
                                    <option value="south_east_bank">SouthEast Bank</option>
                                    <option value="bank_asia">Bank Asia</option>
                                    <option value="ucb_bank">UCB Bank</option>
                                </select>
                            </div>
                            <div class="bank col-6">
                                <label for="">Branch Name</label>
                                <input type="text" name="branch_name" id="" placeholder="Bank Branch name">
                            </div>
                        </div>
                        <div class="bank row flex-space-between">
                            <div class="col-6">
                                <label for="">Routing Number</label>
                                <input type="text" name="routing_number" id="" Placeholder="Bank Routing No">
                            </div>
                            <div class="col-6">
                                <label for="">Account Type</label>
                                <select name="account_type" id="">
                                    <option value="">Select Provider Account Type</option>
                                    <option value="current">Current</option>
                                    <option value="savings">Savings</option>
                                </select>
                            </div>
                        </div>
                        <div class="row flex-space-between">
                            <div class="bank col-6">
                                <label for="">Account Holder Name</label>
                                <input type="text" name="account_holder_name" id="" placeholder="Provide account holder Name">
                            </div>
                            <div class="col-6">
                                <label for="">Account Number</label>
                                <input type="text" name="account_number" id="" placeholder="Account Number">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="verification-info" class="row flex-space-between cursor-pointer">
                    <p class="sub-heading">Verification Information</p>
                    <div>
                        <i class="fa fa-chevron-up"></i>
                    </div>
                </div>
                <div>
                    <hr>
                </div>
                <div class="verification-info-content">
                    <div clas="row">
                        <p>ID Type</p>
                        <input style="margin-left: 0;" type="radio" name="id_type" id="nid" value="nid" checked>
                        <label for="">NID</label>
                        <input type="radio" name="id_type" id="passport" value="passport">
                        <label for="">Passport</label>
                        <input type="radio" name="id_type" id="birth-certificate" value="birth_certificate">
                        <label for="">Birth Certificate</label>
                        <input type="radio" name="id_type" id="driving-license" value="driving_license">
                        <label for="">Driving License</label>
                    </div>
                    <div class="row flex-space-between">
                        <div class="col-6">
                            <label for="">ID Number</label>
                            <input type="text" name="id_number" id="" placeHolder="Enter Id Number" required>
                        </div>
                        <div class="image-holder flex col-6 item-center">
                            <div  style="margin:0; padding:0;">
                                <label for="">ID's Front Image</label>
                                <input type="text" id="" placeholder="" value="" disabled>
                            </div>
                            <label id ="image-label" class="border flex justify-center item-center cursor-pointer upload-file">Upload
                                <input class="display-none" id="id-front-image" type="file" name="id_front_image">
                            </label>
                        </div>
                    </div>
                </div>
                <div>
                    <input type="checkbox" name="tac_agreement" id="" required>
                    <label for="">I Agrre With This Terms And Conditions</label>
                </div>
                <div class="btn-container">
                    <button class="border" type="submit">Register</button>
                    <a href="{{route('merchant.login')}}" ><button class="border register" type="button">Cancel</button></a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{asset('js/app.js')}}"></script>
<script>
    $(document).ready(function(){
        document.querySelector("#account-info").addEventListener('click',function(){
            let element = document.querySelector(".account-info-content")
            element.classList.toggle("display-none")
        });
        document.querySelector("#business-info").addEventListener('click',function(){
            let element = document.querySelector(".business-info-content")
            element.classList.toggle("display-none")
        });
        document.querySelector("#payment-info").addEventListener('click',function(){
            let element = document.querySelector(".payment-info-content")
            element.classList.toggle("display-none")
        });
        document.querySelector("#verification-info").addEventListener('click',function(){
            let element = document.querySelector(".verification-info-content")
            element.classList.toggle("display-none")
        });
        document.querySelector("#mobile").addEventListener('click',function(){
            let elements = document.querySelectorAll(".bank")
            elements.forEach(element => {
                element.classList.add("display-none")
            });
            let html = 
            `
            <option value="">Select An Wallet Provider</option>
            <option value="bkash">Bkash</option>
            <option value="rocket">Rocket</option>
            `
            document.querySelector("#wallet_provider").innerHTML=''
            document.querySelector("#wallet_provider").innerHTML= html
        });
        document.querySelector("#bank").addEventListener('click',function(){
            let elements = document.querySelectorAll(".bank")
            elements.forEach(element => {
                element.classList.remove("display-none")
            });
            let html = 
            `
            <option value="">Select An Wallet Provider</option>
            <option value="south_east_bank">SouthEast Bank</option>
            <option value="bank_asia">Bank Asia</option>
            <option value="ucb_bank">UCB Bank</option>
            `
            document.querySelector("#wallet_provider").innerHTML=''
            document.querySelector("#wallet_provider").innerHTML= html
            
        });
        // document.querySelector("#image-label").addEventListener('click',function(){
        //     let element = document.querySelector("#id-front-image").value
        //     console.log(element)
        // });
    });
</script>
@endpush