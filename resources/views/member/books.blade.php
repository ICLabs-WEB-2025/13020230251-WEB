@extends('layouts.member')

@section('title', 'Book List')

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <h2 class="fw-bold text-primary fs-5">Book List</h2>
            <p class="text-muted fs-6 mb-0">Browse all books.</p>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="input-group mb-4">
                        <input type="text" class="form-control" id="searchInput" placeholder="Search by title..." aria-label="Search books">
                        <button class="btn btn-ios" id="searchButton">Search</button>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="bookGrid">
                        @forelse ($books as $book)
                            <div class="col">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $book->title }}</h5>
                                        <p class="card-text"><strong>Author:</strong> {{ $book->author }}</p>
                                        <p class="card-text"><strong>Stock:</strong> {{ $book->stock }}</p>
                                        <p class="card-text"><strong>Status:</strong> {{ ucfirst($book->status) }}</p>
                                        <div class="mt-3">
                                            @if ($book->stock > 0 && $book->status == 'available')
                                                <a href="{{ route('member.borrow-request') }}?book_id={{ $book->id }}" class="btn btn-ios btn-sm">Borrow</a>
                                            @else
                                                <button class="btn btn-secondary btn-sm" disabled>Not Available</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center">
                                <p class="text-muted fs-6">No books found.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('searchButton').addEventListener('click', function() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('#bookGrid .col');
            cards.forEach(card => {
                const title = card.querySelector('.card-title').textContent.toLowerCase();
                if (query === '' || title.includes(query)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Real-time search
        document.getElementById('searchInput').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const cards = document.querySelectorAll('#bookGrid .col');
            cards.forEach(card => {
                const title = card.querySelector('.card-title').textContent.toLowerCase();
                if (query === '' || title.includes(query)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
@endsection