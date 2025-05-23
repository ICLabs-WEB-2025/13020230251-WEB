@extends('layouts.admin')

  @section('title', 'Edit Book')

  @section('content')
      <h1 class="mb-4">Edit Book</h1>
      @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
      <a href="{{ route('admin.books.index') }}" class="btn btn-secondary mb-3">Back to List</a>
      <form method="POST" action="{{ route('admin.books.update', $book) }}">
          @csrf
          @method('PUT')
          <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $book->title) }}" required>
              @error('title')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="mb-3">
              <label for="author" class="form-label">Author</label>
              <input type="text" name="author" id="author" class="form-control @error('author') is-invalid @enderror" value="{{ old('author', $book->author) }}" required>
              @error('author')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="mb-3">
              <label for="publisher" class="form-label">Publisher</label>
              <input type="text" name="publisher" id="publisher" class="form-control @error('publisher') is-invalid @enderror" value="{{ old('publisher', $book->publisher) }}">
              @error('publisher')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="mb-3">
              <label for="year" class="form-label">Year</label>
              <input type="number" name="year" id="year" class="form-control @error('year') is-invalid @enderror" value="{{ old('year', $book->year) }}">
              @error('year')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="mb-3">
              <label for="isbn" class="form-label">ISBN</label>
              <input type="text" name="isbn" id="isbn" class="form-control @error('isbn') is-invalid @enderror" value="{{ old('isbn', $book->isbn) }}">
              @error('isbn')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="mb-3">
              <label for="status" class="form-label">Status</label>
              <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                  <option value="available" {{ old('status', $book->status) == 'available' ? 'selected' : '' }}>Available</option>
                  <option value="borrowed" {{ old('status', $book->status) == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
              </select>
              @error('status')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="d-grid">
              <button type="submit" class="btn btn-primary">Update Book</button>
          </div>
      </form>
  @endsection