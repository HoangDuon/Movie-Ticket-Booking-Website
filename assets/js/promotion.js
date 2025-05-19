// Banner slider variables
let currentSlide = 0;
const banners = document.querySelectorAll('.banner');
const prevButton = document.querySelector('.banner-nav.prev');
const nextButton = document.querySelector('.banner-nav.next');

// Initialize banner backgrounds
function initBanners() {
    banners.forEach(banner => {
        const bgUrl = banner.getAttribute('data-bg');
        if (bgUrl) {
            // Áp dụng ảnh background với gradient overlay
            banner.style.backgroundImage = `linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url(${bgUrl})`;
        }
    });
}

// Show specific banner
function showBanner(index) {
    banners.forEach(banner => banner.classList.remove('active'));
    banners[index].classList.add('active');
    currentSlide = index;
}

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize banners
    initBanners();
    
    // Set up event listeners for navigation buttons
    prevButton.addEventListener('click', () => {
        changeBanner(-1);
        // Reset auto slide timer when manually navigating
        clearInterval(autoSlideInterval);
        autoSlideInterval = startAutoSlide();
    });
    
    nextButton.addEventListener('click', () => {
        changeBanner(1);
        // Reset auto slide timer when manually navigating
        clearInterval(autoSlideInterval);
        autoSlideInterval = startAutoSlide();
    });
    
    // Banner click to redirect
    banners.forEach(banner => {
        banner.addEventListener('click', function() {
            console.log('Banner clicked!');
            // Thêm hành động khi click vào banner ở đây
            // Ví dụ: window.location.href = 'chi-tiet-khuyen-mai.html';
        });
    });
    
    // Add hover effect for promotion card
    const promotionCard = document.querySelector('.promotion-card');
    if (promotionCard) {
        promotionCard.addEventListener('mouseenter', function() {
            this.style.borderColor = '#ff6b35';
        });
        
        promotionCard.addEventListener('mouseleave', function() {
            this.style.borderColor = '#333';
        });
    }
    
    // Add loading animation when page loads
    function addLoadingAnimation() {
        const card = document.querySelector('.promotion-card');
        if (card) {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        }
    }
    
    // Call loading animation
    addLoadingAnimation();
    
    // Optional: Add keyboard navigation for banners
    document.addEventListener('keydown', function(e) {
        // Left arrow key - previous banner
        if (e.key === 'ArrowLeft') {
            changeBanner(-1);
            clearInterval(autoSlideInterval);
            autoSlideInterval = startAutoSlide();
        }
        
        // Right arrow key - next banner
        if (e.key === 'ArrowRight') {
            changeBanner(1);
            clearInterval(autoSlideInterval);
            autoSlideInterval = startAutoSlide();
        }
    });
    
    // Start auto slide
    let autoSlideInterval = startAutoSlide();
});