<?php

namespace App\Http\Controllers;

use App\Models\Cart;

use Illuminate\Http\Request;

class AdminCartController extends Controller
{
    public function index()
    {
        $carts = Cart::all();
        return view('content.admin.cart', compact('carts'));
    }
}
