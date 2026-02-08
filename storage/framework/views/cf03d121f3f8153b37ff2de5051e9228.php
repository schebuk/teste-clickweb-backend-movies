<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmes - Top Box Office</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        .movie-card {
            transition: transform 0.2s;
            height: 100%;
        }
        .movie-card:hover {
            transform: translateY(-3px);
        }
        .movie-poster {
            height: 320px;
            object-fit: cover;
            width: 100%;
        }
        .no-poster {
            height: 320px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
        }
        .card-title {
            font-size: 0.95rem;
            height: 40px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        .pagination .page-link {
            padding: 0.375rem 0.75rem;
        }
    </style>
</head>
<body>
    <div class="container py-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h4 mb-0">🎬 Top Filmes</h1>
            <div>
                <span class="badge bg-secondary"><?php echo e($total_entries); ?> filmes</span>
            </div>
        </div>
        
        <?php if(count($movies) > 0): ?>
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-2">
                <?php $__currentLoopData = $movies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col">
                        <div class="card movie-card border-0 shadow-sm h-100">
                            <?php if(!empty($movie['primaryImage']['url'])): ?>
                                <img src="<?php echo e($movie['primaryImage']['url']); ?>" 
                                     class="card-img-top movie-poster" 
                                     alt="<?php echo e($movie['titleText']['text'] ?? ''); ?>"
                                     loading="lazy"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="no-poster" style="display: none;">
                                    <small><?php echo e($movie['titleText']['text'] ?? ''); ?></small>
                                </div>
                            <?php else: ?>
                                <div class="no-poster">
                                    <small><?php echo e($movie['titleText']['text'] ?? 'Sem imagem'); ?></small>
                                </div>
                            <?php endif; ?>
                            
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1">
                                    <?php echo e($movie['titleText']['text'] ?? 'Sem título'); ?>

                                </h6>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <?php if(isset($movie['releaseYear']['year'])): ?>
                                        <small class="text-muted">
                                            <?php echo e($movie['releaseYear']['year']); ?>

                                        </small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <?php if($total_pages > 1): ?>
                <nav class="mt-3">
                    <ul class="pagination justify-content-center mb-0">
                        <?php if($current_page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo e($current_page - 1); ?>">←</a>
                            </li>
                        <?php endif; ?>
                        
                        <?php for($i = 1; $i <= $total_pages; $i++): ?>
                            <?php if($i == 1 || $i == $total_pages || ($i >= $current_page - 1 && $i <= $current_page + 1)): ?>
                                <li class="page-item <?php echo e($i == $current_page ? 'active' : ''); ?>">
                                    <a class="page-link" href="?page=<?php echo e($i); ?>"><?php echo e($i); ?></a>
                                </li>
                            <?php elseif($i == $current_page - 2 || $i == $current_page + 2): ?>
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            <?php endif; ?>
                        <?php endfor; ?>
                        
                        <?php if($current_page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo e($current_page + 1); ?>">→</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>
            
        <?php else: ?>
            <div class="text-center py-4">
                <p class="text-muted mb-0">Nenhum filme encontrado.</p>
            </div>
        <?php endif; ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH F:\laragon\www\teste-clickweb\backend2\resources\views/movies/index.blade.php ENDPATH**/ ?>