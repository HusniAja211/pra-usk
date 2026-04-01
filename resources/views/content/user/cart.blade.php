@extends('app')

@section('content')
    <h3 class="mb-4">My Cart</h3>

    <div class="card shadow-sm border-0">
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
                            <td colspan="5" class="text-center text-muted py-4">
                                Keranjang Anda masih kosong
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

    {{-- Total + Checkout --}}
    @if ($carts->count())
        @php 
            // Ambil ongkir dari method di model User
            $shippingFee = auth()->user()->calculateShippingFee();
            
            // Hitung Grand Total
            $grandTotal = $total + $shippingFee; 
        @endphp

        <div class="card mt-3 shadow-sm border-0">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <h5 class="mb-0 fw-bold">
                        Total Pembayaran : 
                        <span class="text-success">
                            Rp {{ number_format($grandTotal, 0, ',', '.') }}
                        </span>
                    </h5>
                    <small class="text-muted">(Sudah termasuk ongkos kirim)</small>
                </div>

                {{-- Tombol untuk memunculkan Modal --}}
                <button type="button" class="btn btn-success px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#checkoutModal">
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
                            <h5 class="modal-title fw-bold" id="checkoutModalLabel">Instruksi Pembayaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            
                            {{-- Alert Box untuk Rincian --}}
                            <div class="alert alert-info border-0 shadow-sm text-dark">
                                <h6 class="fw-bold text-center mb-3 pb-2 border-bottom border-secondary border-opacity-25">Rincian Tagihan</h6>
                                
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Total Produk</span>
                                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                
                                <div class="d-flex justify-content-between mb-3 pb-3 border-bottom border-secondary border-opacity-25">
                                    <span>Ongkos Kirim</span>
                                    <span>Rp {{ number_format($shippingFee, 0, ',', '.') }}</span>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <span class="fw-bold">Total Transfer</span>
                                    <span class="fw-bold text-success fs-4">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                                </div>

                                <div class="text-center bg-white p-3 rounded shadow-sm">
                                    <p class="mb-1 text-muted small">Silakan transfer tepat sesuai nominal di atas ke:</p>
                                    <h5 class="fw-bold mb-0 text-primary">BCA - 1234567890</h5>
                                    <small class="fw-semibold">a.n. Toko Buku Kita</small>
                                </div>
                            </div>

                            <div class="mb-3 mt-4">
                                <label for="proof" class="form-label fw-bold">Upload Bukti Transfer <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="proof" name="proof" accept="image/*" required>
                                <div class="form-text">Format yang diizinkan: JPG, JPEG, PNG. Maksimal 2MB.</div>
                            </div>
                        </div>

                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary px-4">Kirim & Proses Pesanan</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    @endif

    @if (session('checkout_success'))
        {{-- Modal Ringkasan Pembayaran --}}
        <div class="modal fade" id="successSummaryModal" tabindex="-1" aria-labelledby="successSummaryLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="successSummaryLabel">Checkout Berhasil!</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body text-center">
                        <div class="mb-3">
                            <span style="font-size: 3rem; color: #198754;">✓</span>
                        </div>
                        <h4>Terima Kasih!</h4>
                        <p class="text-muted">Bukti transfer Anda telah kami terima dan sedang dalam antrean verifikasi oleh Admin.</p>

                        <div class="card bg-light mt-4 text-start border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3 border-bottom pb-2">Ringkasan Pesanan Anda:</h6>
                                <p class="mb-1 d-flex justify-content-between">
                                    <span>Total Pembayaran:</span>
                                    <strong class="text-success">Rp {{ number_format(session('total_payment'), 0, ',', '.') }}</strong>
                                </p>

                                <p class="mb-1 mt-3">ID Pesanan (Order ID):</p>
                                <div>
                                    @foreach (session('order_ids') as $id)
                                        <span class="badge bg-secondary mb-1 px-2 py-1">{{ str_pad($id, 4, '0', STR_PAD_LEFT) }}</span>
                                    @endforeach
                                </div>
                                <small class="text-muted mt-2 d-block fst-italic">*Simpan ID Pesanan ini untuk referensi Anda.</small>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-center border-0">
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Tutup</button>
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