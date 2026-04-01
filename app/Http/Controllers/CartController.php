<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Book;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Add book to cart
     */
    public function add($book_id)
    {
        $book = Book::findOrFail($book_id);

        $cart = Cart::where('user_id', Auth::id())
            ->where('book_id', $book_id)
            ->first();

        if ($cart) {
            $cart->qty += 1;
            $cart->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'book_id' => $book_id,
                'qty' => 1
            ]);
        }

        return back()->with('success', 'Book added to cart');
    }

    /**
     * View cart
     */
    public function index()
    {
        $carts = Cart::with('book')
            ->where('user_id', Auth::id())
            ->get();

        return view('content.user.cart', compact('carts'));
    }

    /**
     * Checkout cart → order
     */
    public function checkout(Request $request)
    {
        // Validasi input file
        $request->validate([
            'proof' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $carts = Cart::with('book')->where('user_id', $user->id)->get();

        if ($carts->isEmpty()) {
            return back()->with('error', 'Keranjang kosong!');
        }

        // 1. Ambil Biaya Shipping (Logic 20k flat atau 5k/km)
        $shippingFee = $user->calculateShippingFee();

        $proofPath = null;
        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('proofs', 'public');
        }

        $orderIds = [];
        $totalProductPrice = 0;

        foreach ($carts as $index => $cart) {
            $subtotal = $cart->qty * $cart->book->price;
            $totalProductPrice += $subtotal;

            // 2. Buat data order
            // Note: Kita simpan shipping_fee di order (bisa dipecah atau di order pertama saja)
            // Saran: Simpan shipping_fee di kolom tersendiri di tabel orders
            $order = Order::create([
                'user_id'      => $user->id,
                'book_id'      => $cart->book_id,
                'qty'          => $cart->qty,
                'price'        => $cart->book->price,
                'shipping_fee' => ($index === 0) ? $shippingFee : 0, // Ongkir ditaruh di item pertama saja
                'total'        => $subtotal + (($index === 0) ? $shippingFee : 0),
                'status'       => 'pending' 
            ]);

            // 3. Buat data pembayaran
            Payment::create([
                'order_id'       => $order->id,
                'total_price'    => $order->total, // Total sudah termasuk ongkir jika itu item pertama
                'cash'           => 0,
                'change'         => 0,
                'proof'          => $proofPath,
                'payment_method' => 'transfer',
                'status'         => 'pending'
            ]);

            $orderIds[] = $order->id;
            $cart->delete();
        }

        $grandTotal = $totalProductPrice + $shippingFee;

        return redirect()->route('cart.index')->with([
            'checkout_success' => true,
            'order_ids'        => $orderIds,
            'shipping_fee'     => $shippingFee,
            'total_payment'    => $grandTotal
        ]);
    }
}