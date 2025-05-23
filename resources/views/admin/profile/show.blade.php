@extends('layouts.admin')

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
                    <h5 class="fs-5 mb-3">Account Information</h5>
                    <div class="mb-3">
                        <label class="form-label fs-6">Name</label>
                        <p class="fs-6">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-6">Email</label>
                        <p class="fs-6">{{ Auth::user()->email }}</p>
                    </div>
                    <a href="{{ route('admin.profile.edit') }}" class="btn btn-ios">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
@endsection