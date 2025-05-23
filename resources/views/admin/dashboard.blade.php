@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <h1 class="fw-bold text-primary fs-4">Admin Dashboard</h1>
            <p class="text-muted fs-6 mb-0">Welcome back, {{ Auth::user()->name }}!</p>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row mb-4 g-3">
        <div class="col-md-4 col-sm-6">
            <div class="card bg-primary text-white shadow-sm h-100 p-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-book fa-2x me-3"></i>
                    <div>
                        <h6 class="card-title mb-0 fs-6">Total Books</h6>
                        <p class="card-text fs-3 mb-0">{{ $totalBooks }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card bg-success text-white shadow-sm h-100 p-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-users fa-2x me-3"></i>
                    <div>
                        <h6 class="card-title mb-0 fs-6">Total Members</h6>
                        <p class="card-text fs-3 mb-0">{{ $totalMembers }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card bg-warning text-white shadow-sm h-100 p-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-exchange-alt fa-2x me-3"></i>
                    <div>
                        <h6 class="card-title mb-0 fs-6">Total Transactions</h6>
                        <p class="card-text fs-3 mb-0">{{ $totalTransactions }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Peminjaman -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-3">
                    <h5 class="card-title fw-semibold fs-5 mb-3">Borrowing Trends (Last 6 Months)</h5>
                    <div style="height: 300px;">
                        <canvas id="borrowingChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Buku Paling Sering Dipinjam -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-3">
                    <h5 class="card-title fw-semibold fs-5 mb-3">Most Borrowed Books</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th class="fs-6">Title</th>
                                    <th class="fs-6">Author</th>
                                    <th class="fs-6">Borrow Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($popularBooks as $transaction)
                                    <tr>
                                        <td class="fs-6">{{ $transaction->book->title ?? 'Unknown' }}</td>
                                        <td class="fs-6">{{ $transaction->book->author ?? 'Unknown' }}</td>
                                        <td class="fs-6">{{ $transaction->borrow_count }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
        const ctx = document.getElementById('borrowingChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [
                    {
                        label: 'Borrowed',
                        data: @json($borrowCounts),
                        borderColor: '#6a9de0',
                        backgroundColor: 'rgba(106, 157, 224, 0.3)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Returned',
                        data: @json($returnCounts),
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.3)',
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { font: { size: 12 } }
                    },
                    x: {
                        ticks: { font: { size: 12 } }
                    }
                },
                plugins: {
                    legend: { labels: { font: { size: 12 } } }
                }
            }
        });
    </script>
@endsection