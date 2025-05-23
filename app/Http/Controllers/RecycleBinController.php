<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecycleBinController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $deletedBooks = Book::onlyTrashed()->get();
        $deletedMembers = User::onlyTrashed()->where('role', 'member')->get();

        return view('admin.recycle-bin.index', compact('deletedBooks', 'deletedMembers'));
    }

    public function restoreBook($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $book = Book::onlyTrashed()->findOrFail($id);
        $book->restore();

        return redirect()->route('admin.recycle-bin.index')->with('success', 'Book restored successfully.');
    }

    public function restoreMember($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $member = User::onlyTrashed()->findOrFail($id);
        if ($member->role !== 'member') {
            abort(403, 'Cannot restore non-member user.');
        }
        $member->restore();

        return redirect()->route('admin.recycle-bin.index')->with('success', 'Member restored successfully.');
    }

    public function forceDeleteBook($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $book = Book::onlyTrashed()->findOrFail($id);
        $book->forceDelete();

        return redirect()->route('admin.recycle-bin.index')->with('success', 'Book permanently deleted successfully.');
    }

    public function forceDeleteMember($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $member = User::onlyTrashed()->findOrFail($id);
        if ($member->role !== 'member') {
            abort(403, 'Cannot permanently delete non-member user.');
        }
        $member->forceDelete();

        return redirect()->route('admin.recycle-bin.index')->with('success', 'Member permanently deleted successfully.');
    }
}