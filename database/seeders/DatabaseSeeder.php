<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Members
        User::create([
            'name' => 'John Doe',
            'member_id' => 'M001',
            'email' => 'john@example.com',
            'phone' => '081234567890',
            'address' => '123 Main Street',
            'password' => Hash::make('password'),
            'role' => 'member',
        ]);

        User::create([
            'name' => 'Jane Smith',
            'member_id' => 'M002',
            'email' => 'jane@example.com',
            'phone' => '081987654321',
            'address' => '456 Oak Avenue',
            'password' => Hash::make('password'),
            'role' => 'member',
        ]);

        // Books
        Book::create([
            'title' => 'The Great Gatsby',
            'author' => 'F. Scott Fitzgerald',
            'publisher' => 'Scribner',
            'year' => 1925,
            'isbn' => '9780743273565',
            'status' => 'available',
        ]);

        Book::create([
            'title' => '1984',
            'author' => 'George Orwell',
            'publisher' => 'Signet Classics',
            'year' => 1949,
            'isbn' => '9780451524935',
            'status' => 'available',
        ]);

        Book::create([
            'title' => 'To Kill a Mockingbird',
            'author' => 'Harper Lee',
            'publisher' => 'J.B. Lippincott & Co.',
            'year' => 1960,
            'isbn' => '9780446310789',
            'status' => 'available',
        ]);

        // Transactions
        Transaction::create([
            'user_id' => 2, // John Doe
            'book_id' => 1, // The Great Gatsby
            'borrow_date' => now()->subDays(20),
            'return_date' => now()->subDays(3),
            'fine' => 0,
        ]);

        Transaction::create([
            'user_id' => 3, // Jane Smith
            'book_id' => 2, // 1984
            'borrow_date' => now()->subDays(5),
            'return_date' => null,
            'fine' => 0,
        ]);

        Transaction::create([
            'user_id' => 2, // John Doe
            'book_id' => 3, // To Kill a Mockingbird
            'borrow_date' => now()->subDays(30), // Terlambat
            'return_date' => null,
            'fine' => 0,
        ]);
    }
}