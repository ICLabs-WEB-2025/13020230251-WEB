@extends('layouts.admin')

  @section('title', 'Edit Member')

  @section('content')
      <h1 class="mb-4">Edit Member</h1>
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
      <form method="POST" action="{{ route('admin.members.update', $member) }}">
          @csrf
          @method('PUT')
          <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $member->name) }}" required>
              @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="mb-3">
              <label for="member_id" class="form-label">Member ID</label>
              <input type="text" name="member_id" id="member_id" class="form-control @error('member_id') is-invalid @enderror" value="{{ old('member_id', $member->member_id) }}" required>
              @error('member_id')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $member->email) }}" required>
              @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="mb-3">
              <label for="phone" class="form-label">Phone</label>
              <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $member->phone) }}">
              @error('phone')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="mb-3">
              <label for="address" class="form-label">Address</label>
              <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror">{{ old('address', $member->address) }}</textarea>
              @error('address')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="mb-3">
              <label for="password" class="form-label">Password (Leave blank to keep unchanged)</label>
              <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
              @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="d-grid">
              <button type="submit" class="btn btn-primary">Update Member</button>
          </div>
      </form>
  @endsection