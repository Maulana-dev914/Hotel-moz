<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Hotel Moz')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --sidebar-bg: #1e3a5f;
            --sidebar-active: #2d5a8f;
            --header-bg: #ffffff;
            --text-primary: #2c3e50;
            --text-secondary: #7f8c8d;
            --success: #10b981;
            --warning: #f59e0b;
            --info: #3b82f6;
            --danger: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f7fa;
            color: var(--text-primary);
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 0;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .user-info h6 {
            margin: 0;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .user-info small {
            color: rgba(255,255,255,0.7);
            font-size: 0.75rem;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1.5rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .menu-item:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }

        .menu-item.active {
            background-color: var(--sidebar-active);
            color: white;
            border-left-color: #60a5fa;
        }

        .menu-item i {
            font-size: 1.1rem;
            width: 20px;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            border-radius: 8px;
        }

        .logout-btn:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            flex: 1;
            transition: all 0.3s;
        }

        /* Header */
        .header {
            background-color: var(--header-bg);
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .welcome-text {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .search-box {
            position: relative;
            width: 300px;
        }

        .search-box input {
            width: 100%;
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .search-box i {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-primary);
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }

        .header-icon:hover {
            background-color: #e5e7eb;
        }

        .badge-notification {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--danger);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Content Area */
        .content-area {
            padding: 2rem;
        }

        /* KPI Cards */
        .kpi-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: all 0.3s;
            height: 100%;
        }

        .kpi-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }

        .kpi-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .kpi-value {
            font-size: 2rem;
            font-weight: 700;
            margin: 0.5rem 0;
        }

        .kpi-label {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin: 0;
        }

        .kpi-success { background-color: #d1fae5; color: var(--success); }
        .kpi-warning { background-color: #fef3c7; color: var(--warning); }
        .kpi-info { background-color: #dbeafe; color: var(--info); }
        .kpi-danger { background-color: #fee2e2; color: var(--danger); }

        /* Cards */
        .card-modern {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: none;
            margin-bottom: 1.5rem;
        }

        .card-header-modern {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            background-color: #f9fafb;
            border-radius: 12px 12px 0 0;
        }

        .card-header-modern h5 {
            margin: 0;
            font-weight: 600;
            color: var(--text-primary);
        }

        .card-body-modern {
            padding: 1.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .search-box {
                width: 200px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h4 class="mb-0" style="color: white;">Hotel Moz</h4>
                <small style="color: rgba(255,255,255,0.7);">Painel Administrativo</small>
            </div>

            <div class="user-profile">
                <div class="user-avatar">
                    {{ strtoupper(substr(session('user_name') ?? 'A', 0, 1)) }}
                </div>
                <div class="user-info">
                    <h6>{{ session('user_name') ?? 'Administrador' }}</h6>
                    <small>{{ session('user_email') ?? 'admin@hotelmoz.com' }}</small>
                </div>
            </div>

            <nav class="sidebar-menu">
                <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.rooms.index') }}" class="menu-item {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                    <i class="bi bi-door-open"></i>
                    <span>Quartos</span>
                </a>
                <a href="{{ route('admin.guests.index') }}" class="menu-item {{ request()->routeIs('admin.guests.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Hóspedes</span>
                </a>
                <a href="{{ route('admin.reservations.index') }}" class="menu-item {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check"></i>
                    <span>Reservas</span>
                </a>
                <a href="{{ route('admin.stays.index') }}" class="menu-item {{ request()->routeIs('admin.stays.*') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i>
                    <span>Estadias</span>
                </a>
                <a href="{{ route('admin.reviews.index') }}" class="menu-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                    <i class="bi bi-star"></i>
                    <span>Avaliações</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Usuários</span>
                </a>
                <a href="{{ route('admin.profile.show') }}" class="menu-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                    <i class="bi bi-person-circle"></i>
                    <span>Perfil</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="menu-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <i class="bi bi-gear"></i>
                    <span>Definições</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <a href="{{ route('admin.logout') }}" class="logout-btn">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Sair</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="header">
                <div class="header-left">
                    <span class="welcome-text">Bem-vindo, {{ session('user_name') ?? 'Administrador' }}!</span>
                </div>
                <div class="header-right">
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Buscar...">
                    </div>
                    <div class="header-icon">
                        <i class="bi bi-bell"></i>
                        <span class="badge-notification">3</span>
                    </div>
                    <div class="header-icon">
                        <i class="bi bi-gear"></i>
                    </div>
                    <a href="{{ route('admin.profile.show') }}" class="header-icon" title="Perfil">
                        <i class="bi bi-person-circle"></i>
                    </a>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-area">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(isset($errors) && $errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
