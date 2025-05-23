<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RecycleBinController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard')->middleware('auth');

Route::get('/member/books', function () {
    return view('member.books');
})->name('member.books')->middleware('auth');

// Rute untuk Manajemen Buku (Admin)
Route::prefix('admin/books')->name('admin.books.')->middleware('auth')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('index');
    Route::get('/create', [BookController::class, 'create'])->name('create');
    Route::post('/', [BookController::class, 'store'])->name('store');
    Route::get('/{book}/edit', [BookController::class, 'edit'])->name('edit');
    Route::put('/{book}', [BookController::class, 'update'])->name('update');  
    Route::delete('/{book}', [BookController::class, 'destroy'])->name('destroy'); 
    Route::get('/restore/{id}', [BookController::class, 'restore'])->name('restore');
    Route::delete('/force-delete/{id}', [BookController::class, 'forceDelete'])->name('forceDelete');
});

// Rute untuk Manajemen Anggota (Admin)
Route::prefix('admin/members')->name('admin.members.')->middleware('auth')->group(function () {
    Route::get('/', [MemberController::class, 'index'])->name('index');
    Route::get('/create', [MemberController::class, 'create'])->name('create');
    Route::post('/', [MemberController::class, 'store'])->name('store');
    Route::get('/{member}/edit', [MemberController::class, 'edit'])->name('edit');
    Route::put('/{member}', [MemberController::class, 'update'])->name('update'); 
    Route::delete('/{member}', [MemberController::class, 'destroy'])->name('destroy');
    Route::get('/restore/{id}', [MemberController::class, 'restore'])->name('restore');
    Route::delete('/force-delete/{id}', [MemberController::class, 'forceDelete'])->name('forceDelete');
});

// Rute untuk Transaksi Peminjaman (Admin)
Route::prefix('admin/transactions')->name('admin.transactions.')->middleware('auth')->group(function () {
    Route::get('/', [TransactionController::class, 'index'])->name('index');
    Route::get('/create', [TransactionController::class, 'create'])->name('create');
    Route::post('/', [TransactionController::class, 'store'])->name('store');
    Route::post('/{transaction}/return', [TransactionController::class, 'returnBook'])->name('return');
});

// Rute untuk Recycle Bin (Admin)
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/recycle-bin', [RecycleBinController::class, 'index'])->name('admin.recycle-bin.index');
    Route::post('/recycle-bin/restore-book/{id}', [RecycleBinController::class, 'restoreBook'])->name('admin.recycle-bin.restore-book');
    Route::delete('/recycle-bin/force-delete-book/{id}', [RecycleBinController::class, 'forceDeleteBook'])->name('admin.recycle-bin.force-delete-book');
    Route::post('/recycle-bin/restore-member/{id}', [RecycleBinController::class, 'restoreMember'])->name('admin.recycle-bin.restore-member');
    Route::delete('/recycle-bin/force-delete-member/{id}', [RecycleBinController::class, 'forceDeleteMember'])->name('admin.recycle-bin.force-delete-member');
});

// Rute untuk Profil Admin
Route::prefix('admin/profile')->name('admin.profile.')->middleware('auth')->group(function () {
    Route::get('/', [ProfileController::class, 'show'])->name('show');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::put('/', [ProfileController::class, 'update'])->name('update');
});
