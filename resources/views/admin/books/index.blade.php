@extends('layouts.admin')

@section('title', 'Book Management')

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <h2 class="fw-bold text-primary fs-5">Book Management</h2>
            <p class="text-muted fs-6 mb-0">Manage all books.</p>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Search and Filter -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <form method="GET" action="{{ route('admin.books.index') }}" class="row g-2">
                                <div class="col-auto">
                                    <input type="text" name="search" class="form-control" placeholder="Search title, author, or ISBN" value="{{ request('search') }}">
                                </div>
                                <div class="col-auto">
                                    <select name="status" class="form-select">
                                        <option value="">All Status</option>
                                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                                        <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-ios">Filter</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <a href="{{ route('admin.books.create') }}" class="btn btn-ios">Add New Book</a>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Publisher</th>
                                    <th>Year</th>
                                    <th>ISBN</th>
                                    <th>Status</th>
                                    <th>Stock</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($books as $book)
                                    <tr>
                                        <td>{{ $book->title }}</td>
                                        <td>{{ $book->author }}</td>
                                        <td>{{ $book->publisher ?? '-' }}</td>
                                        <td>{{ $book->year ?? '-' }}</td>
                                        <td>{{ $book->isbn ?? '-' }}</td>
                                        <td>
                                            <span class="badge {{ $book->status == 'available' ? 'bg-success' : 'bg-warning' }}">
                                                {{ ucfirst($book->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $book->stock }}</td>
                                        <td>
                                            @if ($book->trashed())
                                                <form action="{{ route('admin.books.restore', $book->id) }}" method="GET" style="display:inline;">
                                                    <button type="submit" class="btn btn-sm btn-success">Restore</button>
                                                </form>
                                                <form action="{{ route('admin.books.forceDelete', $book->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to permanently delete this book?')">Delete Permanently</button>
                                                </form>
                                            @else
                                                <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('admin.books.destroy', $book) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this book?')">Delete</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No books found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $books->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection