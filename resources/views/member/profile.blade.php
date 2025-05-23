@extends('layouts.member')

@section('title', 'Profile')

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <h2 class="fw-bold text-primary fs-5">Profile</h2>
            <p class="text-muted fs-6 mb-0">Manage your account settings.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card p-3">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                    @endif
                    <form action="{{ route('member.update-profile') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label fs-6">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', Auth::user()->name) }}" required>
                            @error('name')
                                <div class="text-danger fs-6 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-6">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required>
                            @error('email')
                                <div class="text-danger fs-6 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-6">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', Auth::user()->phone) }}">
                            @error('phone')
                                <div class="text-danger fs-6 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-6">Address</label>
                            <textarea name="address" class="form-control">{{ old('address', Auth::user()->address) }}</textarea>
                            @error('address')
                                <div class="text-danger fs-6 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-6">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Leave blank to keep unchanged">
                            @error('password')
                                <div class="text-danger fs-6 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-6">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password">
                        </div>
                        <button type="submit" class="btn btn-ios">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection