@extends('app')

@section('content')
    <h3 class="mb-4">My Purchase History</h3>

    {{-- Pesan Sukses --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">

            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Order ID</th>
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
                            <td>{{ $order->book->title ?? '-' }}</td>
                            <td>{{ $order->qty }}</td>
                            <td class="fw-bold text-success">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </td>

                            {{-- Tampilkan Bukti Transfer dengan Modal --}}
                            <td>
                                @if ($order->payment && $order->payment->proof)
                                    <button type="button" class="btn btn-sm btn-info text-white" data-bs-toggle="modal"
                                        data-bs-target="#proofModal"
                                        data-img-url="{{ asset('storage/' . $order->payment->proof) }}">
                                        Lihat Bukti
                                    </button>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            {{-- Badge Status Dinamis --}}
                            <td>
                                @if ($order->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($order->status == 'paid')
                                    <span class="badge bg-success">Paid</span>
                                @else
                                    <span class="badge bg-danger">Cancelled</span>
                                @endif
                            </td>

                            {{-- Action Buttons Khusus User --}}
                            <td>
                                <div class="d-flex gap-2">
                                    @if ($order->status == 'pending')
                                        <span class="text-muted small">Menunggu Verifikasi...</span>

                                    @elseif($order->status == 'paid' && $order->payment)
                                        {{-- Tombol Lihat Invoice --}}
                                        {{-- Catatan: Pastikan kamu membuat route 'user.payment.invoice' di web.php --}}
                                        <a href="{{ route('user.payment.invoice', $order->payment->id) }}" target="_blank"
                                            class="btn btn-primary btn-sm">
                                            Lihat Invoice
                                        </a>

                                    @elseif($order->status == 'cancelled')
                                        {{-- Tombol Lihat Alasan Penolakan --}}
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#reasonModal" 
                                            data-reason="{{ $order->payment->reject_reason ?? 'Pesanan dibatalkan oleh admin.' }}">
                                            Lihat Alasan
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada riwayat pembelian.</td>
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
                    <h5 class="modal-title" id="proofModalLabel">Bukti Transfer Saya</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="proofImage" src="" alt="Bukti Transfer" class="img-fluid rounded shadow-sm"
                        style="max-height: 80vh; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL ALASAN PENOLAKAN --}}
    <div class="modal fade" id="reasonModal" tabindex="-1" aria-labelledby="reasonModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="reasonModalLabel">Pesanan Ditolak</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-1 fw-bold">Alasan Penolakan:</p>
                    <div class="alert alert-danger" id="rejectReasonText">
                        </div>
                    <p class="mb-0 text-muted small">Silakan lakukan pemesanan ulang dan pastikan bukti transfer sudah sesuai.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // 1. Script untuk Modal Lihat Bukti (Sama dengan Admin)
            var proofModal = document.getElementById('proofModal');
            proofModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var imageUrl = button.getAttribute('data-img-url');
                var modalImg = document.getElementById('proofImage');
                modalImg.src = imageUrl;
            });

            // 2. Script untuk Modal Alasan Penolakan (Khusus User)
            var reasonModal = document.getElementById('reasonModal');
            reasonModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var reason = button.getAttribute('data-reason'); // Ambil alasan dari atribut data-reason
                var reasonContainer = document.getElementById('rejectReasonText');
                reasonContainer.textContent = reason; // Masukkan teks alasan ke dalam modal
            });

        });
    </script>
@endsection