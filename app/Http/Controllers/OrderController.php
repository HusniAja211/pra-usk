<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Direct order (Buy Now)
     */
    public function buyNow($book_id)
    {
        $book = Book::findOrFail($book_id);

        $order = Order::create([
            'user_id' => Auth::id(),
            'book_id' => $book_id,
            'price' => $book->price,
            'qty' => 1,
            'total' => $book->price,
            'status' => 'pending'
        ]);

        return redirect()
            ->route('user.dashboard')
            ->with('order_success', [
                'id' => $order->id,
                'title' => $book->title,
                'qty' => $order->qty,
                'total' => $order->total,
                'status' => $order->status
            ]);
    }
}