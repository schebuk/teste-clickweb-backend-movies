<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class MoviesApiService
{
    protected $client;
    
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://moviesdatabase.p.rapidapi.com/',
            'headers' => [
                'X-RapidAPI-Key' => '08cc1ecc95msh01e8b332da87ea1p1784f5jsne5066ad8d8e1',
                'X-RapidAPI-Host' => 'moviesdatabase.p.rapidapi.com',
            ],
            'timeout' => 15,
            'verify' => false,
        ]);
    }
    
    public function getMovies($page = 1, $limit = 25)
    {
        try {
            $apiPage = ceil(($page * $limit) / 50);
            $offsetInApiPage = (($page - 1) * $limit) % 50;
            
            Log::info("Página {$page} nossa = API página {$apiPage}, offset {$offsetInApiPage}");
            
            $query = [
                'list' => 'top_boxoffice_200',
                'limit' => 50,
                'page' => $apiPage,
            ];
            
            $response = $this->client->get('titles', ['query' => $query]);
            $data = json_decode($response->getBody()->getContents(), true);
            
            if (empty($data['results'])) {
                throw new \Exception('API retornou vazio');
            }
            
            $ourMovies = array_slice($data['results'], $offsetInApiPage, $limit);
            
            if (count($ourMovies) < $limit && !empty($data['next'])) {
                $remaining = $limit - count($ourMovies);
                $additionalMovies = $this->getAdditionalMovies($apiPage + 1, $remaining);
                $ourMovies = array_merge($ourMovies, $additionalMovies);
            }
            
            $totalEntries = 200;
            $totalPages = ceil($totalEntries / $limit);
            
            Log::info("Página {$page}: " . count($ourMovies) . " filmes");
            
            return [
                'movies' => $ourMovies,
                'current_page' => $page,
                'total_pages' => $totalPages,
                'next_page' => $page < $totalPages ? $page + 1 : null,
                'total_entries' => $totalEntries,
                'is_mock_data' => false,
            ];
            
        } catch (\Exception $e) {
            Log::error('Erro: ' . $e->getMessage());
            
            return [
                'movies' => [],
                'current_page' => $page,
                'total_pages' => 1,
                'next_page' => null,
                'total_entries' => 0,
                'is_mock_data' => false,
            ];
        }
    }
    
    private function getAdditionalMovies($apiPage, $limit)
    {
        try {
            $query = [
                'list' => 'top_boxoffice_200',
                'limit' => $limit,
                'page' => $apiPage,
            ];
            
            $response = $this->client->get('titles', ['query' => $query]);
            $data = json_decode($response->getBody()->getContents(), true);
            
            return $data['results'] ?? [];
            
        } catch (\Exception $e) {
            Log::error('Erro adicional: ' . $e->getMessage());
            return [];
        }
    }
}