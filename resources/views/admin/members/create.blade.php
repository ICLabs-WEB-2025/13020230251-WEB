@extends('layouts.admin')

  @section('title', 'Add New Member')

  @section('content')
      <h1 class="mb-4">Add New Member</h1>
      @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
      <a href="{{ route('admin.members.index') }}" class="btn btn-secondary mb-3">Back to List</a>
      <form method="POST" action="{{ route('admin.members.store') }}">
          @csrf
          <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
              @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="mb-3">
              <label for="member_id" class="form-label">Member ID</label>
              <input type="text" name="member_id" id="member_id" class="form-control @error('member_id') is-invalid @enderror" value="{{ old('member_id') }}" required>
              @error('member_id')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
              @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="mb-3">
              <label for="phone" class="form-label">Phone</label>
              <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
              @error('phone')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="mb-3">
              <label for="address" class="form-label">Address</label>
              <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
              @error('address')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
              @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="d-grid">
              <button type="submit" class="btn btn-primary">Save Member</button>
          </div>
      </form>
  @endsection