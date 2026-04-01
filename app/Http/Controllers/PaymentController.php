<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Book;
use App\Models\Payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; 

class PaymentController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'book', 'payment'])
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
            ->latest()
            ->get();

        return view('content.admin.payment.index', compact('orders'));
    }

    public function approve($id)
    {
        $order = Order::findOrFail($id);
        $payment = Payment::where('order_id', $order->id)->first();

        // Update status order
        $order->update(['status' => 'paid']);

        // Update status payment menjadi verified jika ada
        if ($payment) {
            $payment->update(['status' => 'verified']);
        }

        // Kurangi stok buku
        $book = Book::find($order->book_id);
        if ($book) {
            $book->stock -= $order->qty;
            $book->save();
        }

        return back()->with('success', 'Pembayaran berhasil disetujui');
    }

    // Fungsi baru untuk menolak pembayaran
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reject_reason' => 'required|string|max:255'
        ]);

        $order = Order::findOrFail($id);
        $payment = Payment::where('order_id', $order->id)->first();

        // Ubah status order menjadi cancelled
        $order->update(['status' => 'cancelled']);

        // Ubah status payment menjadi rejected dan simpan alasannya
        if ($payment) {
            $payment->update([
                'status' => 'rejected',
                'reject_reason' => $request->reject_reason // Uncomment ini jika kolom sudah dibuat di DB
            ]);
        }

        return back()->with('success', 'Pembayaran berhasil ditolak');
    }

    public function invoice($id)
    {
        $payment = Payment::with(['order.user', 'order.book'])->findOrFail($id);

        // 2. Load view ke dalam DomPDF
        $pdf = Pdf::loadView('content.admin.payment.invoice', compact('payment'));
        
        // Opsional: Atur ukuran kertas ke bentuk struk (lebar 300pt)
        $customPaper = array(0, 0, 300, 450);
        $pdf->setPaper($customPaper);

        // 3. Return stream agar terbuka di browser sebagai PDF
        return $pdf->stream('Invoice-INV-'. str_pad($payment->id, 4, '0', STR_PAD_LEFT) .'.pdf');
    }
}