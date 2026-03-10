<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return view('content.admin.reports.index');
    }

    public function chartReport()
    {
        $year = now()->year;

        $payments = Payment::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $reportData = collect(range(1,12))->map(function ($month) use ($payments) {
            return $payments->get($month, 0);
        });

        return response()->json($reportData);
    }
}
