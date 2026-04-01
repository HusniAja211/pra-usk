<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; 


class PurchaseHistoryController extends Controller
{
    /**
     * Menampilkan riwayat pembelian user
     */
    public function index()
    {
        $orders = Order::with(['book', 'payment'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('content.user.purchase-history.index', compact('orders'));
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