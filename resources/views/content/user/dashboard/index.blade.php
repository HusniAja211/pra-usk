@extends('app')

@section('content')
    <h2 class="mb-4">Dashboard Member</h2>

    <div class="row g-4">

        @forelse($books as $book)
            <div class="col-md-3">

                <div class="card h-100 shadow-sm">

                    {{-- Cover --}}
                    <img src="{{ $book->image ? asset('storage/' . $book->image) : 'https://via.placeholder.com/300x200' }}"
                        class="card-img-top" style="height:200px; object-fit:cover;">

                    <div class="card-body d-flex flex-column">

                        {{-- Title --}}
                        <h6 class="fw-bold">
                            {{ $book->title }}
                        </h6>

                        {{-- Author --}}
                        <small class="text-muted">
                            {{ $book->author }}
                        </small>

                        {{-- Category --}}
                        <span class="badge bg-secondary mt-2 mb-2">
                            {{ $book->category->name ?? '-' }}
                        </span>

                        {{-- Price --}}
                        <h5 class="text-success">
                            Rp {{ number_format($book->price, 0, ',', '.') }}
                        </h5>

                        {{-- Stock --}}
                        <small class="text-muted mb-3">
                            Stock: {{ $book->stock }}
                        </small>

                        {{-- Buttons --}}
                        <div class="mt-auto d-grid gap-2">

                            {{-- Add To Cart --}}
                            <form action="{{ route('cart.add', $book->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <input type="hidden" name="qty" value="1">

                                <button class="btn btn-outline-primary btn-sm w-100">
                                    Add To Cart
                                </button>
                            </form>

                            {{-- Order Now --}}
                            <form action="{{ route('buy.now', $book->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <input type="hidden" name="qty" value="1">

                                <button class="btn btn-success btn-sm w-100">
                                    Order Now
                                </button>
                            </form>

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12 text-center text-muted">
                No books available
            </div>
        @endforelse

    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $books->links() }}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('order_success'))
        <script>
            const order = @json(session('order_success'));

            Swal.fire({
                icon: 'success',
                title: 'Order Created',
                width: 420,
                html: `
        <div style="text-align:left;font-size:14px">

            <p><b>Order ID</b><br>
            <span style="font-size:18px;color:#198754">#${order.id}</span></p>

            <p><b>Book</b><br>
            ${order.title}</p>

            <p><b>Quantity</b><br>
            ${order.qty}</p>

            <p><b>Total</b><br>
            Rp ${Number(order.total).toLocaleString()}</p>

            <p><b>Status</b><br>
            <span class="badge bg-warning text-dark">
                ${order.status}
            </span></p>

        </div>
    `,
                confirmButtonText: 'OK'
            });
        </script>
    @endif
@endsection
