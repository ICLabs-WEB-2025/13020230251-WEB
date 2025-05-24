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
            background-color: #f5f7fa; /* Latar belakang lembut */
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow-x: hidden;
        }
        .sidebar {
            width: 260px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background: linear-gradient(180deg, #1a73e8, #0d47a1); /* Gradiasi biru modern */
            z-index: 1000;
            transition: transform 0.3s ease-in-out;
            border-top-right-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }
        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .sidebar .nav-link {
            color: #ffffff;
            padding: 12px 20px;
            font-size: 1rem;
            border-radius: 10px;
            margin: 5px 10px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
        }
        .content-wrapper {
            margin-left: 260px;
            width: calc(100% - 260px);
            min-height: 100vh;
            padding: 20px;
            background-color: #f5f7fa;
            transition: margin-left 0.3s ease-in-out, width 0.3s ease-in-out;
        }
        .navbar {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: none;
            background: #ffffff;
        }
        .btn-ios {
            background-color: #1a73e8;
            border: none;
            border-radius: 10px;
            padding: 8px 16px;
            color: #ffffff;
            font-weight: 500;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-ios:hover {
            background-color: #0d47a1;
            transform: scale(1.03);
        }
        .toggle-btn {
            display: none;
            background: #1a73e8;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
            cursor: pointer;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1100;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .toggle-btn:hover {
            background-color: #0d47a1;
            transform: rotate(90deg);
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-260px);
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .content-wrapper {
                margin-left: 0;
                width: 100%;
                padding: 10px;
            }
            .toggle-btn {
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .navbar {
                margin-top: 60px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar Toggle Button -->
    <button class="toggle-btn" id="sidebarToggle"><i class="fas fa-bars"></i></button>

    <div class="d-flex flex-nowrap">
        <!-- Sidebar -->
        <div class="sidebar vh-100" id="sidebar">
            <div class="sidebar-header">
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

        <!-- Content Wrapper -->
        <div class="content-wrapper" id="contentWrapper">
            <nav class="navbar navbar-light mb-4 p-3">
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
    <script>
        const sidebar = document.getElementById('sidebar');
        const contentWrapper = document.getElementById('contentWrapper');
        const toggleBtn = document.getElementById('sidebarToggle');

        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            contentWrapper.classList.toggle('shifted');
        });

        // Tutup sidebar saat mengklik di luar
        document.addEventListener('click', function(event) {
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnToggleBtn = toggleBtn.contains(event.target);
            if (!isClickInsideSidebar && !isClickOnToggleBtn && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
                contentWrapper.classList.remove('shifted');
            }
        });
    </script>
    @yield('extra-js')
</body>
</html>