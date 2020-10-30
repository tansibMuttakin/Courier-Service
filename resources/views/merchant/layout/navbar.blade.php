<nav class="bg-white item-center">
    <div class="nav-left">
        <ul class="flex-container">
            <li><a href="{{route('dashboard')}}"><img src="{{asset('assets/photos/courier.PNG')}}" alt="courierService" style="width:160px; height:50px;"></a></li>
        <li><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li><a href="{{route('order.index')}}">Order</a></li>
            <li><a href="">Invoices</a></li>
            <li><a href="{{route('store.index')}}">Stores</a></li>
        </ul>
    </div>
    <div class="nav-right">
        <ul class="flex-space-between item-center">
            <a href="{{route('order.create')}}"><button class="border" style="color:white;"><i class="fa fa-plus-circle fa-lg icon-mr-10" aria-hidden="true"></i>Creat Order</button></a>
            <!-- <button class="border"><a href="" style="color:white;">Creat Order</a></button> -->
            <li>
                <a href="{{route('merchantProfile.edit',auth()->user()->id)}}"><i class="fa fa-user fa-lg" aria-hidden="true"></i> {{auth()->user()->name}}</a>  
            </li>
            <li>
                <a href="{{route('logout')}}" class="logout" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="fa fa-times fa-lg" aria-hidden="true"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('merchant.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
            
        </ul>
    </div>
</nav>

