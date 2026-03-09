@extends('app')

@section('content')
    <h3 class="mb-4">Incoming Payments</h3>

    <div class="card">
        <div class="card-body table-responsive">

            <table class="table table-hover">

                <thead class="table-light">
                    <tr>
                        <th>Order ID</th>
                        <th>User</th>
                        <th>Book</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th width="280">Payment</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($orders as $order)
                        <tr>

                            <td>
                                <strong>#{{ $order->id }}</strong>
                            </td>

                            <td>
                                {{ $order->user->name ?? '-' }}
                            </td>

                            <td>
                                {{ $order->book->title ?? '-' }}
                            </td>

                            <td>
                                {{ $order->qty }}
                            </td>

                            <td>
                                Rp {{ number_format($order->price, 0, ',', '.') }}
                            </td>

                            <td class="fw-bold text-success">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </td>

                            <td>

                                @if ($order->status == 'pending')
                                    <span class="badge bg-warning text-dark">
                                        Pending
                                    </span>
                                @elseif($order->status == 'paid')
                                    <span class="badge bg-success">
                                        Paid
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        Cancelled
                                    </span>
                                @endif

                            </td>

                            <td>

                                @if ($order->status == 'pending')
                                    <form action="{{ route('admin.payment.pay', $order->id) }}" method="POST">

                                        @csrf

                                        <div class="d-flex gap-2 mb-1">

                                            <input type="number" name="cash"
                                                class="form-control form-control-sm cash-input" placeholder="Uang Customer"
                                                data-total="{{ $order->total }}" required>

                                            <button class="btn btn-primary btn-sm">
                                                Bayar
                                            </button>

                                        </div>

                                        <input type="text" class="form-control form-control-sm change-output"
                                            placeholder="Kembalian" readonly>

                                    </form>
                                @else
                                    <span class="text-muted">
                                        Selesai
                                    </span>
                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                No incoming payments
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>
    </div>


    {{-- SCRIPT AUTO KEMBALIAN --}}
    <script>
        document.querySelectorAll('.cash-input').forEach(input => {

            input.addEventListener('input', function() {

                let total = parseInt(this.dataset.total)
                let cash = parseInt(this.value)

                let form = this.closest('form')
                let changeField = form.querySelector('.change-output')

                if (!cash || cash < total) {
                    changeField.value = "Uang kurang"
                    return
                }

                let change = cash - total

                changeField.value = "Rp " + change.toLocaleString('id-ID')

            })

        })
    </script>
@endsection
