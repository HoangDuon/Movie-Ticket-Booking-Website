// script.js - JavaScript cho trang khuyến mãi

// Banner slider variables
let currentSlide = 0;
const banners = document.querySelectorAll('.banner');

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

// Change banner (previous/next)
function changeBanner(direction) {
    currentSlide += direction;
    
    if (currentSlide >= banners.length) {
        currentSlide = 0;
    } else if (currentSlide < 0) {
        currentSlide = banners.length - 1;
    }
    
    showBanner(currentSlide);
}

// Auto slide functionality
function autoSlide() {
    changeBanner(1);
}

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    initBanners();

    setInterval(autoSlide, 3000); // Change every 5 seconds
    
    // Banner click to redirect
    banners.forEach(banner => {
        banner.addEventListener('click', function() {
            console.log('Banner clicked!');
        });
    });
    
    // Add click event for all promotion buttons
    const promoButtons = document.querySelectorAll('.promo-button');
    promoButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Get the promotion title from the parent card
            const card = this.closest('.promotion-card');
            const title = card.querySelector('h3').textContent;
            
            // Show alert with promotion info
            alert(`Bạn đã chọn: ${title}\n\nChức năng đặt vé sẽ được cập nhật sớm!`);
            
            // Optional: Add animation effect
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });
    
    // Add hover effect for promotion cards
    const promotionCards = document.querySelectorAll('.promotion-card');
    promotionCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.borderColor = '#ff6b35';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.borderColor = '#333';
        });
    });
    
    // Add loading animation when page loads
    function addLoadingAnimation() {
        const cards = document.querySelectorAll('.promotion-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100 * index);
        });
    }
    
    // Call loading animation
    addLoadingAnimation();
    
    // Smooth scroll for internal links (nếu có)
    function smoothScroll(target) {
        const element = document.querySelector(target);
        if (element) {
            element.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }
    
    // Optional: Add keyboard navigation for banners
    document.addEventListener('keydown', function(e) {
        // Left arrow key - previous banner
        if (e.key === 'ArrowLeft') {
            changeBanner(-1);
        }
        
        // Right arrow key - next banner
        if (e.key === 'ArrowRight') {
            changeBanner(1);
        }
    });
    
    // Add intersection observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    }, observerOptions);
    
    // Observe all promotion cards
    promotionCards.forEach(card => {
        observer.observe(card);
    });
});

// Function to format price (nếu cần thiết)
function formatPrice(price) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).format(price);
}

// Export functions nếu cần sử dụng ở file khác
// export { formatPrice, smoothScroll, changeBanner };