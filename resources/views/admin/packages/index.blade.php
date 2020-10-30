@extends('admin.layout.master')
@section('content')
<div class="store-wrapper">
    <div class="btn-store">
    <a href="{{route('admin.package.create')}}"><button class="border" style="color:white; margin-bottom:20px;"><i class="fa fa-plus-circle fa-lg icon-mr-10" aria-hidden="true"></i>Creat Package</button></a>
    </div>
    @if (session('status'))
    <div class="">
        {{session('status')}}
    </div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach ($packages as $package)
                <tr class="table-body-row">
                <td class="text-center w-10">{{++$loop->index}}</td>
                    <td class="text-center">{{$package->name}}</td>
                    <td class="text-center">{{$package->price}}</td>
                    <td class="text-center w-25">
                        <a href="{{route('admin.package.edit',$package->id)}}"><button class="border" style="color:white;">Edit</button></a>
                    <a href="{{route('admin.package.destroy',$package->id)}}"><button class="border" style="color:white;">Delete</button></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection