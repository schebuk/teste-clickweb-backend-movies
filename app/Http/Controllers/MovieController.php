<?php

namespace App\Http\Controllers;

use App\Services\MoviesApiService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    protected $moviesService;

    public function __construct(MoviesApiService $moviesService)
    {
        $this->moviesService = $moviesService;
    }

    public function index(Request $request)
    {
        $page = (int) $request->get('page', 1);
        $data = $this->moviesService->getMovies($page, 25);

        return view('movies.index', [
            'movies' => $data['movies'],
            'current_page' => $data['current_page'],
            'total_pages' => $data['total_pages'],
            'next_page' => $data['next_page'],
            'total_entries' => $data['total_entries'],
            'is_mock_data' => $data['is_mock_data'],
        ]);
    }
}