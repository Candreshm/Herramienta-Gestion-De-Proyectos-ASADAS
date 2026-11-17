<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Gestión de Proyectos ASADAS')</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body>
    <header class="app-header">
        <div class="app-container app-header-content">
            <div>
                <h1 class="app-brand">
                    Gestión de Proyectos ASADAS
                </h1>
            </div>

            @auth
                <div class="user-info">
                    <span>{{ auth()->user()->name }}</span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button
                            type="submit"
                            class="btn btn-secondary"
                        >
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </header>

    <main class="app-container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>