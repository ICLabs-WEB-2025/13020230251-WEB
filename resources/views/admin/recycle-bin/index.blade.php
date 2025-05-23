@extends('layouts.admin')

@section('title', 'Recycle Bin')

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <h2 class="fw-bold text-primary fs-5">Recycle Bin</h2>
            <p class="text-muted fs-6 mb-0">Deleted items can be restored here.</p>
        </div>
    </div>

    <!-- Deleted Books -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-body">
                    <h5 class="fs-5 mb-3">Deleted Books</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th class="fs-6">Title</th>
                                    <th class="fs-6">Author</th>
                                    <th class="fs-6">Deleted At</th>
                                    <th class="fs-6">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($deletedBooks as $book)
                                    <tr>
                                        <td class="fs-6">{{ $book->title }}</td>
                                        <td class="fs-6">{{ $book->author }}</td>
                                        <td class="fs-6">{{ $book->deleted_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.recycle-bin.restore-book', $book->id) }}" class="btn btn-ios btn-sm me-2">Restore</a>
                                            <form action="{{ route('admin.recycle-bin.force-delete-book', $book->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-ios btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center fs-6">No deleted books found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Deleted Members -->
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-body">
                    <h5 class="fs-5 mb-3">Deleted Members</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th class="fs-6">Name</th>
                                    <th class="fs-6">Email</th>
                                    <th class="fs-6">Deleted At</th>
                                    <th class="fs-6">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($deletedMembers as $member)
                                    <tr>
                                        <td class="fs-6">{{ $member->name }}</td>
                                        <td class="fs-6">{{ $member->email }}</td>
                                        <td class="fs-6">{{ $member->deleted_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.recycle-bin.restore-member', $member->id) }}" class="btn btn-ios btn-sm me-2">Restore</a>
                                            <form action="{{ route('admin.recycle-bin.force-delete-member', $member->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-ios btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center fs-6">No deleted members found.</td>
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