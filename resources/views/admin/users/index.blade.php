@extends('admin.layout.master')
@section('content')
<div class="bg-white border order-wrapper">
    <div class="flex-space-between">
        <h3>Users</h3>
    </div>
    <div class="row flex-space-between item-center">
        <div class="w-17">
            <input type="text" id="merchant_id" placeholder="Merchant Id">
        </div>
        <div class="w-17">
            <input type="text" id="merchant_name" placeholder="Merchant Name">
        </div>
        <div class="w-17">
            <input type="text" id="merchant_email" placeholder="Email">
        </div>
        <div class="w-17">
            <select id="package" name="package">
                <option value="" selected>Packages</option>
                @foreach($packages as $package)
                <option value="{{$package->id}}">{{$package->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="w-17">
            <select id="approval" name="approved">
            <option value="1">Approved</option>
                <option value="0">Disapproved</option>
            </select>
        </div>
        <div>
            <a href="{{route('admin.merchant.csv')}}"><button class="border" style="color:white;">Export CSV</button></a>
        </div>
    </div>
</div>
<div class="border order-wrapper" style="padding:0;">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Merchant Name</th>
                <th>Email</th>
                <th>Package</th>
                <th>Approved</th>
                <th>Details</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id ="t-body" class="bg-white">
            @foreach($users as $user)
            <tr class="table-body-row">
                <td class="text-center w-10">
                    {{$user->id}}
                </td>
                <td class="text-center w-10">{{$user->name}}</td>
                <td class="text-center">{{$user->email}}</td>
                @if(count($user->packages)==0)
                    <td class="text-center">No Package Assigned</td>
                @else
                <td class="text-center">
                    @foreach ($user->packages as $package)
                        <p>{{$package->name}}</p>
                    @endforeach
                </td>
                @endif
                <td class="text-center w-25">
                    @if($user->approved == 0)
                    <a href="{{route('admin.updateApproval',$user->id)}}"><button class="border" style="color:white; background-color:red;">No</button></a>
                    @else
                    <a href="{{route('admin.updateApproval',$user->id)}}"><button class="border" style="color:white; background-color:green;">Yes</button></a>
                    @endif
                </td>
                <td class="text-center"><a href="{{route('admin.merchantDetails',$user->id)}}"><i class="fa fa-info-circle" aria-hidden="true"></i></a></td>
                <td class="text-center">
                    <a href="{{route('admin.user.delete',$user->id)}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    {{-- <button class="border" style="color:white;"></button> --}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/app.js')}}"></script>
<script>

$(document).ready(function(){

    // search by package name
    document.querySelector("#package").addEventListener('change',function(){


        const searchKey = document.querySelector("#package").value;
        document.querySelector("#t-body").innerHTML = '';

        axios.get(`/admin/search-package/${searchKey}`)
        .then(function (response) {
            if (response.data.length === 0) {
                console.log("no order found on that store");
            }
            else{
                
                (response.data).forEach(user => {
                    let packages = user.packages
                    let tbody = document.querySelector("#t-body");
                    tbody.innerHTML += `
                    <tr class="table-body-row">
                        <td class="text-center w-10">
                            ${user.id}
                        </td>
                        <td class="text-center w-10">${user.name}</td>
                        <td class="text-center">${user.email}</td>
                        <td id="package-${user.id}" class="text-center">
                            ${user.packages}
                        </td>
                        <td id="approval-${user.id}" class="text-center">
                        </td>
                
                        <td class="text-center"><a href=""><i class="fa fa-info-circle" aria-hidden="true"></i></a></td>
                        <td class="text-center">
                            <a href=""><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                    </tr>`
                    document.querySelector(`#package-${user.id}`).innerHTML = ''
                    user.packages.forEach(el=>{
                        let pNode = document.querySelector(`#package-${user.id}`);
                        pNode.innerHTML += `<p>${el.name}</p>`;
                    })
                    if(user.approved == 0){
                        let pNode = document.querySelector(`#approval-${user.id}`);
                        pNode.innerHTML = "";
                        pNode.innerHTML = `<a href=""><button class="border" style="color:white; background-color:red;">No</button></a>`;
                        
                    }
                    else{
                        let pNode = document.querySelector(`#approval-${user.id}`);
                        pNode.innerHTML = "";
                        pNode.innerHTML = `<a href=""><button class="border" style="color:white; background-color:green;">Yes</button></a>`;
                    }

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

    //search by id
    document.querySelector("#merchant_id").addEventListener('change',function(){


        const user_id = document.querySelector("#merchant_id").value;
        document.querySelector("#t-body").innerHTML = '';

        axios.get(`/admin/search-id/${user_id}`)
        .then(function (response) {
            if (response.data.length === 0) {
                console.log("no order found on that store");
            }
            else{
                (response.data).forEach(user => {
                    let tbody = document.querySelector("#t-body");
                    tbody.innerHTML += `
                    <tr class="table-body-row">
                        <td class="text-center w-10">
                            ${user.id}
                        </td>
                        <td class="text-center w-10">${user.name}</td>
                        <td class="text-center">${user.email}</td>
                        <td id="package-${user.id}" class="text-center">
                            ${user.packages}
                        </td>
                        <td id="approval-${user.id}" class="text-center">
                        </td>
                
                        <td class="text-center"><a href=""><i class="fa fa-info-circle" aria-hidden="true"></i></a></td>
                        <td class="text-center">
                            <a href=""><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                    </tr>`
                    document.querySelector(`#package-${user.id}`).innerHTML = ''
                    user.packages.forEach(el=>{
                        let pNode = document.querySelector(`#package-${user.id}`);
                        pNode.innerHTML += `<p>${el.name}</p>`;
                    })
                    if(user.approved == 0){
                        let pNode = document.querySelector(`#approval-${user.id}`);
                        pNode.innerHTML = "";
                        pNode.innerHTML = `<a href=""><button class="border" style="color:white; background-color:red;">No</button></a>`;
                        
                    }
                    else{
                        let pNode = document.querySelector(`#approval-${user.id}`);
                        pNode.innerHTML = "";
                        pNode.innerHTML = `<a href=""><button class="border" style="color:white; background-color:green;">Yes</button></a>`;
                    }
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

    //search by name
    document.querySelector("#merchant_name").addEventListener('change',function(){


        const user_name = document.querySelector("#merchant_name").value;
        document.querySelector("#t-body").innerHTML = '';

        axios.get(`/admin/search-name/${user_name}`)
        .then(function (response) {
            if (response.data.length === 0) {
                console.log("no order found on that store");
            }
            else{
                (response.data).forEach(user => {
                    let tbody = document.querySelector("#t-body");
                    tbody.innerHTML += `
                    <tr class="table-body-row">
                        <td class="text-center w-10">
                            ${user.id}
                        </td>
                        <td class="text-center w-10">${user.name}</td>
                        <td class="text-center">${user.email}</td>
                        <td id="package-${user.id}" class="text-center">
                            ${user.packages}
                        </td>
                        <td id="approval-${user.id}" class="text-center">
                        </td>
                
                        <td class="text-center"><a href=""><i class="fa fa-info-circle" aria-hidden="true"></i></a></td>
                        <td class="text-center">
                            <a href=""><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                    </tr>`
                    document.querySelector(`#package-${user.id}`).innerHTML = ''
                    user.packages.forEach(el=>{
                        let pNode = document.querySelector(`#package-${user.id}`);
                        pNode.innerHTML += `<p>${el.name}</p>`;
                    })
                    if(user.approved == 0){
                        let pNode = document.querySelector(`#approval-${user.id}`);
                        pNode.innerHTML = "";
                        pNode.innerHTML = `<a href=""><button class="border" style="color:white; background-color:red;">No</button></a>`;
                        
                    }
                    else{
                        let pNode = document.querySelector(`#approval-${user.id}`);
                        pNode.innerHTML = "";
                        pNode.innerHTML = `<a href=""><button class="border" style="color:white; background-color:green;">Yes</button></a>`;
                    }
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

    //search by email
    document.querySelector("#merchant_email").addEventListener('change',function(){


        const user_email = document.querySelector("#merchant_email").value;
        document.querySelector("#t-body").innerHTML = '';

        axios.get(`/admin/search-email/${user_email}`)
        .then(function (response) {
            if (response.data.length === 0) {
                console.log("no order found on that store");
            }
            else{
                (response.data).forEach(user => {
                    let tbody = document.querySelector("#t-body");
                    tbody.innerHTML += `
                    <tr class="table-body-row">
                        <td class="text-center w-10">
                            ${user.id}
                        </td>
                        <td class="text-center w-10">${user.name}</td>
                        <td class="text-center">${user.email}</td>
                        <td id="package-${user.id}" class="text-center">
                            ${user.packages}
                        </td>
                        <td id="approval-${user.id}" class="text-center">
                        </td>
                
                        <td class="text-center"><a href=""><i class="fa fa-info-circle" aria-hidden="true"></i></a></td>
                        <td class="text-center">
                            <a href=""><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                    </tr>`
                    document.querySelector(`#package-${user.id}`).innerHTML = ''
                    user.packages.forEach(el=>{
                        let pNode = document.querySelector(`#package-${user.id}`);
                        pNode.innerHTML += `<p>${el.name}</p>`;
                    })
                    if(user.approved == 0){
                        let pNode = document.querySelector(`#approval-${user.id}`);
                        pNode.innerHTML = "";
                        pNode.innerHTML = `<a href=""><button class="border" style="color:white; background-color:red;">No</button></a>`;
                        
                    }
                    else{
                        let pNode = document.querySelector(`#approval-${user.id}`);
                        pNode.innerHTML = "";
                        pNode.innerHTML = `<a href=""><button class="border" style="color:white; background-color:green;">Yes</button></a>`;
                    }
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
    //search by approval
    document.querySelector("#approval").addEventListener('change',function(){


    const searchKey = document.querySelector("#approval").value;
    document.querySelector("#t-body").innerHTML = '';

        axios.get(`/admin/search-approved/${searchKey}`)
        .then(function (response) {
            if (response.data.length === 0) {
                console.log("no order found on that store");
            }
            else{
                
                (response.data).forEach(user => {
                    let packages = user.packages
                    let tbody = document.querySelector("#t-body");
                    tbody.innerHTML += `
                    <tr class="table-body-row">
                        <td class="text-center w-10">
                            ${user.id}
                        </td>
                        <td class="text-center w-10">${user.name}</td>
                        <td class="text-center">${user.email}</td>
                        <td id="package-${user.id}" class="text-center">
                            ${user.packages}
                        </td>
                        <td id="approval-${user.id}" class="text-center">
                        </td>
                
                        <td class="text-center"><a href=""><i class="fa fa-info-circle" aria-hidden="true"></i></a></td>
                        <td class="text-center">
                            <a href=""><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                    </tr>`
                    document.querySelector(`#package-${user.id}`).innerHTML = ''
                    user.packages.forEach(el=>{
                        let pNode = document.querySelector(`#package-${user.id}`);
                        pNode.innerHTML += `<p>${el.name}</p>`;
                    })
                    if(user.approved == 0){
                        let pNode = document.querySelector(`#approval-${user.id}`);
                        pNode.innerHTML = "";
                        pNode.innerHTML = `<a href=""><button class="border" style="color:white; background-color:red;">No</button></a>`;
                        
                    }
                    else{
                        let pNode = document.querySelector(`#approval-${user.id}`);
                        pNode.innerHTML = "";
                        pNode.innerHTML = `<a href=""><button class="border" style="color:white; background-color:green;">Yes</button></a>`;
                    }

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

});

</script>
@endpush