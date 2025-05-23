<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Library Member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background-color: #f9f9fb;
            overflow-x: hidden;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .sidebar {
            width: 280px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background: linear-gradient(180deg, #007aff, #005bb5);
            z-index: 1000;
            transition: transform 0.3s ease;
            border-top-right-radius: 20px;
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
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: none;
        }
        .btn-ios {
            background-color: #007aff;
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
                <h4 class="text-white fw-bold"><i class="fas fa-user me-2"></i> Member Panel</h4>
            </div>
            <nav class="nav flex-column">
                <a href="{{ route('member.books') }}" class="nav-link {{ Route::is('member.books') ? 'active' : '' }}"><i class="fas fa-book me-2"></i> Book List</a>
                <a href="{{ route('member.borrow-request') }}" class="nav-link {{ Route::is('member.borrow-request') ? 'active' : '' }}"><i class="fas fa-plus me-2"></i> Borrow Request</a>
                <a href="{{ route('member.borrow-history') }}" class="nav-link {{ Route::is('member.borrow-history') ? 'active' : '' }}"><i class="fas fa-history me-2"></i> Borrow History</a>
                <a href="{{ route('member.profile') }}" class="nav-link {{ Route::is('member.profile') ? 'active' : '' }}"><i class="fas fa-user-edit me-2"></i> Profile</a>
                <form action="{{ route('logout') }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="nav-link text-white bg-transparent border-0"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
                </form>
            </nav>
        </div>

        <div class="content-wrapper">
            <nav class="navbar navbar-light bg-white shadow-sm mb-4 p-3 rounded-3">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h4">@yield('title')</span>
                </div>
            </nav>
            <div class="container-fluid p-3">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>