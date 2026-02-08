// No seu MoviesController
public function index(Request $request)
{
    $page = $request->get('page', 1);
    $limit = 12;
    
    $service = new MoviesApiService();
    $data = $service->getMovies($page, $limit);
    
    // Log para debug
    \Log::info('Controller recebeu dados', [
        'is_mock' => $data['is_mock_data'] ?? true,
        'movies_count' => count($data['movies'] ?? []),
        'page' => $data['current_page'] ?? 1
    ]);
    
    return view('movies.index', [
        'movies' => $data['movies'] ?? [],
        'current_page' => $data['current_page'] ?? 1,
        'total_pages' => $data['total_pages'] ?? 1,
        'next_page' => $data['next_page'] ?? null,
        'total_entries' => $data['total_entries'] ?? 0,
        'is_mock_data' => $data['is_mock_data'] ?? true,
    ]);
}