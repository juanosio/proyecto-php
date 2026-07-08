<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ChanchullApp')</title>
    <link rel="stylesheet" href="/css/tailwind.css">
    <link rel="stylesheet" href="/css/app.css">
    @yield('head')
</head>
<body>

    <div class="orb orb--cyan"></div>
    <div class="orb orb--violet"></div>
    <div class="orb orb--rose"></div>
    <div class="grid-overlay"></div>
    <div class="mouse-glow"></div>
    <div class="particles" id="particles"></div>

    <div id="page-loader" class="page-loader">
        <div class="loader-wrap">
            <div class="loader-ripple"></div>
            <div class="loader-ripple"></div>
            <div class="loader-ripple"></div>
            <div class="loader-morph"></div>
            <div class="loader-label">Cargando</div>
        </div>
    </div>

    <nav class="navbar">
        <a href="/" class="nav-logo" style="text-decoration:none">
            <div class="nav-logo-icon"><i class="fa-solid fa-chart-line"></i></div>
            <div>
                <div class="nav-logo-text">ChanchullApp</div>
                <div class="nav-logo-sub">Inteligencia de Precios</div>
            </div>
        </a>
        <div class="nav-links">
            @if($auth_logged)
                <a href="/" class="nav-link {{ $currentRoute === '/' ? 'active' : '' }}">Inicio</a>
                <a href="/dashboard" class="nav-link {{ $currentRoute === '/dashboard' ? 'active' : '' }}">Dashboard</a>
                <a href="/historial" class="nav-link {{ $currentRoute === '/historial' ? 'active' : '' }}">Historial</a>
                <a href="/canasta" class="nav-link {{ $currentRoute === '/canasta' ? 'active' : '' }}">Canasta</a>
                <a href="/ranking" class="nav-link {{ $currentRoute === '/ranking' ? 'active' : '' }}">Ranking</a>
                <a href="/perfil" class="nav-link {{ $currentRoute === '/perfil' ? 'active' : '' }}">Perfil</a>
                @if($auth_admin)
                    <a href="/admin/users" class="nav-link {{ $currentRoute === '/admin/users' ? 'active' : '' }}">Usuarios</a>
                @endif
                <form method="POST" action="/logout" style="display:inline">
                    <button type="submit" class="nav-link" style="background:none;border:none;cursor:pointer;font-family:inherit;color:rgba(255,255,255,0.5);padding:8px 16px;border-radius:10px;font-size:13px;font-weight:500;transition:all 0.25s" onmouseover="this.style.color='#fff';this.style.background='rgba(255,255,255,0.04)'" onmouseout="this.style.color='rgba(255,255,255,0.5)';this.style.background='none'">
                        <i class="fa-solid fa-right-from-bracket" style="margin-right:4px"></i> Salir
                    </button>
                </form>
            @else
                <a href="/" class="nav-link {{ $currentRoute === '/' ? 'active' : '' }}">Inicio</a>
                <a href="/login" class="nav-link {{ $currentRoute === '/login' ? 'active' : '' }}">Iniciar Sesión</a>
                <a href="/register" class="btn btn--primary" style="padding:8px 16px;font-size:12px">
                    <i class="fa-solid fa-user-plus" style="font-size:11px"></i> Registrate
                </a>
            @endif
        </div>
        <div class="nav-hamburger" id="nav-hamburger">
            <span></span><span></span><span></span>
        </div>
    </nav>

    <div class="mobile-overlay" id="mobile-overlay">
        @if($auth_logged)
            <a href="/" class="nav-link {{ $currentRoute === '/' ? 'active' : '' }}">Inicio</a>
            <a href="/dashboard" class="nav-link {{ $currentRoute === '/dashboard' ? 'active' : '' }}">Dashboard</a>
            <a href="/historial" class="nav-link {{ $currentRoute === '/historial' ? 'active' : '' }}">Historial</a>
            <a href="/canasta" class="nav-link {{ $currentRoute === '/canasta' ? 'active' : '' }}">Canasta</a>
            <a href="/ranking" class="nav-link {{ $currentRoute === '/ranking' ? 'active' : '' }}">Ranking</a>
            <a href="/perfil" class="nav-link {{ $currentRoute === '/perfil' ? 'active' : '' }}">Perfil</a>
            @if($auth_admin)
                <a href="/admin/users" class="nav-link {{ $currentRoute === '/admin/users' ? 'active' : '' }}">Usuarios</a>
            @endif
            <form method="POST" action="/logout" style="width:260px">
                <button type="submit" class="nav-link" style="width:100%;background:none;border:none;cursor:pointer;font-family:inherit;color:rgba(255,255,255,0.5);padding:14px 32px;border-radius:12px;font-size:18px;text-align:center">
                    <i class="fa-solid fa-right-from-bracket" style="margin-right:6px"></i> Cerrar Sesión
                </button>
            </form>
        @else
            <a href="/" class="nav-link {{ $currentRoute === '/' ? 'active' : '' }}">Inicio</a>
            <a href="/login" class="nav-link {{ $currentRoute === '/login' ? 'active' : '' }}">Iniciar Sesión</a>
            <a href="/register" class="nav-link" style="color:#00f5d4">Registrate</a>
        @endif
    </div>

    <div style="height:80px"></div>

    @if ($dbError)
        <div style="max-width:1100px;margin:0 auto;padding:0 24px">
            <div class="card" style="padding:12px 20px;border-color:rgba(255,107,107,0.15);margin-bottom:16px">
                <span style="color:#ff6b6b;font-size:13px"><i class="fa-solid fa-triangle-exclamation"></i> Sin conexión a la base de datos</span>
                <span style="color:rgba(255,255,255,0.25);font-size:11px;margin-left:8px">{{ $dbError }}</span>
            </div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <div style="max-width:1100px;margin:40px auto 0;padding:0 24px">
        <div class="card" style="padding:20px;text-align:center">
            <span style="font-size:12px;color:rgba(255,255,255,0.25)">&copy; {{ date('Y') }} ChanchullApp &mdash; Plataforma de Inteligencia de Precios</span>
        </div>
    </div>

    <div style="height:40px"></div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script src="/js/app.js"></script>
</body>
</html>
