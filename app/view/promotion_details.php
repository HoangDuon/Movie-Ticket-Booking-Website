<body>
    <?php
        $promotionservices=new promotions_services();
        $promotion = $promotionservices->getPromotionbyID($promotion_id);
    ?>
    <div class="banner-slider">
        <div class="banner-container">
            <div class="banner active" data-bg="<?= $promotion['banner_url'] ?>">
            </div>
        </div>
    </div>

    <!-- Title Section -->
    <div class="title-section">
        <h2><?= $promotion['title'] ?></h2>
    </div>

    <!-- Content Section -->
    <div class="container"> 
        <div class="promotion-detail">
            <div class="promotion-card">
                <h2><?= $promotion['title'] ?></h2>
                <div class="promotion-content">
                    <p><?= $promotion['content'] ?></p>        
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../LTW/assets/js/promotion.js"></script>
</body>