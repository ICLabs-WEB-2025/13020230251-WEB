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
            background-color: #f5f7fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow-x: hidden;
            transition: all 0.3s ease;
        }
        .sidebar {
            width: 280px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background: linear-gradient(180deg, #007aff, #005bb5);
            z-index: 1000;
            transition: transform 0.3s ease-in-out;
            border-top-right-radius: 20px;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
        }
        .sidebar .nav-link {
            color: #ffffff;
            padding: 15px 20px;
            font-size: 1rem;
            border-radius: 10px;
            transition: all 0.2s ease;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            transform: translateX(5px);
        }
        .content-wrapper {
            margin-left: 280px;
            width: calc(100% - 280px);
            min-height: 100vh;
            padding: 20px;
            transition: margin-left 0.3s ease-in-out;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            border: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }
        .btn-ios {
            background-color: #007aff;
            border: none;
            border-radius: 12px;
            padding: 10px 20px;
            color: #ffffff;
            transition: background-color 0.2s ease, transform 0.2s ease;
        }
        .btn-ios:hover {
            background-color: #005bb5;
            transform: scale(1.05);
        }
        .navbar {
            border-radius: 15px;
            background: #ffffff;
        }
        .toggle-btn {
            display: none;
            background: #007aff;
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
            background-color: #005bb5;
            transform: rotate(90deg);
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-280px);
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
        }
        @media (min-width: 769px) {
            .toggle-btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar Toggle Button (Hamburger Menu) -->
    <button class="toggle-btn" id="sidebarToggle"><i class="fas fa-bars"></i></button>

    <div class="d-flex flex-nowrap">
        <!-- Sidebar -->
        <div class="sidebar vh-100 p-3" id="sidebar">
            <div class="text-center mb-4">
                <h4 class="text-white fw-bold"><i class="fas fa-user me-2"></i> Member Panel</h4>
            </div>
            <nav class="nav flex-column">
                <a href="{{ route('member.books') }}" class="nav-link {{ Route::is('member.books') ? 'active' : '' }}"><i class="fas fa-book me-2"></i> Book List</a>
                <a href="{{ route('member.borrow-request') }}" class="nav-link {{ Route::is('member.borrow-request') ? 'active' : '' }}"><i class="fas fa-plus me-2"></i> Borrow Request</a>
                <a href="{{ route('member.borrow-history') }}" class="nav-link {{ Route::is('member.borrow-history') ? 'active' : '' }}"><i class="fas fa-history me-2"></i> Borrow History</a>
                <a href="{{ route('member.profile') }}" class="nav-link {{ Route::is('member.profile') ? 'active' : '' }}"><i class="fas fa-user-edit me-2"></i> Profile</a>
                <form action="{{ route('logout') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="nav-link text-white bg-transparent border-0"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
                </form>
            </nav>
        </div>

        <!-- Content Wrapper -->
        <div class="content-wrapper" id="contentWrapper">
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

    <!-- Script Bootstrap JS -->
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
    @yield('scripts')
</body>
</html>
