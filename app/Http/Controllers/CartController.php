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

        $user = Auth::user();
        $carts = Cart::with('book')->where('user_id', $user->id)->get();

        if ($carts->isEmpty()) {
            return back()->with('error', 'Keranjang kosong!');
        }

        $proofPath = null;
        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('proofs', 'public');
        }

        $orderIds = []; // Array untuk menampung ID pesanan
        $totalPayment = 0; // Menampung total tagihan

        foreach ($carts as $cart) {
            $subtotal = $cart->qty * $cart->book->price;
            $totalPayment += $subtotal;

            // Buat data order
            $order = Order::create([
                'user_id' => $user->id,
                'book_id' => $cart->book_id,
                'qty'     => $cart->qty,
                'price'   => $cart->book->price,
                'total'   => $subtotal,
                'status'  => 'pending' 
            ]);

            // Buat data pembayaran
            Payment::create([
                'order_id'       => $order->id,
                'total_price'    => $subtotal,
                'cash'           => 0,
                'change'         => 0,
                'proof'          => $proofPath,
                'payment_method' => 'transfer',
                'status'         => 'pending'
            ]);

            // Simpan ID pesanan ke array dan hapus item dari keranjang
            $orderIds[] = $order->id;
            $cart->delete();
        }

        // Redirect KEMBALI ke halaman cart, tapi bawa data sukses
        // Pastikan nama route-nya sesuai dengan route halaman cart kamu
        return redirect()->route('cart.index')->with([
            'checkout_success' => true,
            'order_ids'        => $orderIds,
            'total_payment'    => $totalPayment
        ]);
    }
}