<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Book;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Direct order (Buy Now)
     */
    public function buyNow($book_id)
    {
        $book = Book::findOrFail($book_id);
        
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Hitung ongkos kirim
        $shippingFee = $user->calculateShippingFee();
        
        $subtotal = $book->price * 1; // qty = 1
        $grandTotal = $subtotal + $shippingFee;

        // 2. Buat Order
        $order = Order::create([
            'user_id' => $user->id,
            'book_id' => $book_id,
            'price' => $book->price,
            'qty' => 1,
            'shipping_fee' => $shippingFee, // Masukkan ongkir
            'total' => $grandTotal, // Total = harga buku + ongkir
            'status' => 'pending'
        ]);

        // 3. (Opsional) Jika sistem kamu mewajibkan ada data di tabel `payments` untuk setiap order
        // Pastikan untuk membuat data Payment default dengan status pending.
        Payment::create([
            'order_id'       => $order->id,
            'total_price'    => $grandTotal,
            'cash'           => 0,
            'change'         => 0,
            'proof'          => null, // Belum ada bukti transfer karena baru klik buy now
            'payment_method' => 'transfer',
            'status'         => 'pending'
        ]);

        return redirect()
            ->route('user.dashboard') // Atau arahkan ke halaman detail pembayaran jika ada
            ->with('order_success', [
                'id' => $order->id,
                'title' => $book->title,
                'qty' => $order->qty,
                'shipping_fee' => $order->shipping_fee,
                'total' => $order->total,
                'status' => $order->status
            ]);
    }
}