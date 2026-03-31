@extends('app')

@section('content')

<h3 class="mb-4">My Cart</h3>

<div class="card">
    <div class="card-body table-responsive">

        <table class="table table-hover align-middle">

            <thead class="table-light">
                <tr>
                    <th>User</th>
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
                    <td class="d-flex align-items-center gap-3">{{ $cart->user->name }}</td>
                    {{-- Book --}}
                    <td class="d-flex align-items-center gap-3">

                        <img 
                            src="{{ $cart->book->image ? asset('storage/'.$cart->book->image) : 'https://via.placeholder.com/80' }}"
                            width="60"
                            style="object-fit:cover;border-radius:6px"
                        >

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
                        Rp {{ number_format($cart->book->price,0,',','.') }}
                    </td>

                    {{-- Qty --}}
                    <td>
                        {{ $cart->qty }}
                    </td>

                    {{-- Subtotal --}}
                    <td class="fw-bold text-success">
                        Rp {{ number_format($subtotal,0,',','.') }}
                    </td>

                    {{-- Action --}}
                    <td>

                        <form action="{{ route('cart.remove',$cart->id) }}" method="POST">
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
@if($carts->count())

<div class="card mt-3">
    <div class="card-body d-flex justify-content-between align-items-center">

        <h5 class="mb-0">
            Total :
            <span class="text-success">
                Rp {{ number_format($total,0,',','.') }}
            </span>
        </h5>
    </div>
</div>

@endif

@endsection