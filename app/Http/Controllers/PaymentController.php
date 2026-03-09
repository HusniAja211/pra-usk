<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Book;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display incoming payments
     */
    public function index()
    {
        $orders = Order::with(['user','book'])
            ->where('status','pending')
            ->latest()
            ->get();

        return view('content.admin.payment.index', compact('orders'));
    }

    /**
     * Approve payment
     */
    public function approve($id)
    {
        $order = Order::findOrFail($id);

        $order->update([
            'status' => 'paid'
        ]);

        // reduce book stock
        $book = Book::find($order->book_id);

        if($book){
            $book->stock -= $order->qty;
            $book->save();
        }

        return back()->with('success','Payment approved');
    }

    public function invoice($id)
    {
        $payment = Payment::with(['order.user','order.book'])
            ->findOrFail($id);

        return view('content.admin.payment.invoice', compact('payment'));
    }

    public function pay(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'cash' => 'required|numeric'
        ]);

        $total = $order->total;
        $cash = $request->cash;

        if ($cash < $total) {
            return back()->with('error','Uang tidak cukup');
        }

        $change = $cash - $total;

        // simpan ke variabel
        $payment = Payment::create([
            'order_id' => $order->id,
            'total_price' => $total,
            'cash' => $cash,
            'change' => $change
        ]);

        $order->update([
            'status' => 'paid'
        ]);

        // kurangi stok buku
        $book = Book::find($order->book_id);

        if ($book) {
            $book->stock -= $order->qty;
            $book->save();
        }

        return redirect()->route('admin.payment.invoice', $payment->id);
    }
}