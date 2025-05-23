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
        $books = Book::where('status', 'available')->get();
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
        if ($book->status !== 'available') {
            return back()->withErrors(['book_id' => 'This book is not available for borrowing.']);
        }

        Transaction::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'borrow_date' => $request->borrow_date,
        ]);

        $book->update(['status' => 'borrowed']);

        return redirect()->route('admin.transactions.index')->with('success', 'Transaction created successfully.');
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
        ]);

        $transaction->book->update(['status' => 'available']);

        return redirect()->route('admin.transactions.index')->with('success', 'Book returned successfully. Fine: Rp ' . number_format($fine, 0, ',', '.'));
    }
}