<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();
        $totalMembers = User::where('role', 'member')->count();
        $totalTransactions = Transaction::count();

        $sixMonthsAgo = now()->subMonths(6);
        $borrowData = Transaction::select(
            DB::raw('DATE_FORMAT(borrow_date, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
            ->where('borrow_date', '>=', $sixMonthsAgo)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $returnData = Transaction::select(
            DB::raw('DATE_FORMAT(return_date, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereNotNull('return_date')
            ->where('return_date', '>=', $sixMonthsAgo)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $labels = [];
        $borrowCounts = [];
        $returnCounts = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $labels[] = now()->subMonths($i)->format('M Y');
            $borrowCounts[] = $borrowData[$month] ?? 0;
            $returnCounts[] = $returnData[$month] ?? 0;
        }

        $popularBooks = Transaction::select('book_id', DB::raw('COUNT(*) as borrow_count'))
            ->groupBy('book_id')
            ->orderBy('borrow_count', 'desc')
            ->take(5)
            ->with('book')
            ->get();

        return view('admin.dashboard', compact(
            'totalBooks',
            'totalMembers',
            'totalTransactions',
            'labels',
            'borrowCounts',
            'returnCounts',
            'popularBooks'
        ));
    }
}