@extends('layouts.member')

@section('title', 'Borrow History')

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <h2 class="fw-bold text-primary fs-5">Borrow History</h2>
            <p class="text-muted fs-6 mb-0">View your borrowing transactions.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card p-3" style="background: linear-gradient(135deg, #f5f7fa, #e0e7f0); border-radius: 15px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th class="fs-6">Book Title</th>
                                    <th class="fs-6 d-none d-md-table-cell">Borrow Date</th>
                                    <th class="fs-6 d-none d-md-table-cell">Return Date</th>
                                    <th class="fs-6">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $transaction)
                                    <tr>
                                        <td class="fs-6">{{ $transaction->book->title }}</td>
                                        <td class="fs-6 d-none d-md-table-cell">{{ $transaction->borrow_date }}</td>
                                        <td class="fs-6 d-none d-md-table-cell">{{ $transaction->return_date ?? '-' }}</td>
                                        <td class="fs-6">{{ ucfirst($transaction->status) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center fs-6">No borrowing history found.</td>
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