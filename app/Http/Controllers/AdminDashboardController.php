<?php

namespace App\Http\Controllers;

use App\Models\Order;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $completedOrders = Order::where('status', 'paid')->count();
        return view('content.admin.dashboard.index', compact('totalOrders', 'completedOrders'));
    }
}
