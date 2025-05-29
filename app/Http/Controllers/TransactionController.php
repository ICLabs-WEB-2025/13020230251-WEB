<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $transactions = Transaction::with(['user', 'book'])->get();
        return view('admin.transactions.index', compact('transactions'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $members = User::where('role', 'member')->get();
        $books = Book::where('status', 'available')->where('stock', '>', 0)->get();
        return view('admin.transactions.create', compact('members', 'books'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date',
        ]);

        $book = Book::findOrFail($request->book_id);
        if ($book->status !== 'available' || $book->stock <= 0) {
            return back()->withErrors(['book_id' => 'This book is not available for borrowing.']);
        }

        Transaction::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'borrow_date' => $request->borrow_date,
            'status' => 'approved', // Langsung approved karena admin yang membuat
        ]);

        $book->decrement('stock');
        $book->update(['status' => 'borrowed']);

        return redirect()->route('admin.transactions.index')->with('success', 'Transaction created successfully.');
    }

    public function approve(Request $request, Transaction $transaction)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        if ($transaction->status !== 'pending') {
            return redirect()->route('admin.transactions.index')->with('error', 'This transaction cannot be approved.');
        }

        $book = $transaction->book;
        if ($book->stock <= 0 || $book->status !== 'available') {
            return redirect()->route('admin.transactions.index')->with('error', 'Book is not available.');
        }

        $transaction->update(['status' => 'approved']);
        $book->decrement('stock');
        $book->update(['status' => 'borrowed']);

        return redirect()->route('admin.transactions.index')->with('success', 'Transaction approved successfully.');
    }

    public function reject(Request $request, Transaction $transaction)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        if ($transaction->status !== 'pending') {
            return redirect()->route('admin.transactions.index')->with('error', 'This transaction cannot be rejected.');
        }

        $transaction->update(['status' => 'rejected']);
        return redirect()->route('admin.transactions.index')->with('success', 'Transaction rejected successfully.');
    }

    public function returnBook(Transaction $transaction)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        if ($transaction->return_date) {
            return redirect()->route('admin.transactions.index')->with('error', 'Book already returned.');
        }

        $returnDate = now()->toDateString();
        $borrowDate = \Carbon\Carbon::parse($transaction->borrow_date);
        $dueDate = $borrowDate->addDays(14); // Batas peminjaman 14 hari
        $fine = 0;

        if (now()->greaterThan($dueDate)) {
            $daysLate = now()->diffInDays($dueDate);
            $fine = $daysLate * 5000; // Denda Rp 5.000 per hari
        }

        $transaction->update([
            'return_date' => $returnDate,
            'fine' => $fine,
            'status' => 'returned',
        ]);

        $book = $transaction->book;
        $book->increment('stock');
        $book->update(['status' => 'available']);

        return redirect()->route('admin.transactions.index')->with('success', 'Book returned successfully. Fine: Rp ' . number_format($fine, 0, ',', '.'));
    }
}