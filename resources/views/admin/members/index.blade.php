@extends('layouts.admin')

@section('title', 'Member Management')

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <h2 class="fw-bold text-primary fs-5">Member Management</h2>
            <p class="text-muted fs-6 mb-0">Manage all members.</p>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                    @endif
                    <a href="{{ route('admin.members.create') }}" class="btn btn-ios mb-3">Add New Member</a>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th class="d-none d-md-table-cell">Member ID</th> <!-- Sembunyikan pada layar kecil (<768px) -->
                                    <th>Email</th>
                                    <th class="d-none d-sm-table-cell">Phone</th> <!-- Sembunyikan pada layar sangat kecil (<576px) -->
                                    <th class="d-none d-lg-table-cell">Address</th> <!-- Sembunyikan pada layar kecil hingga medium (<992px) -->
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($members as $member)
                                    <tr>
                                        <td>{{ $member->name }}</td>
                                        <td class="d-none d-md-table-cell">{{ $member->member_id ?? '-' }}</td>
                                        <td>{{ $member->email }}</td>
                                        <td class="d-none d-sm-table-cell">{{ $member->phone ?? '-' }}</td>
                                        <td class="d-none d-lg-table-cell">{{ $member->address ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-sm btn-warning">Edit</a>
                                            @if ($member->trashed())
                                                <a href="{{ route('admin.members.restore', $member->id) }}" class="btn btn-sm btn-success">Restore</a>
                                                <form action="{{ route('admin.members.forceDelete', $member->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure to permanently delete?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete Permanently</button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.members.destroy', $member) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure to soft delete?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No members found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection