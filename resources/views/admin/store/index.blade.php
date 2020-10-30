@extends('admin.layout.master')
@section('content')
<div class="store-wrapper">
    <div class="btn-store">
    <a href="{{route('admin.store.create')}}"><button class="border" style="color:white; margin-bottom:20px;"><i class="fa fa-plus-circle fa-lg icon-mr-10" aria-hidden="true"></i>Creat Store</button></a>
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
                <th>Shop-Name</th>
                <th>Owner-Name</th>
                <th>Shop-Address</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach($stores as $store)
            <tr class="table-body-row">
                <td class="text-center w-10">{{++$loop->index}}</td>
                <td class="text-center">{{$store->store_name}}</td>
                @if($store->user->type == 'admin')
                <td class="text-center">Admin</td>
                @else
                <td class="text-center">{{$store->user->name}}</td>
                @endif
                <td class="text-center">{{$store->address}}</td>
                <td class="text-center">
                    @if($store->store_status == 0)
                        <a href="{{route('admin.store.chnageStatus',$store)}}"><button class="border" style="color:white; background-color:red;">Deactive</button></a> 
                    @else
                        <a href="{{route('admin.store.chnageStatus',$store)}}"><button class="border" style="color:white; background-color:green;">Active</button></a> 
                    @endif
                </td>
                <td class="text-center w-25">
                    <a href="{{route('admin.store.edit',$store)}}"><button class="border" style="color:white;">Edit</button></a>
                    <a href="{{route('admin.store.destroy',$store->id)}}"><button class="border" style="color:white; background-color:red;">Delete</button></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection