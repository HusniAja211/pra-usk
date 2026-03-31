@extends('app')

@section('content')
<div class="row">
    <div class="col-md-4 col-sm-6">
        <div class="card border-0 shadow-sm custom-card-premium">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <p class="text-uppercase fw-bold text-blue-600 mb-1 small tracking-widest">Pesanan Diterima</p>
                        <h2 class="fw-bold mb-0 text-slate-900">{{ $totalOrders }}</h2>
                    </div>
                    <div class="icon-shape bg-blue-50 text-blue-600 rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 56px; height: 56px;">
                        <i class="ph ph-shopping-cart" style="font-size: 1.8rem;"></i>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top border-blue-50">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small fw-medium">Selesai: <span class="text-blue-600 fw-bold">{{ $completedOrders }}</span></span>
                        <span class="badge bg-blue-50 text-blue-600 rounded-pill px-2 py-1 small">
                            <i class="ph ph-trend-up me-1"></i> +12%
                        </span>
                    </div>
                    <div class="progress" style="height: 6px; background-color: #f1f5f9;">
                        <div class="progress-bar bg-blue-600 rounded-pill" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection