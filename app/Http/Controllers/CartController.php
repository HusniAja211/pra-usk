<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Book;
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
    public function checkout()
    {
        $carts = Cart::where('user_id', Auth::id())->get();

        foreach ($carts as $cart) {

            $book = Book::find($cart->book_id);

            Order::create([
                'user_id' => Auth::id(),
                'book_id' => $cart->book_id,
                'qty' => $cart->qty,
                'price' => $book->price,
                'total' => $cart->qty * $book->price,
                'status' => 'pending'
            ]);

            $cart->delete();
        }

        return redirect()->route('user.dashboard')
            ->with('success', 'Checkout success');
    }

    public function remove($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        return back()->with('success','Item removed from cart');
    }
}