@extends('admin.layout.master')
@section('content')
<div class="login-container">
    <div class="bg-white">
    <form action="{{route('admin.package.update',$package->id)}}" method="post">
            @csrf
            <div class="flex-column p-50-10">

                <h2 class="mb-40">Edit Package</h2>
                @if (session('status'))
                    <div>
                        <p class="error-message">{{ session('status') }}</p>
                    </div>
                @endif

                <label for="name">Package Name</label>
                <input type="text" name="package_name" value="{{$package->name}}" placeholder="Enter Package Name" required>
                <label for="name">Package Price</label>
                <input type="text" name="package_price" value="{{$package->price}}" placeholder="Enter Package Price" required>
                
                <div class="btn-container">
                    <button class="border register" type="submit">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection