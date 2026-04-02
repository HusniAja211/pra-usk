<?php

namespace App\Http\Controllers;

use App\Models\Book; // Pastikan Model Book sudah ada
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // Mengambil 3 buku terbaru beserta relasi kategorinya
        $books = Book::with('category')->latest()->take(3)->get();
        
        return view('index', compact('books'));
    }
}