@extends('layouts.admin')

@section('title', 'Transaction Management')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-primary">Transaction Management</h1>
        <a href="{{ route('admin.transactions.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Create New Transaction</a>
    </div>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Book</th>
                            <th>Borrow Date</th>
                            <th>Return Date</th>
                            <th>Fine (Rp)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->user->name ?? 'Unknown' }}</td>
                                <td>{{ $transaction->book->title ?? 'Unknown' }}</td>
                                <td>{{ $transaction->borrow_date->format('d M Y') }}</td>
                                <td>{{ $transaction->return_date ? $transaction->return_date->format('d M Y') : '-' }}</td>
                                <td>{{ number_format($transaction->fine, 0, ',', '.') }}</td>
                                <td>
                                    @if (!$transaction->return_date)
                                        <form action="{{ route('admin.transactions.return', $transaction) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure to return this book?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection