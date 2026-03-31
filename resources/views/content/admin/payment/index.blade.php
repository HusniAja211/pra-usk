@extends('app')

@section('content')
    <h3 class="mb-4">Incoming Payments</h3>

    {{-- Pesan Sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">

            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Order ID</th>
                        <th>User</th>
                        <th>Book</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Bukti Transfer</th>
                        <th>Status</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>{{ $order->user->name ?? '-' }}</td>
                            <td>{{ $order->book->title ?? '-' }}</td>
                            <td>{{ $order->qty }}</td>
                            <td class="fw-bold text-success">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </td>

                            {{-- Tampilkan Bukti Transfer dengan Modal --}}
                            <td>
                                @if($order->payment && $order->payment->proof)
                                    <button type="button" class="btn btn-sm btn-info text-white" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#proofModal"
                                            data-img-url="{{ asset('storage/' . $order->payment->proof) }}">
                                        Lihat Bukti
                                    </button>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>
                                <span class="badge bg-warning text-dark">Pending</span>
                            </td>

                            {{-- Action Buttons --}}
                            <td>
                                <div class="d-flex gap-2">
                                    {{-- Tombol Approve --}}
                                    <form action="{{ route('admin.payment.approve', $order->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-success btn-sm">Approve</button>
                                    </form>

                                    {{-- Tombol Tolak (Trigger Modal) --}}
                                    <button type="button" class="btn btn-danger btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#rejectModal" 
                                            data-orderid="{{ $order->id }}">
                                        Tolak
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No incoming payments</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL LIHAT BUKTI TRANSFER --}}
    <div class="modal fade" id="proofModal" tabindex="-1" aria-labelledby="proofModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="proofModalLabel">Bukti Transfer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    {{-- Gambar akan di-load ke tag img ini oleh JavaScript --}}
                    <img id="proofImage" src="" alt="Bukti Transfer" class="img-fluid rounded shadow-sm" style="max-height: 80vh; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL REJECT --}}
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Alasan Penolakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form id="rejectForm" method="POST" action="">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="reject_reason" class="form-label">Berikan alasan mengapa pembayaran ditolak <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="reject_reason" name="reject_reason" rows="3" required placeholder="Contoh: Bukti transfer buram, nominal tidak sesuai..."></textarea>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Tolak Pesanan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            // 1. Script untuk Modal Reject
            var rejectModal = document.getElementById('rejectModal');
            rejectModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget; 
                var orderId = button.getAttribute('data-orderid'); 
                var form = document.getElementById('rejectForm');
                var actionUrl = "{{ route('admin.payment.reject', ':id') }}";
                form.action = actionUrl.replace(':id', orderId);
            });

            // 2. Script untuk Modal Lihat Bukti (Baru)
            var proofModal = document.getElementById('proofModal');
            proofModal.addEventListener('show.bs.modal', function (event) {
                // Tangkap tombol yang diklik
                var button = event.relatedTarget; 
                // Ambil URL gambar dari atribut data-img-url
                var imageUrl = button.getAttribute('data-img-url'); 
                // Cari tag <img> di dalam modal dan ubah atribut src-nya
                var modalImg = document.getElementById('proofImage');
                modalImg.src = imageUrl;
            });

        });
    </script>
@endsection