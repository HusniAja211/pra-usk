@extends('app')
@section('content')
    <div class="card bg-grd-primary order-card">
        <div class="card-body">
            <h6 class="text-white">Orders Received</h6>
            <h2 class="text-end text-white"><i class="feather icon-shopping-cart float-start"></i><span>{{ $totalOrders }}</span> </h2>
            <p class="m-b-0">Completed Orders<span class="float-end">{{ $completedOrders }}</span></p>
        </div>
    </div>
@endsection
