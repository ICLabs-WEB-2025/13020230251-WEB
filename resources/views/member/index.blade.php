@extends('layouts.admin')

@section('title', 'Book Management')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-primary">Book Management</h1>
        <a href="{{ route('admin.books.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add New Book</a>
    </div>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th>Year</th>
                            <th>ISBN</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $book)
                            <tr>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->author }}</td>
                                <td>{{ $book->publisher ?? '-' }}</td>
                                <td>{{ $book->year ?? '-' }}</td>
                                <td>{{ $book->isbn ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $book->status === 'available' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($book->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-sm btn-warning me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if ($book->trashed())
                                        <a href="{{ route('admin.books.restore', $book->id) }}" class="btn btn-sm btn-success me-1" onclick="return confirm('Are you sure to restore?')">
                                            <i class="fas fa-undo"></i>
                                        </a>
                                        <form action="{{ route('admin.books.forceDelete', $book->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure to permanently delete?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.books.destroy', $book) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure to soft delete?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
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