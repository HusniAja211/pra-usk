<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('category')->latest()->paginate(10);
        return view('content.admin.book.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('content.admin.book.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:books,title|max:100',
            'category_id' => 'required|exists:categories,id',
            'author' => 'required|max:80',
            'publisher' => 'required|max:255',
            'modal' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        // Hitung Margin dan Profit secara otomatis
        $data['margin'] = $request->price - $request->modal;
        $data['profit'] = $data['margin'] * $request->stock;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('books', 'public');
        }

        Book::create($data);

        return redirect()->route('admin.book.index')
            ->with('success', 'Book created successfully.');
    }

    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        $categories = Category::all();

        return view('content.admin.book.edit', compact('book', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'title' => [
                'max:100',
                Rule::unique('books', 'title')->ignore($book->id)
            ],
            'category_id' => 'exists:categories,id',
            'author' => 'max:80',
            'publisher' => 'max:255',
            'modal' => 'numeric|min:0',
            'price' => 'numeric|min:0',
            'stock' => 'integer|min:0',
            'description' => '',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        // Rekalkulasi Margin dan Profit saat update
        $data['margin'] = $request->price - $request->modal;
        $data['profit'] = $data['margin'] * $request->stock;

        if ($request->hasFile('image')) {
            if ($book->image && Storage::disk('public')->exists($book->image)) {
                Storage::disk('public')->delete($book->image);
            }
            $data['image'] = $request->file('image')->store('books', 'public');
        }

        $book->update($data);

        return redirect()->route('admin.book.index')
            ->with('success', 'Book updated successfully.');
    }

    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);

        if ($book->image && Storage::disk('public')->exists($book->image)) {
            Storage::disk('public')->delete($book->image);
        }

        $book->delete();

        return redirect()->route('admin.book.index')
            ->with('success', 'Book deleted successfully.');
    }
}