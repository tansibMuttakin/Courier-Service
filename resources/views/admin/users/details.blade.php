@extends('admin.layout.master')
@section('content')
<div class="register-container">
    <div class="bg-white">  
    <form action="{{route('admin.merchant.update',$user->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="flex-column form-element">
                <h2 class="mb-40">Merchant Information</h2>
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
                    <p>Merchant Name: {{$user->name}}</p> 
                    <p>Contact Number: {{$user->mobile}}</p> 
                    <p>Email: {{$user->email}}</p>
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
                    <p>Business Name: {{$user->businessInfo->business_name}}</p> 
                    <p>Address: {{$user->businessInfo->business_address}}</p>
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
                    <p>Payment Type: {{$user->paymentInfo->payment_type}}</p>
                    <p>Wallet Provider: {{$user->paymentInfo->wallet_provider}}</p>
                    @if($user->paymentInfo->payment_type == 'bank')
                        <p>Branch: {{$user->paymentInfo->branch_name}}</p>
                        <p>Routing Number: {{$user->paymentInfo->routing_number}}</p>
                        <p>Account Type: {{$user->paymentInfo->account_type}}</p>
                        <p>Account Holder: {{$user->paymentInfo->account_holder_name}}</p>
                    @endif
                    <p>Account Number: {{$user->paymentInfo->account_number}}</p>
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
                   <p>ID Type: {{$user->verificationInfo->id_type}}</p>
                   <p>Number: {{$user->verificationInfo->id_number}}</p>
                   <p>Image:</p>
                   <img src="" alt="{{$user->verificationInfo->id_type}}-image">
                </div>
                <br><br>
                <div>
                    <label for="">Packages</label>
                    <select class="multiple-select" name="packages[]" id="" multiple>
                        <option value="">choose..</option>
                        @foreach ($packages as $package)
                            <option value="{{$package}}">{{$package->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="btn-container">
                    {{-- @if($user->approved == 0)
                        <a href="{{route('admin.updateApproval',$user->id)}}" ><button class="border register" type="button">Approve</button></a>
                    @else
                    @endif --}}
                    <button class="border" style="color:white;">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.multiple-select').select2({
            placeholder:'packages',
        });
    });
</script>
@endpush
