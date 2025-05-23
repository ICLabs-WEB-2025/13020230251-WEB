@extends('layouts.admin')

  @section('title', 'Member Management')

  @section('content')
      <h1 class="mb-4">Member Management</h1>
      @if (session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      <a href="{{ route('admin.members.create') }}" class="btn btn-primary mb-3">Add New Member</a>
      <table class="table table-striped">
          <thead>
              <tr>
                  <th>Name</th>
                  <th>Member ID</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Address</th>
                  <th>Actions</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($members as $member)
                  <tr>
                      <td>{{ $member->name }}</td>
                      <td>{{ $member->member_id ?? '-' }}</td>
                      <td>{{ $member->email }}</td>
                      <td>{{ $member->phone ?? '-' }}</td>
                      <td>{{ $member->address ?? '-' }}</td>
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
              @endforeach
          </tbody>
      </table>
  @endsection