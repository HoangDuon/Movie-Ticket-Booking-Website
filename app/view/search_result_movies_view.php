<div class="container mt-4 mb-5 search-view">
    <h2 class="mb-3">Kết quả tìm kiếm phim cho: "<?php echo htmlspecialchars($search_query ?? ''); ?>"</h2>
    <hr class="mb-4">

    <?php if (empty($searchResults)): ?>
        <div class="alert alert-info" role="alert">
            Không tìm thấy bộ phim nào phù hợp với từ khóa của bạn.
        </div>
    <?php else: ?>
        <p class="mb-3">Tìm thấy <?php echo count($searchResults); ?> kết quả.</p>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php foreach ($searchResults as $film): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm movie-search-result-card">
                        <a href="index.php?page=movie-details&id=<?php echo htmlspecialchars($film['movie_id']); ?>" class="text-decoration-none">
                            <?php if (!empty($film['poster_url'])): ?>
                                <img src="<?php echo htmlspecialchars($film['poster_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($film['title']); ?>">
                            <?php else: ?>
                                <div class="card-img-top-placeholder d-flex align-items-center justify-content-center bg-secondary text-white">
                                    <i class="fa-solid fa-film fa-3x"></i>
                                    <span class="ms-2">Không có ảnh</span>
                                </div>
                            <?php endif; ?>
                        </a>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title movie-title-search">
                                <a href="index.php?page=movie-details&id=<?php echo htmlspecialchars($film['movie_id']); ?>" class="text-decoration-none stretched-link">
                                    <?php echo htmlspecialchars($film['title']); ?>
                                </a>
                            </h5>
                            <p class="card-text small text-muted mb-2 card-search-mota">
                                <strong>Thể loại:</strong> <?php echo htmlspecialchars($film['genre'] ?? 'N/A'); ?><br>
                                <strong>Thời lượng:</strong> <?php echo htmlspecialchars($film['duration'] ?? 'N/A'); ?> phút<br>
                                <?php if(!empty($film['release_date'])): ?>
                                <strong>Ngày chiếu:</strong> 
                                <?php 
                                    try {
                                        $releaseDate = new DateTime($film['release_date']);
                                        echo $releaseDate->format('d/m/Y');
                                    } catch (Exception $e) {
                                        echo htmlspecialchars($film['release_date']);
                                    }
                                ?>
                                <br>
                                <?php endif; ?>
                            </p>
                            <p class="card-text small text-muted flex-grow-1 movie-description-search" style="display: none">
                                <?php
                                    $description = strip_tags($film['description'] ?? ''); // Loại bỏ HTML tags cho mô tả ngắn
                                    if (mb_strlen($description, 'UTF-8') > 80) {
                                        echo htmlspecialchars(mb_substr($description, 0, 80, 'UTF-8')) . "...";
                                    } else {
                                        echo htmlspecialchars($description);
                                    }
                                ?>
                            </p>
                            <a href="index.php?page=movie-details&id=<?php echo htmlspecialchars($film['movie_id']); ?>" class="btn btn-sm btn-primary mt-auto align-self-start">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>