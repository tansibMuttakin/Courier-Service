@extends('login-registration.layout')
@section('content')
<div class="login-container">
    <div class="bg-white flex justify-center item-center">
        <form action="{{ route('authenticate') }}" method="post">
            @csrf
            <div class="flex-column p-50-10">

                <h2 class="mb-40">Login</h2>
                @if (session('status'))
                    <div>
                        <p class="error-message">{{ session('status') }}</p>
                    </div>
                @endif

                <label for="email">Email</label>
                <input type="email" name="email" placeholder="Enter Email Address">
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Enter Password">
                <a href="{{ route('password.request') }}">FORGOT PASSWORD</a>
                <div class="btn-container">
                    <button class="border" type="submit">Login</button>
                <a href="{{route('merchant.register')}}" ><button class="border register" type="button">Register</button></a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection