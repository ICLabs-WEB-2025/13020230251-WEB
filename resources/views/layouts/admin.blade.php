<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Library Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background-color: #f9f9fb; /* Latar belakang lembut ala iOS */
            overflow-x: hidden;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; /* Font iOS */
        }
        .sidebar {
            width: 280px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background: linear-gradient(180deg, #007aff, #005bb5); /* Gradiasi biru iOS */
            z-index: 1000;
            transition: transform 0.3s ease;
            border-top-right-radius: 20px; /* Sudut membulat iOS */
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }
        .sidebar .nav-link {
            color: #ffffff;
            padding: 12px 20px;
            font-size: 1rem;
            border-radius: 10px;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }
        .content-wrapper {
            margin-left: 280px;
            width: calc(100% - 280px);
            min-height: 100vh;
            padding: 20px;
        }
        .card {
            border-radius: 20px; /* Sudut membulat iOS */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); /* Shadow halus */
            border: none;
        }
        .table th, .table td {
            border-color: #e0e0e0; /* Garis tabel lembut */
        }
        .btn-ios {
            background-color: #007aff; /* Biru iOS */
            border: none;
            border-radius: 12px;
            padding: 8px 16px;
            color: #ffffff;
            transition: background-color 0.2s ease;
        }
        .btn-ios:hover {
            background-color: #005bb5;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-280px);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .content-wrapper {
                margin-left: 0;
                width: 100%;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex flex-nowrap">
        <div class="sidebar vh-100 p-3">
            <div class="text-center mb-3">
                <h4 class="text-white fw-bold"><i class="fas fa-book-open me-2"></i> Library Admin</h4>
            </div>
            <nav class="nav flex-column">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
                <a href="{{ route('admin.books.index') }}" class="nav-link {{ Route::is('admin.books.*') ? 'active' : '' }}"><i class="fas fa-book me-2"></i> Manage Books</a>
                <a href="{{ route('admin.members.index') }}" class="nav-link {{ Route::is('admin.members.*') ? 'active' : '' }}"><i class="fas fa-users me-2"></i> Manage Members</a>
                <a href="{{ route('admin.transactions.index') }}" class="nav-link {{ Route::is('admin.transactions.*') ? 'active' : '' }}"><i class="fas fa-exchange-alt me-2"></i> Transactions</a>
                <a href="{{ route('admin.recycle-bin.index') }}" class="nav-link {{ Route::is('admin.recycle-bin.*') ? 'active' : '' }}"><i class="fas fa-trash-alt me-2"></i> Recycle Bin</a>
                <a href="{{ route('admin.profile.show') }}" class="nav-link {{ Route::is('admin.profile.*') ? 'active' : '' }}"><i class="fas fa-user me-2"></i> Profile</a>
                <form action="{{ route('logout') }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="nav-link text-white bg-transparent border-0"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
                </form>
            </nav>
        </div>

        <div class="content-wrapper">
            <nav class="navbar navbar-light bg-white shadow-sm mb-4 p-3 rounded-3">
                <div class="container-fluid">
                    <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <span class="navbar-brand mb-0 h4">@yield('title')</span>
                </div>
            </nav>
            <div class="container-fluid p-3">
                @yield('content')
            </div>
        </div>
    </div>

    <div class="collapse d-md-none" id="sidebarMenu">
        <div class="position-fixed top-0 start-0 h-100 bg-primary p-3" style="width: 280px; z-index: 1050; border-top-right-radius: 20px; box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);">
            <div class="text-center mb-3">
                <h4 class="text-white fw-bold"><i class="fas fa-book-open me-2"></i> Library Admin</h4>
            </div>
            <nav class="nav flex-column">
                <a href="{{ route('admin.dashboard') }}" class="nav-link text-white {{ Route::is('admin.dashboard') ? 'active bg-secondary bg-opacity-25' : '' }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
                <a href="{{ route('admin.books.index') }}" class="nav-link text-white {{ Route::is('admin.books.*') ? 'active bg-secondary bg-opacity-25' : '' }}"><i class="fas fa-book me-2"></i> Manage Books</a>
                <a href="{{ route('admin.members.index') }}" class="nav-link text-white {{ Route::is('admin.members.*') ? 'active bg-secondary bg-opacity-25' : '' }}"><i class="fas fa-users me-2"></i> Manage Members</a>
                <a href="{{ route('admin.transactions.index') }}" class="nav-link text-white {{ Route::is('admin.transactions.*') ? 'active bg-secondary bg-opacity-25' : '' }}"><i class="fas fa-exchange-alt me-2"></i> Transactions</a>
                <a href="{{ route('admin.recycle-bin.index') }}" class="nav-link text-white {{ Route::is('admin.recycle-bin.*') ? 'active bg-secondary bg-opacity-25' : '' }}"><i class="fas fa-trash-alt me-2"></i> Recycle Bin</a>
                <a href="{{ route('admin.profile.show') }}" class="nav-link text-white {{ Route::is('admin.profile.*') ? 'active bg-secondary bg-opacity-25' : '' }}"><i class="fas fa-user me-2"></i> Profile</a>
                <form action="{{ route('logout') }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="nav-link text-white bg-transparent border-0"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
                </form>
            </nav>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('extra-js')
</body>
</html>