@extends('layouts.member')

@section('title', 'Borrow Request')

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <h2 class="fw-bold text-primary fs-5">Borrow Request</h2>
            <p class="text-muted fs-6 mb-0">Submit a new borrow request.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card p-3">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                    @endif
                    <form action="{{ route('member.store-borrow-request') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fs-6">Book</label>
                            <select name="book_id" class="form-select" required>
                                <option value="">Select a book</option>
                                @forelse ($books as $book)
                                    <option value="{{ $book->id }}">{{ $book->title }} (Stock: {{ $book->stock }})</option>
                                @empty
                                    <option disabled>No books available</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-6">Borrow Date</label>
                            <input type="date" name="borrow_date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-6">Return Date</label>
                            <input type="date" name="return_date" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-ios">Submit Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection