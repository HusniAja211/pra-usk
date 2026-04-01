<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersReportExport;
use App\Models\Payment;

class ReportController extends Controller
{
    public function index()
    {
        $products = DB::table('orders')
            ->join('books', 'books.id', '=', 'orders.book_id')
            ->select(
                'books.title',
                DB::raw('SUM(orders.qty) as total_sold')
            )
            ->where('orders.status', 'paid')
            ->groupBy('books.id', 'books.title')
            ->orderByDesc('total_sold')
            ->get();

        return view('content.admin.reports.index', compact('products'));
    }

    public function exportOrders()
    {
        return Excel::download(new OrdersReportExport, 'orders_report.xlsx');
    }

    // Chart untuk grafik JS
    public function chartReport()
    {
        $year = now()->year;

        $payments = Payment::selectRaw('
                MONTH(created_at) as month,
                COUNT(*) as total_transactions,
                SUM(total_price) as total_income
            ')
            ->whereYear('created_at', $year)
            ->where('status', 'verified')
            ->groupBy('month')
            ->get()
            ->keyBy('month');

        $reportData = collect(range(1, 12))->map(function ($month) use ($payments) {
            return [
                'month' => $month,
                'total_transactions' => $payments[$month]->total_transactions ?? 0,
                'total_income' => $payments[$month]->total_income ?? 0,
            ];
        });

        return response()->json($reportData);
    }
}
