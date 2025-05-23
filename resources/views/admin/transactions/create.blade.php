@extends('layouts.admin')

  @section('title', 'Create New Transaction')

  @section('content')
      <h1 class="mb-4">Create New Transaction</h1>
      @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
      <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary mb-3">Back to List</a>
      <form method="POST" action="{{ route('admin.transactions.store') }}">
          @csrf
          <div class="mb-3">
              <label for="user_id" class="form-label">Member</label>
              <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                  <option value="">Select Member</option>
                  @foreach ($members as $member)
                      <option value="{{ $member->id }}" {{ old('user_id') == $member->id ? 'selected' : '' }}>{{ $member->name }} ({{ $member->member_id }})</option>
                  @endforeach
              </select>
              @error('user_id')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="mb-3">
              <label for="book_id" class="form-label">Book</label>
              <select name="book_id" id="book_id" class="form-control @error('book_id') is-invalid @enderror" required>
                  <option value="">Select Book</option>
                  @foreach ($books as $book)
                      <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>{{ $book->title }} ({{ $book->author }})</option>
                  @endforeach
              </select>
              @error('book_id')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="mb-3">
              <label for="borrow_date" class="form-label">Borrow Date</label>
              <input type="date" name="borrow_date" id="borrow_date" class="form-control @error('borrow_date') is-invalid @enderror" value="{{ old('borrow_date', now()->toDateString()) }}" required>
              @error('borrow_date')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="d-grid">
              <button type="submit" class="btn btn-primary">Create Transaction</button>
          </div>
      </form>
  @endsection