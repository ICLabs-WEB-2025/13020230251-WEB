<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $books = Book::withTrashed()->get(); // Menampilkan semua buku termasuk yang di-soft delete
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return view('admin.books.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:1000|max:9999',
            'isbn' => 'nullable|string|unique:books,isbn',
            'status' => 'required|in:available,borrowed',
        ]);

        Book::create($request->all());
        return redirect()->route('admin.books.index')->with('success', 'Book created successfully.');
    }

    public function edit(Book $book)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return view('admin.books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:1000|max:9999',
            'isbn' => 'nullable|string|unique:books,isbn,' . $book->id,
            'status' => 'required|in:available,borrowed',
        ]);

        $book->update($request->all());
        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Book soft deleted successfully.');
    }

    public function restore($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $book = Book::withTrashed()->findOrFail($id);
        $book->restore();
        return redirect()->route('admin.books.index')->with('success', 'Book restored successfully.');
    }

    public function forceDelete($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $book = Book::withTrashed()->findOrFail($id);
        $book->forceDelete();
        return redirect()->route('admin.books.index')->with('success', 'Book permanently deleted successfully.');
    }
}