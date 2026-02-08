<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Catálogo de Filmes')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('movies.index') }}">
                🎬 MovieDB
            </a>
        </div>
    </nav>
    
    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>
    
    <footer class="bg-dark text-white py-3 mt-5">
        <div class="container text-center">
            <p class="mb-0">Catálogo de Filmes &copy; {{ date('Y') }}</p>
            <small>Dados fornecidos pela MoviesDatabase API</small>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>