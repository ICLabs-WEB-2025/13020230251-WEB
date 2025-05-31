<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $query = Book::withTrashed();

        // Pencarian berdasarkan title, author, atau isbn
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('author', 'like', '%' . $search . '%')
                  ->orWhere('isbn', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Pagination (10 buku per halaman)
        $books = $query->paginate(10);

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
            'year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'isbn' => 'nullable|string|max:13|unique:books,isbn',
            'status' => 'required|in:available,borrowed',
            'stock' => 'required|integer|min:0',
        ]);

        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'year' => $request->year,
            'isbn' => $request->isbn,
            'status' => $request->status,
            'stock' => $request->stock,
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Book added successfully.');
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
            'year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'isbn' => 'nullable|string|max:13|unique:books,isbn,' . $book->id,
            'status' => 'required|in:available,borrowed',
            'stock' => 'required|integer|min:0',
        ]);

        $book->update([
            'title' => $request->title,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'year' => $request->year,
            'isbn' => $request->isbn,
            'status' => $request->status,
            'stock' => $request->stock,
        ]);

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