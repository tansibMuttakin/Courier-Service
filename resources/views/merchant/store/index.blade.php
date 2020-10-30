@extends('merchant.layout.master')
@section('content')
<div class="store-wrapper">
    <div class="btn-store">
        <a href="{{route('store.create')}}"><button class="border" style="color:white; margin-bottom:20px;"><i class="fa fa-plus-circle fa-lg icon-mr-10" aria-hidden="true"></i>Creat Store</button></a>
    </div>
    @if (session('success'))
    <div class="">
        {{session('success')}}
    </div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach($stores as $store)
            <tr class="table-body-row">
                <td class="text-center w-10">{{++$loop->index}}</td>
                <td class="text-center">{{$store->store_name}}</td>
                <td class="text-center">{{$store->address}}</td>
                <td class="text-center w-25">
                    <a href="{{route('store.edit',$store)}}"><button class="border" style="color:white;">Edit</button></a>
                    @if($store->store_status == 0)
                        <a href="{{route('store.chnageStatus',$store)}}"><button class="border" style="color:white; background-color:green;">Active</button></a>
                    @else
                    <a href="{{route('store.chnageStatus',$store)}}"><button class="border" style="color:white; background-color:red;">Deactive</button></a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection