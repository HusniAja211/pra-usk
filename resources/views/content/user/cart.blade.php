@extends('app')

@section('content')
    <h3 class="mb-4">My Cart</h3>

    <div class="card">
        <div class="card-body table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>Book</th>
                        <th>Price</th>
                        <th width="120">Qty</th>
                        <th>Subtotal</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @php $total = 0; @endphp

                    @forelse($carts as $cart)
                        @php
                            $subtotal = $cart->book->price * $cart->qty;
                            $total += $subtotal;
                        @endphp

                        <tr>

                            {{-- Book --}}
                            <td class="d-flex align-items-center gap-3">

                                <img src="{{ $cart->book->image ? asset('storage/' . $cart->book->image) : 'https://via.placeholder.com/80' }}"
                                    width="60" style="object-fit:cover;border-radius:6px">

                                <div>
                                    <div class="fw-bold">
                                        {{ $cart->book->title }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $cart->book->author }}
                                    </small>
                                </div>

                            </td>

                            {{-- Price --}}
                            <td>
                                Rp {{ number_format($cart->book->price, 0, ',', '.') }}
                            </td>

                            {{-- Qty --}}
                            <td>
                                {{ $cart->qty }}
                            </td>

                            {{-- Subtotal --}}
                            <td class="fw-bold text-success">
                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                            </td>

                            {{-- Action --}}
                            <td>

                                <form action="{{ route('cart.remove', $cart->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger">
                                        Remove
                                    </button>
                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Cart is empty
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

    {{-- Total + Checkout --}}
    @if ($carts->count())
        <div class="card mt-3">
            <div class="card-body d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    Total :
                    <span class="text-success">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </span>
                </h5>

                {{-- Tombol untuk memunculkan Modal --}}
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#checkoutModal">
                    Checkout & Bayar
                </button>

            </div>
        </div>

        {{-- Modal Pembayaran Transfer --}}
        <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    {{-- Form Checkout & Upload Bukti --}}
                    <form action="{{ route('cart.checkout') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title" id="checkoutModalLabel">Instruksi Pembayaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="alert alert-info">
                                <p class="mb-1">Silakan lakukan transfer sebesar:</p>
                                <h4 class="fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</h4>
                                <hr>
                                <p class="mb-1">Ke rekening berikut:</p>
                                <h5 class="fw-bold mb-0">BCA - 1234567890</h5>
                                <small>a.n. Toko Buku Kita</small>
                            </div>

                            <div class="mb-3">
                                <label for="proof" class="form-label fw-bold">Upload Bukti Transfer <span
                                        class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="proof" name="proof" accept="image/*"
                                    required>
                                <div class="form-text">Format yang diizinkan: JPG, JPEG, PNG. Maksimal 2MB.</div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Kirim & Proses Pesanan</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    @endif

    @if (session('checkout_success'))
        {{-- Modal Ringkasan Pembayaran --}}
        <div class="modal fade" id="successSummaryModal" tabindex="-1" aria-labelledby="successSummaryLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="successSummaryLabel">Checkout Berhasil!</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body text-center">
                        <div class="mb-3">
                            <span style="font-size: 3rem; color: #198754;">✓</span>
                        </div>
                        <h4>Terima Kasih!</h4>
                        <p class="text-muted">Bukti transfer Anda telah kami terima dan sedang dalam antrean verifikasi oleh
                            Admin.</p>

                        <div class="card bg-light mt-4 text-start">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Ringkasan Pesanan Anda:</h6>
                                <p class="mb-1">Total Pembayaran: <strong class="text-success">Rp
                                        {{ number_format(session('total_payment'), 0, ',', '.') }}</strong></p>

                                <p class="mb-1 mt-3">ID Pesanan (Order ID):</p>
                                <div>
                                    @foreach (session('order_ids') as $id)
                                        <span
                                            class="badge bg-secondary mb-1">{{ str_pad($id, 4, '0', STR_PAD_LEFT) }}</span>
                                    @endforeach
                                </div>
                                <small class="text-muted mt-2 d-block">*Simpan ID Pesanan ini untuk referensi Anda.</small>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>

                </div>
            </div>
        </div>

        {{-- Script untuk memicu modal muncul secara otomatis saat halaman selesai dimuat --}}
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var successModal = new bootstrap.Modal(document.getElementById('successSummaryModal'));
                successModal.show();
            });
        </script>
    @endif
@endsection
