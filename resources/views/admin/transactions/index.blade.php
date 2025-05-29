@extends('layouts.admin')

@section('title', 'Transaction Management')

@section('content')
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold text-primary fs-5">Transaction Management</h2>
                <p class="text-muted fs-6 mb-0">Manage book borrowing requests.</p>
            </div>
            <a href="{{ route('admin.transactions.create') }}" class="btn btn-ios"><i class="fas fa-plus me-2"></i>Create New Transaction</a>
        </div>
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

    <div class="row mb-3">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Member</th>
                                    <th>Book</th>
                                    <th>Borrow Date</th>
                                    <th>Return Date</th>
                                    <th>Status</th>
                                    <th>Fine (Rp)</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->user->name ?? 'Unknown' }}</td>
                                        <td>{{ $transaction->book->title ?? 'Unknown' }}</td>
                                        <td>{{ $transaction->borrow_date->format('d M Y') }}</td>
                                        <td>{{ $transaction->return_date ? $transaction->return_date->format('d M Y') : '-' }}</td>
                                        <td>{{ ucfirst($transaction->status) }}</td>
                                        <td>{{ number_format($transaction->fine, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($transaction->status === 'pending')
                                                <form action="{{ route('admin.transactions.approve', $transaction) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure to approve this request?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-check"></i></button>
                                                </form>
                                                <form action="{{ route('admin.transactions.reject', $transaction) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure to reject this request?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button>
                                                </form>
                                            @elseif ($transaction->status === 'approved' && !$transaction->return_date)
                                                <form action="{{ route('admin.transactions.return', $transaction) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure to return this book?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-warning"><i class="fas fa-undo"></i></button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No transactions found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection