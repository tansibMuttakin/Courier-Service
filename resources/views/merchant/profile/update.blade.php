@extends('merchant.layout.master')
@section('content')
<div class="bg-white border form-center form-align-center">
<form style="margin-top:50px;" action="{{route('merchantProfile.update',$merchant->id)}}" method="POST">
        @csrf
        <div class="row">
            <label for="country">Name</label>
        <input type="text" placeholder="Enter Name" name="name" value="{{$merchant->name}}" required>
        </div>
        <div class="row">
            <label for="country">Email</label>
            <input type="text" placeholder="Enter Email" name="email" value="{{$merchant->email}}" required>
        </div>
        <div class="row">
            <label for="country">Old Password</label>
            <input type="text" name="old_password" placeholder="Old Password" required>
        </div>
        <div class="row">
            <label for="country">New Password</label>
            <input type="text" name="new_password" placeholder="New Password" required>
        </div>
        <div class="row">
            <label for="country">Confirm Password</label>
            <input type="text" name="confirm_password" placeholder="Confirm Password" required>
        </div>
        <div class="form-submit-button">
            <button class="button-success" type="submit">Save</button>
            <button class="button-danger" type="submit">Cancel</button>
        </div>
    </form>
</div>
@endsection