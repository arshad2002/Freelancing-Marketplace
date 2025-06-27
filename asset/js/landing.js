/* ===================================
   FREEMARKET LANDING PAGE SCRIPTS
   Interactive & Smooth Animations
   =================================== */

document.addEventListener('DOMContentLoaded', function() {
    
    // ===== MOBILE MENU TOGGLE =====
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    
    if (mobileMenuToggle && navLinks) {
        mobileMenuToggle.addEventListener('click', function() {
            navLinks.classList.toggle('mobile-open');
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
        });
    }
    
    // ===== SMOOTH SCROLLING =====
    const smoothScrollLinks = document.querySelectorAll('a[href^="#"]');
    smoothScrollLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                const navHeight = document.querySelector('.landing-nav').offsetHeight;
                const targetPosition = targetElement.offsetTop - navHeight - 20;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // ===== NAVBAR SCROLL EFFECT =====
    const navbar = document.querySelector('.landing-nav');
    let lastScrollTop = 0;
    
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > 100) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
        
        // Hide/show navbar on scroll
        if (scrollTop > lastScrollTop && scrollTop > 200) {
            navbar.style.transform = 'translateY(-100%)';
        } else {
            navbar.style.transform = 'translateY(0)';
        }
        
        lastScrollTop = scrollTop;
    });
    
    // ===== INTERSECTION OBSERVER FOR ANIMATIONS =====
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);
    
    // Observe elements for animation
    const animateElements = document.querySelectorAll('.feature-card, .step, .stat-card, .floating-card');
    animateElements.forEach(el => {
        observer.observe(el);
    });
    
    // ===== FLOATING CARDS INTERACTION =====
    const floatingCards = document.querySelectorAll('.floating-card');
    floatingCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.05)';
            this.style.boxShadow = '0 20px 40px rgba(99, 102, 241, 0.3)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '0 8px 16px rgba(0, 0, 0, 0.4)';
        });
    });
    
    // ===== PARALLAX EFFECT =====
    const heroGraphic = document.querySelector('.hero-graphic');
    if (heroGraphic) {
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const parallax = scrolled * 0.5;
            heroGraphic.style.transform = `translate(-50%, calc(-50% + ${parallax}px))`;
        });
    }
    
    // ===== TYPEWRITER EFFECT FOR HERO TITLE =====
    const heroTitle = document.querySelector('.hero-title');
    if (heroTitle) {
        const text = heroTitle.innerHTML;
        heroTitle.innerHTML = '';
        let i = 0;
        
        function typeWriter() {
            if (i < text.length) {
                heroTitle.innerHTML += text.charAt(i);
                i++;
                setTimeout(typeWriter, 50);
            }
        }
        
        // Start typewriter effect after a short delay
        setTimeout(typeWriter, 500);
    }
    
    // ===== COUNTER ANIMATION FOR STATS =====
    const statNumbers = document.querySelectorAll('.stat-number');
    
    function animateCounter(element) {
        const target = element.textContent;
        const numericTarget = parseInt(target.replace(/[^\d]/g, ''));
        const suffix = target.replace(/[\d,]/g, '');
        let current = 0;
        const increment = numericTarget / 100;
        
        function updateCounter() {
            current += increment;
            if (current < numericTarget) {
                element.textContent = Math.floor(current).toLocaleString() + suffix;
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = target;
            }
        }
        
        updateCounter();
    }
    
    // Animate counters when they come into view
    const statsObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                entry.target.classList.add('animated');
                animateCounter(entry.target);
            }
        });
    }, { threshold: 0.5 });
    
    statNumbers.forEach(stat => {
        statsObserver.observe(stat);
    });
    
    // ===== BUTTON RIPPLE EFFECT =====
    const buttons = document.querySelectorAll('.btn-hero-primary, .btn-cta-primary, .btn-primary');
    
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
    
    // ===== LAZY LOADING FOR BACKGROUND IMAGES =====
    const lazyBackgrounds = document.querySelectorAll('.lazy-bg');
    
    const bgObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('loaded');
                bgObserver.unobserve(entry.target);
            }
        });
    });
    
    lazyBackgrounds.forEach(bg => {
        bgObserver.observe(bg);
    });
    
    // ===== CURSOR FOLLOW EFFECT =====
    const cursor = document.createElement('div');
    cursor.classList.add('custom-cursor');
    document.body.appendChild(cursor);
    
    document.addEventListener('mousemove', function(e) {
        cursor.style.left = e.clientX + 'px';
        cursor.style.top = e.clientY + 'px';
    });
    
    // Add hover effects for interactive elements
    const interactiveElements = document.querySelectorAll('a, button, .feature-card, .floating-card');
    
    interactiveElements.forEach(el => {
        el.addEventListener('mouseenter', function() {
            cursor.classList.add('cursor-hover');
        });
        
        el.addEventListener('mouseleave', function() {
            cursor.classList.remove('cursor-hover');
        });
    });
    
    // ===== THEME PARTICLES ANIMATION =====
    function createParticle() {
        const particle = document.createElement('div');
        particle.classList.add('particle');
        
        const size = Math.random() * 4 + 2;
        const x = Math.random() * window.innerWidth;
        const animationDuration = Math.random() * 20 + 10;
        
        particle.style.width = size + 'px';
        particle.style.height = size + 'px';
        particle.style.left = x + 'px';
        particle.style.animationDuration = animationDuration + 's';
        
        document.body.appendChild(particle);
        
        setTimeout(() => {
            particle.remove();
        }, animationDuration * 1000);
    }
    
    // Create particles periodically
    setInterval(createParticle, 2000);
    
    // ===== PERFORMANCE OPTIMIZATION =====
    let ticking = false;
    
    function updateOnScroll() {
        // Batch scroll-based updates here
        ticking = false;
    }
    
    window.addEventListener('scroll', function() {
        if (!ticking) {
            requestAnimationFrame(updateOnScroll);
            ticking = true;
        }
    });
});

// ===== CSS ANIMATIONS (Injected via JS) =====
const style = document.createElement('style');
style.textContent = `
    .animate-in {
        animation: slideInUp 0.6s ease-out forwards;
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        pointer-events: none;
        animation: rippleAnimation 0.6s ease-out;
    }
    
    @keyframes rippleAnimation {
        to {
            transform: scale(2);
            opacity: 0;
        }
    }
    
    .custom-cursor {
        position: fixed;
        width: 20px;
        height: 20px;
        background: rgba(99, 102, 241, 0.5);
        border-radius: 50%;
        pointer-events: none;
        z-index: 9999;
        transition: transform 0.1s ease;
        mix-blend-mode: difference;
    }
    
    .cursor-hover {
        transform: scale(1.5);
        background: rgba(99, 102, 241, 0.8);
    }
    
    .particle {
        position: fixed;
        background: rgba(99, 102, 241, 0.3);
        border-radius: 50%;
        pointer-events: none;
        z-index: 1;
        animation: particleFloat linear forwards;
    }
    
    @keyframes particleFloat {
        from {
            top: 100vh;
            opacity: 1;
        }
        to {
            top: -10px;
            opacity: 0;
        }
    }
    
    .landing-nav.scrolled {
        background: rgba(10, 10, 15, 0.98);
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.3);
    }
    
    @media (max-width: 768px) {
        .nav-links.mobile-open {
            display: flex;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: rgba(10, 10, 15, 0.98);
            backdrop-filter: blur(20px);
            flex-direction: column;
            padding: 2rem;
            border-top: 1px solid var(--border-primary);
        }
        
        .custom-cursor {
            display: none;
        }
    }
`;
document.head.appendChild(style);
