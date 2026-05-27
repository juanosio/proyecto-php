<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'smartparse ocr')</title>
    <link rel="stylesheet" href="/css/tailwind.css">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body class="bg-gray-50 text-gray-900 font-sans">

    <div class="min-h-screen flex flex-col justify-between">

        <header class="bg-blue-600 text-white p-4 shadow-md">
            <span class="font-bold text-xl">smartparse retail</span>
        </header>

        <main class="flex-grow p-6">

            @if ($dbError)
                <div class="max-w-xl mx-auto mb-4 p-3 bg-yellow-50 border border-yellow-300 text-yellow-800 rounded text-sm">
                    no se pudo conectar a mysql: {{ $dbError }}<br>
                    el sistema funciona pero sin acceso a base de datos.
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="bg-gray-800 text-gray-400 text-center p-3 text-sm">
            &copy; 2026 - algoritmo de inteligencia de precios ocr
        </footer>

    </div>

    <script src="/js/app.js"></script>
</body>
</html>
