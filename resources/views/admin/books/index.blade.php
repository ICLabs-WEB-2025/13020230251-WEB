@extends('layouts.admin')

  @section('title', 'Book Management')

  @section('content')
      <h1 class="mb-4">Book Management</h1>
      @if (session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      <a href="{{ route('admin.books.create') }}" class="btn btn-primary mb-3">Add New Book</a>
      <table class="table table-striped">
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
                      <td>{{ $book->status }}</td>
                      <td>
                          <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-sm btn-warning">Edit</a>
                          @if ($book->trashed())
                              <a href="{{ route('admin.books.restore', $book->id) }}" class="btn btn-sm btn-success">Restore</a>
                              <form action="{{ route('admin.books.forceDelete', $book->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure to permanently delete?')">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-sm btn-danger">Delete Permanently</button>
                              </form>
                          @else
                              <form action="{{ route('admin.books.destroy', $book) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure to soft delete?')">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                              </form>
                          @endif
                      </td>
                  </tr>
              @endforeach
          </tbody>
      </table>
  @endsection