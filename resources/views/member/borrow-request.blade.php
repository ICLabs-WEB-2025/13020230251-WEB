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
        <div class="col-12 col-md-6">
            <div class="card p-3" style="background: linear-gradient(135deg, #f5f7fa, #e0e7f0); border-radius: 15px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-2 mb-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('member.store-borrow-request') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fs-6">Book</label>
                            <select name="book_id" class="form-select rounded-2" required>
                                <option value="">Select a book</option>
                                @forelse ($books as $book)
                                    <option value="{{ $book->id }}">{{ $book->title }} (Stock: {{ $book->stock }})</option>
                                @empty
                                    <option disabled>No books available</option>
                                @endforelse
                            </select>
                            @error('book_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-6">Borrow Date</label>
                            <input type="date" name="borrow_date" class="form-control rounded-2" required value="{{ old('borrow_date') }}">
                            @error('borrow_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-6">Return Date</label>
                            <input type="date" name="return_date" class="form-control rounded-2" required value="{{ old('return_date') }}">
                            @error('return_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-ios rounded-2">Submit Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection