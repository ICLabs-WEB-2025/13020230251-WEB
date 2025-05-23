@extends('layouts.member')

@section('title', 'Book List')

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <h2 class="fw-bold text-primary fs-5">Book List</h2>
            <p class="text-muted fs-6 mb-0">Browse available books.</p>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-body">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="searchInput" placeholder="Search books...">
                        <button class="btn btn-ios" id="searchButton">Search</button>
                    </div>
                    <select class="form-select mb-3" id="filterSelect">
                        <option value="">All Categories</option>
                        <option value="fiction">Fiction</option>
                        <option value="non-fiction">Non-Fiction</option>
                    </select>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th class="fs-6">Title</th>
                                    <th class="fs-6">Author</th>
                                    <th class="fs-6">Stock</th>
                                    <th class="fs-6">Action</th>
                                </tr>
                            </thead>
                            <tbody id="bookTable">
                                @forelse ($books as $book)
                                    <tr>
                                        <td class="fs-6">{{ $book->title }}</td>
                                        <td class="fs-6">{{ $book->author }}</td>
                                        <td class="fs-6">{{ $book->stock }}</td>
                                        <td><a href="{{ route('member.borrow-request') }}?book_id={{ $book->id }}" class="btn btn-ios btn-sm">Borrow</a></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center fs-6">No books available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('searchButton').addEventListener('click', function() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            const filter = document.getElementById('filterSelect').value;
            const rows = document.querySelectorAll('#bookTable tr');
            rows.forEach(row => {
                const title = row.cells[0].textContent.toLowerCase();
                const category = row.cells[1].textContent.toLowerCase(); // Simulasi kategori
                if ((query === '' || title.includes(query)) && (filter === '' || category.includes(filter))) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection