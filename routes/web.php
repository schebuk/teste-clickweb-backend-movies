<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

Route::get('/', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');

Route::get('/debug-movies', function() {
    $service = new \App\Services\MoviesApiService();
    
    // Desativa cache temporariamente
    $data = $service->getMovies(1, 12);
    
    // Debug completo
    dd([
        'is_mock_data' => $data['is_mock_data'] ?? 'NOT SET',
        'movies_count' => count($data['movies'] ?? []),
        'first_movie' => $data['movies'][0]['titleText']['text'] ?? 'N/A',
        'first_movie_year' => $data['movies'][0]['releaseYear']['year'] ?? 'N/A',
        'total_entries' => $data['total_entries'] ?? 0,
        'current_page' => $data['current_page'] ?? 0,
        'total_pages' => $data['total_pages'] ?? 0,
        'api_response_sample' => isset($data['movies'][0]) ? [
            'id' => $data['movies'][0]['id'] ?? 'N/A',
            'has_image' => !empty($data['movies'][0]['primaryImage']['url']),
            'title_type' => $data['movies'][0]['titleType']['text'] ?? 'N/A',
        ] : 'No movies'
    ]);
});

Route::get('/test-direct-api', function() {
    $client = new \GuzzleHttp\Client([
        'verify' => false, // Desativa SSL
    ]);
    
    try {
        $response = $client->get('https://moviesdatabase.p.rapidapi.com/titles', [
            'query' => [
                'list' => 'top_boxoffice_200',
                'limit' => 12,
                'page' => 1,
                'info' => 'mini_info',
            ],
            'headers' => [
                'X-RapidAPI-Key' => '08cc1ecc95msh01e8b332da87ea1p1784f5jsne5066ad8d8e1',
                'X-RapidAPI-Host' => 'moviesdatabase.p.rapidapi.com',
            ]
        ]);
        
        $data = json_decode($response->getBody(), true);
        
        return response()->json([
            'success' => true,
            'status' => $response->getStatusCode(),
            'entries' => $data['entries'] ?? 0,
            'results_count' => count($data['results'] ?? []),
            'first_movie' => $data['results'][0]['titleText']['text'] ?? 'N/A',
            'first_movie_id' => $data['results'][0]['id'] ?? 'N/A',
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
});