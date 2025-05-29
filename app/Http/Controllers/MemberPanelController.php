<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberPanelController extends Controller
{
    public function books()
    {
        if (!Auth::check() || Auth::user()->role !== 'member') {
            abort(403, 'Unauthorized');
        }

        $books = Book::where('stock', '>', 0)
                     ->where('status', 'available')
                     ->get();
        return view('member.books', compact('books'));
    }

    public function borrowRequest()
    {
        if (!Auth::check() || Auth::user()->role !== 'member') {
            abort(403, 'Unauthorized');
        }

        $books = Book::where('stock', '>', 0)
                     ->where('status', 'available')
                     ->get();
        return view('member.borrow-request', compact('books'));
    }

    public function storeBorrowRequest(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'member') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:borrow_date',
        ]);

        $book = Book::findOrFail($request->book_id);
        if ($book->status !== 'available' || $book->stock <= 0) {
            return back()->withErrors(['book_id' => 'This book is not available for borrowing.']);
        }

        Transaction::create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'borrow_date' => $request->borrow_date,
            'return_date' => null, // Akan diisi saat approve
            'fine' => 0.00,
            'status' => 'pending', // Set status ke pending
        ]);

        return redirect()->route('member.borrow-history')->with('success', 'Borrow request submitted successfully.');
    }

    public function borrowHistory()
    {
        if (!Auth::check() || Auth::user()->role !== 'member') {
            abort(403, 'Unauthorized');
        }

        $transactions = Transaction::where('user_id', Auth::id())->with('book')->get();
        return view('member.borrow-history', compact('transactions'));
    }

    public function profile()
    {
        if (!Auth::check() || Auth::user()->role !== 'member') {
            abort(403, 'Unauthorized');
        }

        return view('member.profile');
    }

    public function updateProfile(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'member') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->route('member.profile')->with('success', 'Profile updated successfully.');
    }
}