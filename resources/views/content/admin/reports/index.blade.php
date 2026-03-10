@extends('app')

@section('content')

<div class="card bg-grd-primary order-card mb-4">
    <div class="card-body">
        <h6 class="mb-4 text-white">Reports</h6>
        <p class="m-0">This is the reports page. You can view various reports here.</p>
    </div>
</div>

<div class="row">

<div class="col-12 mb-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h6 class="mb-0">Payments per Month</h6>
        </div>
        <div class="card-body">
            @include('content.admin.reports.graphicChart')
        </div>
    </div>
</div>

<div class="col-12">
    <div class="card shadow-sm">
        <div class="card-header">
            <h6 class="mb-0">Top Selling Books</h6>
        </div>
        <div class="card-body">
            @include('content.admin.reports.productReport')
        </div>
    </div>
</div>

</div>

@endsection
