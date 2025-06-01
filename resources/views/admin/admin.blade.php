<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - HNFRTOOLS</title>

    <!-- ✅ Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- ✅ Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- ✅ Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ✅ Custom CSS -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 250px;
            background: #1A3636;
            min-height: 100vh;
            position: fixed;
            color: #fff;
        }
        .sidebar .brand {
            padding: 20px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li a {
            color: #fff;
            display: flex;
            align-items: center;
            padding: 12px 20px;
            text-decoration: none;
            font-size: 1.1rem;
            border-radius: 8px;
            transition: background 0.3s;
        }
        .sidebar ul li a:hover,
        .sidebar ul li a.active {
            background-color: #142929;
        }
        .sidebar ul li a i {
            margin-right: 10px;
        }
        .menu-title {
            padding: 10px 20px;
            color: #b8c1c1;
            text-transform: uppercase;
            font-size: 0.85rem;
            margin-top: 10px;
        }
        #content-wrapper {
            margin-left: 250px;
            padding: 20px;
        }

        .dropdown-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .dropdown-toggle .arrow {
            margin-left: auto;
        }
        .submenu {
            display: none;
            padding-left: 20px;
        }
        .dropdown.active .submenu {
            display: block;
        }
        .submenu li {
            padding: 5px 0;
        }
        .submenu li a {
            display: flex;
            align-items: center;
        }
        .submenu li a i {
            margin-right: 8px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="brand">
            <img src="{{ asset('images/logo.png') }}"
                 alt="Logo"
                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%; margin-bottom: 10px;"
                 onerror="this.onerror=null; this.src='{{ asset('images/default-logo.png') }}';"><br>
            HNFRTOOLS
        </div>

        <div class="menu-title">Menu</div>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.produk.index') }}"><i class="fas fa-box-open"></i> Produk</a></li>
            <li><a href="{{ route('admin.user.index') }}"><i class="fas fa-user-circle"></i> User</a></li>
            <li><a href="{{ route('admin.pesanan.index') }}"><i class="fas fa-shopping-cart"></i> Pesanan</a></li>
            <li><a href="{{ route('admin.cs.index') }}"><i class="fas fa-headset"></i> CS</a></li>
            <li class="dropdown">
                <a href="#" class="kurir-toggle d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-motorcycle me-2"></i> Kurir</span>
                    <i class="fas fa-chevron-down arrow"></i>
                </a>
                <ul class="submenu">
                    <li><a href="{{ route('admin.kurir.index') }}"><i class="fas fa-user"></i> Data Kurir</a></li>
                    <li><a href="{{ route('admin.kendaraan.index') }}"><i class="fas fa-truck"></i> Kendaraan</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>

    <!-- Konten -->
    <div id="content-wrapper">
        @yield('content')
    </div>

    <!-- ✅ Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ✅ jQuery (untuk dropdown custom) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- ✅ Dropdown kurir toggle -->
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.kurir-toggle').forEach(function (toggle) {
          toggle.addEventListener('click', function (e) {
            e.preventDefault();
            this.parentElement.classList.toggle('active');
          });
        });
      });
    </script>

    @stack('scripts')
</body>
</html>
