<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $movie['titleText']['text'] ?? 'Detalhes do Filme' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .movie-poster {
            max-height: 500px;
            object-fit: cover;
        }
        .back-button {
            margin-bottom: 20px;
        }
        .movie-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
        }
        .rating-badge {
            font-size: 1.2rem;
            padding: 5px 15px;
        }
        .actor-card {
            transition: transform 0.3s;
        }
        .actor-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Botão voltar -->
        <a href="{{ route('movies.index') }}" class="btn btn-outline-secondary back-button">
            ← Voltar para Catálogo
        </a>
        
        <!-- Detalhes do Filme -->
        <div class="row">
            <!-- Poster -->
            <div class="col-md-4">
                @if(isset($movie['primaryImage']['url']))
                    <img src="{{ $movie['primaryImage']['url'] }}" 
                         class="img-fluid rounded movie-poster" 
                         alt="{{ $movie['titleText']['text'] }}">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" 
                         style="height: 500px; border-radius: 10px;">
                        <span class="text-muted">Sem imagem disponível</span>
                    </div>
                @endif
                
                <!-- Rating -->
                @if(isset($rating['averageRating']))
                    <div class="mt-3 text-center">
                        <h5>Avaliação:</h5>
                        <span class="badge bg-success rating-badge">
                            ⭐ {{ number_format($rating['averageRating'], 1) }}/10
                        </span>
                        <small class="text-muted d-block mt-1">
                            {{ number_format($rating['numVotes'] ?? 0) }} votos
                        </small>
                    </div>
                @endif
            </div>
            
            <!-- Informações -->
            <div class="col-md-8">
                <div class="movie-info">
                    <h1 class="mb-3">{{ $movie['titleText']['text'] ?? 'Título não disponível' }}</h1>
                    
                    @if(isset($movie['releaseYear']['year']))
                        <p><strong>Ano de Lançamento:</strong> {{ $movie['releaseYear']['year'] }}</p>
                    @endif
                    
                    @if(isset($movie['titleType']['text']))
                        <p><strong>Tipo:</strong> 
                            <span class="badge bg-info">
                                {{ $movie['titleType']['text'] }}
                            </span>
                        </p>
                    @endif
                    
                    @if(isset($movie['runtime']['seconds']))
                        @php
                            $minutes = floor($movie['runtime']['seconds'] / 60);
                            $hours = floor($minutes / 60);
                            $remainingMinutes = $minutes % 60;
                        @endphp
                        <p><strong>Duração:</strong> 
                            @if($hours > 0)
                                {{ $hours }}h {{ $remainingMinutes }}min
                            @else
                                {{ $minutes }}min
                            @endif
                        </p>
                    @endif
                    
                    @if(isset($movie['genres']['genres']) && count($movie['genres']['genres']) > 0)
                        <p><strong>Gêneros:</strong>
                            @foreach($movie['genres']['genres'] as $genre)
                                <span class="badge bg-secondary me-1">{{ $genre['text'] }}</span>
                            @endforeach
                        </p>
                    @endif
                    
                    @if(isset($movie['plot']['plotText']['plainText']))
                        <div class="mt-4">
                            <h5>Sinopse</h5>
                            <p class="lead">{{ $movie['plot']['plotText']['plainText'] }}</p>
                        </div>
                    @endif
                </div>
                
                <!-- Atores Principais -->
                @if(isset($actors['results']) && count($actors['results']) > 0)
                    <div class="mt-4">
                        <h4>Elenco Principal</h4>
                        <div class="row mt-3">
                            @foreach(array_slice($actors['results'], 0, 6) as $actor)
                                <div class="col-md-4 mb-3">
                                    <div class="card actor-card h-100">
                                        <div class="card-body text-center">
                                            <h6 class="card-title">{{ $actor['primaryName'] ?? 'Ator' }}</h6>
                                            @if(isset($actor['primaryProfession']))
                                                <p class="card-text text-muted">
                                                    <small>{{ $actor['primaryProfession'] }}</small>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>