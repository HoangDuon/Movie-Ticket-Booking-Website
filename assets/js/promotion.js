let currentSlide = 0;
const banners = document.querySelectorAll('.banner');
const prevButton = document.querySelector('.banner-nav.prev');
const nextButton = document.querySelector('.banner-nav.next');

function initBanners() {
    banners.forEach(banner => {
        const bgUrl = banner.getAttribute('data-bg');
        if (bgUrl) {
            banner.style.backgroundImage = `linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url(${bgUrl})`;
        }
    });
}

function showBanner(index) {
    banners.forEach(banner => banner.classList.remove('active'));
    banners[index].classList.add('active');
    currentSlide = index;
}

document.addEventListener('DOMContentLoaded', function() {
    initBanners();
    
    prevButton.addEventListener('click', () => {
        changeBanner(-1);
        clearInterval(autoSlideInterval);
        autoSlideInterval = startAutoSlide();
    });
    
    nextButton.addEventListener('click', () => {
        changeBanner(1);
        clearInterval(autoSlideInterval);
        autoSlideInterval = startAutoSlide();
    });
    
    banners.forEach(banner => {
        banner.addEventListener('click', function() {
            console.log('Banner clicked!');
        });
    });
    
    const promotionCard = document.querySelector('.promotion-card');
    if (promotionCard) {
        promotionCard.addEventListener('mouseenter', function() {
            this.style.borderColor = '#ff6b35';
        });
        
        promotionCard.addEventListener('mouseleave', function() {
            this.style.borderColor = '#333';
        });
    }
    
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
    
    addLoadingAnimation();
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            changeBanner(-1);
            clearInterval(autoSlideInterval);
            autoSlideInterval = startAutoSlide();
        }
        
        if (e.key === 'ArrowRight') {
            changeBanner(1);
            clearInterval(autoSlideInterval);
            autoSlideInterval = startAutoSlide();
        }
    });
    
    let autoSlideInterval = startAutoSlide();
});