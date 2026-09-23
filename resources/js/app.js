import './bootstrap';
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import { initQuillEditor } from './quill-editor';
import AOS from 'aos';
import 'aos/dist/aos.css';
import { Chart, registerables } from 'chart.js';

// Register Chart.js components
Chart.register(...registerables);

// Register Alpine.js plugins
Alpine.plugin(collapse);

// Make Quill editor available globally
window.initQuillEditor = initQuillEditor;

// Make Chart.js available globally
window.Chart = Chart;

// Fix Leaflet default marker icons
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon-2x.png',
    iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
});

// Make Leaflet available globally for inline scripts
window.L = L;

// Make GSAP available globally for inline scripts
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;
gsap.registerPlugin(ScrollTrigger);

// Initialize AOS
AOS.init({
    duration: 800,
    easing: 'ease-out',
    once: true,
    offset: 50,
    disable: 'mobile'
});

// Alpine.js Store for global state management
Alpine.store('sidebar', {
    open: document.documentElement.dataset.sidebarOpen === 'true',
    mobileOpen: false,
    
    toggle() {
        if (window.innerWidth >= 1024) {
            this.open = !this.open;
            localStorage.setItem('sidebarOpen', this.open);
            document.documentElement.dataset.sidebarOpen = this.open;
            document.documentElement.style.setProperty('--sidebar-initial-margin', this.open ? '15rem' : '4rem');
        } else {
            this.mobileOpen = !this.mobileOpen;
        }
    },
    
    closeMobile() {
        this.mobileOpen = false;
    },
    
    init() {
        // State already read from inline script, just ensure sync
        const saved = localStorage.getItem('sidebarOpen');
        if (saved !== null) {
            this.open = saved === 'true';
        } else if (window.innerWidth >= 1024) {
            this.open = true;
        }
        
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                this.mobileOpen = false;
            }
        });
    }
});

// Dark mode store
Alpine.store('darkMode', {
    on: document.documentElement.classList.contains('dark'),
    
    init() {
        // State already applied from inline script, just sync
        this.on = document.documentElement.classList.contains('dark');
    },
    
    toggle() {
        this.on = !this.on;
        localStorage.setItem('darkMode', this.on);
        this.updateClass();
    },
    
    updateClass() {
        if (this.on) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
});

window.Alpine = Alpine;
Alpine.start();

/* ==========================================================================
   GSAP SCROLL ANIMATIONS - More powerful than AOS
   ========================================================================== */

// Initialize GSAP Scroll Animations when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    
    // =========================================================================
    // GSAP SCROLL TRIGGER ANIMATIONS
    // =========================================================================
    
    // Animation configurations
    const animationConfig = {
        duration: 1,
        ease: 'power3.out',
        stagger: 0.15
    };

    // Fade Up Animation
    gsap.utils.toArray('[data-gsap="fade-up"]').forEach(element => {
        gsap.from(element, {
            scrollTrigger: {
                trigger: element,
                start: 'top 85%',
                toggleActions: 'play none none none'
            },
            y: 60,
            opacity: 0,
            duration: animationConfig.duration,
            ease: animationConfig.ease
        });
    });

    // Fade Down Animation
    gsap.utils.toArray('[data-gsap="fade-down"]').forEach(element => {
        gsap.from(element, {
            scrollTrigger: {
                trigger: element,
                start: 'top 85%',
                toggleActions: 'play none none none'
            },
            y: -60,
            opacity: 0,
            duration: animationConfig.duration,
            ease: animationConfig.ease
        });
    });

    // Fade Left Animation
    gsap.utils.toArray('[data-gsap="fade-left"]').forEach(element => {
        gsap.from(element, {
            scrollTrigger: {
                trigger: element,
                start: 'top 85%',
                toggleActions: 'play none none none'
            },
            x: 80,
            opacity: 0,
            duration: animationConfig.duration,
            ease: animationConfig.ease
        });
    });

    // Fade Right Animation
    gsap.utils.toArray('[data-gsap="fade-right"]').forEach(element => {
        gsap.from(element, {
            scrollTrigger: {
                trigger: element,
                start: 'top 85%',
                toggleActions: 'play none none none'
            },
            x: -80,
            opacity: 0,
            duration: animationConfig.duration,
            ease: animationConfig.ease
        });
    });

    // Scale Up Animation
    gsap.utils.toArray('[data-gsap="scale-up"]').forEach(element => {
        gsap.from(element, {
            scrollTrigger: {
                trigger: element,
                start: 'top 85%',
                toggleActions: 'play none none none'
            },
            scale: 0.8,
            opacity: 0,
            duration: animationConfig.duration,
            ease: 'back.out(1.7)'
        });
    });

    // Zoom In Animation
    gsap.utils.toArray('[data-gsap="zoom-in"]').forEach(element => {
        gsap.from(element, {
            scrollTrigger: {
                trigger: element,
                start: 'top 85%',
                toggleActions: 'play none none none'
            },
            scale: 0.5,
            opacity: 0,
            duration: animationConfig.duration,
            ease: 'power2.out'
        });
    });

    // Flip Left Animation
    gsap.utils.toArray('[data-gsap="flip-left"]').forEach(element => {
        gsap.from(element, {
            scrollTrigger: {
                trigger: element,
                start: 'top 85%',
                toggleActions: 'play none none none'
            },
            rotateY: -90,
            opacity: 0,
            duration: animationConfig.duration * 1.2,
            ease: 'power3.out',
            transformPerspective: 1000
        });
    });

    // Flip Right Animation
    gsap.utils.toArray('[data-gsap="flip-right"]').forEach(element => {
        gsap.from(element, {
            scrollTrigger: {
                trigger: element,
                start: 'top 85%',
                toggleActions: 'play none none none'
            },
            rotateY: 90,
            opacity: 0,
            duration: animationConfig.duration * 1.2,
            ease: 'power3.out',
            transformPerspective: 1000
        });
    });

    // Flip Up Animation
    gsap.utils.toArray('[data-gsap="flip-up"]').forEach(element => {
        gsap.from(element, {
            scrollTrigger: {
                trigger: element,
                start: 'top 85%',
                toggleActions: 'play none none none'
            },
            rotateX: 90,
            opacity: 0,
            duration: animationConfig.duration * 1.2,
            ease: 'power3.out',
            transformPerspective: 1000
        });
    });

    // Rotate In Animation
    gsap.utils.toArray('[data-gsap="rotate-in"]').forEach(element => {
        gsap.from(element, {
            scrollTrigger: {
                trigger: element,
                start: 'top 85%',
                toggleActions: 'play none none none'
            },
            rotation: -180,
            scale: 0.5,
            opacity: 0,
            duration: animationConfig.duration,
            ease: 'back.out(1.7)'
        });
    });

    // Blur In Animation
    gsap.utils.toArray('[data-gsap="blur-in"]').forEach(element => {
        gsap.from(element, {
            scrollTrigger: {
                trigger: element,
                start: 'top 85%',
                toggleActions: 'play none none none'
            },
            filter: 'blur(20px)',
            opacity: 0,
            duration: animationConfig.duration,
            ease: 'power2.out'
        });
    });

    // Slide Rotate Animation
    gsap.utils.toArray('[data-gsap="slide-rotate"]').forEach(element => {
        gsap.from(element, {
            scrollTrigger: {
                trigger: element,
                start: 'top 85%',
                toggleActions: 'play none none none'
            },
            x: -100,
            rotation: -15,
            opacity: 0,
            duration: animationConfig.duration,
            ease: 'power3.out'
        });
    });

    // =========================================================================
    // PROFESSIONAL MODERN ANIMATIONS - Smooth & Eye-catching
    // =========================================================================

    // Reveal Up - Elegant entrance with subtle movement
    gsap.utils.toArray('[data-gsap="reveal-up"]').forEach(element => {
        gsap.from(element, {
            scrollTrigger: {
                trigger: element,
                start: 'top 90%',
                toggleActions: 'play none none none'
            },
            y: 40,
            opacity: 0,
            duration: 1.2,
            ease: 'power4.out'
        });
    });

    // Smooth Scale - Subtle professional scale entrance
    gsap.utils.toArray('[data-gsap="smooth-scale"]').forEach(element => {
        gsap.from(element, {
            scrollTrigger: {
                trigger: element,
                start: 'top 90%',
                toggleActions: 'play none none none'
            },
            scale: 0.95,
            opacity: 0,
            duration: 1.4,
            ease: 'power3.out'
        });
    });

    // Float In - Elegant floating entrance
    gsap.utils.toArray('[data-gsap="float-in"]').forEach(element => {
        gsap.from(element, {
            scrollTrigger: {
                trigger: element,
                start: 'top 90%',
                toggleActions: 'play none none none'
            },
            y: 30,
            opacity: 0,
            duration: 1.5,
            ease: 'power2.out'
        });
    });

    // Glow Reveal - Modern glow effect with fade
    gsap.utils.toArray('[data-gsap="glow-reveal"]').forEach(element => {
        gsap.from(element, {
            scrollTrigger: {
                trigger: element,
                start: 'top 85%',
                toggleActions: 'play none none none'
            },
            y: 20,
            opacity: 0,
            filter: 'blur(8px)',
            duration: 1.2,
            ease: 'power3.out'
        });
    });

    // =========================================================================
    // STAGGER ANIMATIONS FOR LISTS/GRIDS
    // =========================================================================

    // Stagger Fade Up - for grid items
    gsap.utils.toArray('[data-gsap-stagger="fade-up"]').forEach(container => {
        const items = container.querySelectorAll('[data-gsap-item]');
        if (items.length > 0) {
            gsap.from(items, {
                scrollTrigger: {
                    trigger: container,
                    start: 'top 80%',
                    toggleActions: 'play none none none'
                },
                y: 80,
                opacity: 0,
                duration: animationConfig.duration,
                ease: animationConfig.ease,
                stagger: animationConfig.stagger,
                immediateRender: false
            });
        }
    });

    // Stagger Scale - for cards
    gsap.utils.toArray('[data-gsap-stagger="scale"]').forEach(container => {
        const items = container.querySelectorAll('[data-gsap-item]');
        if (items.length > 0) {
            gsap.from(items, {
                scrollTrigger: {
                    trigger: container,
                    start: 'top 80%',
                    toggleActions: 'play none none none'
                },
                scale: 0.8,
                opacity: 0,
                duration: animationConfig.duration,
                ease: 'back.out(1.4)',
                stagger: animationConfig.stagger,
                immediateRender: false
            });
        }
    });

    // Stagger Fade Left - for timeline items
    gsap.utils.toArray('[data-gsap-stagger="fade-left"]').forEach(container => {
        const items = container.querySelectorAll('[data-gsap-item]');
        if (items.length > 0) {
            gsap.from(items, {
                scrollTrigger: {
                    trigger: container,
                    start: 'top 80%',
                    toggleActions: 'play none none none'
                },
                x: 80,
                opacity: 0,
                duration: animationConfig.duration,
                ease: animationConfig.ease,
                stagger: animationConfig.stagger,
                immediateRender: false
            });
        }
    });

    // Stagger Fade Right - for timeline items
    gsap.utils.toArray('[data-gsap-stagger="fade-right"]').forEach(container => {
        const items = container.querySelectorAll('[data-gsap-item]');
        if (items.length > 0) {
            gsap.from(items, {
                scrollTrigger: {
                    trigger: container,
                    start: 'top 80%',
                    toggleActions: 'play none none none'
                },
                x: -80,
                opacity: 0,
                duration: animationConfig.duration,
                ease: animationConfig.ease,
                stagger: animationConfig.stagger,
                immediateRender: false
            });
        }
    });

    // Stagger Zoom - for gallery items
    gsap.utils.toArray('[data-gsap-stagger="zoom"]').forEach(container => {
        const items = container.querySelectorAll('[data-gsap-item]');
        if (items.length > 0) {
            gsap.from(items, {
                scrollTrigger: {
                    trigger: container,
                    start: 'top 80%',
                    toggleActions: 'play none none none'
                },
                scale: 0,
                opacity: 0,
                duration: animationConfig.duration * 0.8,
                ease: 'back.out(1.7)',
                stagger: {
                    each: 0.1,
                    from: 'random'
                },
                immediateRender: false
            });
        }
    });

    // Stagger Flip - for certificate cards
    gsap.utils.toArray('[data-gsap-stagger="flip"]').forEach(container => {
        const items = container.querySelectorAll('[data-gsap-item]');
        if (items.length > 0) {
            gsap.from(items, {
                scrollTrigger: {
                    trigger: container,
                    start: 'top 80%',
                    toggleActions: 'play none none none'
                },
                rotateY: -60,
                opacity: 0,
                duration: animationConfig.duration * 1.2,
                ease: 'power3.out',
                transformPerspective: 1000,
                stagger: animationConfig.stagger,
                immediateRender: false
            });
        }
    });

    // =========================================================================
    // PROFESSIONAL STAGGER ANIMATIONS - Modern & Smooth
    // =========================================================================

    // Stagger Cascade - Elegant cascading entrance for cards
    gsap.utils.toArray('[data-gsap-stagger="cascade"]').forEach(container => {
        const items = container.querySelectorAll('[data-gsap-item]');
        if (items.length > 0) {
            gsap.from(items, {
                scrollTrigger: {
                    trigger: container,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                },
                y: 60,
                opacity: 0,
                duration: 1.2,
                ease: 'power3.out',
                stagger: {
                    each: 0.12,
                    from: 'start'
                },
                immediateRender: false
            });
        }
    });

    // Stagger Float - Smooth floating entrance
    gsap.utils.toArray('[data-gsap-stagger="float"]').forEach(container => {
        const items = container.querySelectorAll('[data-gsap-item]');
        if (items.length > 0) {
            gsap.from(items, {
                scrollTrigger: {
                    trigger: container,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                },
                y: 40,
                opacity: 0,
                scale: 0.98,
                duration: 1.4,
                ease: 'power2.out',
                stagger: {
                    each: 0.1,
                    from: 'center'
                },
                immediateRender: false
            });
        }
    });

    // Stagger Rise - Professional rising effect
    gsap.utils.toArray('[data-gsap-stagger="rise"]').forEach(container => {
        const items = container.querySelectorAll('[data-gsap-item]');
        if (items.length > 0) {
            gsap.from(items, {
                scrollTrigger: {
                    trigger: container,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                },
                y: 80,
                opacity: 0,
                duration: 1,
                ease: 'power4.out',
                stagger: {
                    each: 0.08,
                    from: 'edges'
                },
                immediateRender: false
            });
        }
    });

    // Stagger Pulse - Modern subtle pulse entrance
    gsap.utils.toArray('[data-gsap-stagger="pulse"]').forEach(container => {
        const items = container.querySelectorAll('[data-gsap-item]');
        if (items.length > 0) {
            gsap.from(items, {
                scrollTrigger: {
                    trigger: container,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                },
                scale: 0.9,
                opacity: 0,
                duration: 1.2,
                ease: 'elastic.out(1, 0.5)',
                stagger: {
                    each: 0.15,
                    from: 'start'
                },
                immediateRender: false
            });
        }
    });

    // =========================================================================
    // SPECIAL TEXT ANIMATIONS
    // =========================================================================

    // Split Text Animation - Character by character
    gsap.utils.toArray('[data-gsap="text-reveal"]').forEach(element => {
        const text = element.textContent;
        element.innerHTML = text.split('').map(char => 
            char === ' ' ? '<span class="inline-block">&nbsp;</span>' : `<span class="inline-block">${char}</span>`
        ).join('');
        
        gsap.from(element.querySelectorAll('span'), {
            scrollTrigger: {
                trigger: element,
                start: 'top 85%',
                toggleActions: 'play none none none'
            },
            y: 50,
            opacity: 0,
            duration: 0.5,
            ease: 'back.out(1.7)',
            stagger: 0.02
        });
    });

    // Line Reveal Animation
    gsap.utils.toArray('[data-gsap="line-reveal"]').forEach(element => {
        gsap.from(element, {
            scrollTrigger: {
                trigger: element,
                start: 'top 85%',
                toggleActions: 'play none none none'
            },
            clipPath: 'inset(0 100% 0 0)',
            opacity: 0,
            duration: animationConfig.duration * 1.5,
            ease: 'power4.out'
        });
    });

    // =========================================================================
    // PARALLAX SCROLL EFFECTS (GSAP Enhanced)
    // =========================================================================

    gsap.utils.toArray('[data-gsap-parallax]').forEach(element => {
        const speed = parseFloat(element.dataset.gsapParallax) || 0.3;
        gsap.to(element, {
            scrollTrigger: {
                trigger: element,
                start: 'top bottom',
                end: 'bottom top',
                scrub: 1
            },
            y: (i, el) => -ScrollTrigger.maxScroll(window) * speed * 0.1,
            ease: 'none'
        });
    });

    // =========================================================================
    // BATCH ANIMATIONS FOR DYNAMIC CONTENT (Alpine.js compatibility)
    // =========================================================================

    // Create batch animation for Alpine.js rendered content
    ScrollTrigger.batch('[data-gsap-batch]', {
        onEnter: batch => {
            gsap.from(batch, {
                opacity: 0,
                y: 50,
                stagger: 0.1,
                duration: 0.8,
                ease: 'power3.out'
            });
        },
        start: 'top 85%'
    });

    // Refresh ScrollTrigger after Alpine.js renders
    document.addEventListener('alpine:initialized', () => {
        setTimeout(() => {
            ScrollTrigger.refresh();
        }, 100);
    });

    // Mutation Observer for dynamic content (Alpine x-for loops)
    const observerConfig = { childList: true, subtree: true };
    const mutationObserver = new MutationObserver((mutations) => {
        let shouldRefresh = false;
        mutations.forEach(mutation => {
            if (mutation.addedNodes.length > 0) {
                mutation.addedNodes.forEach(node => {
                    if (node.nodeType === 1 && (
                        node.hasAttribute('data-gsap-item') || 
                        node.querySelector('[data-gsap-item]')
                    )) {
                        shouldRefresh = true;
                    }
                });
            }
        });
        if (shouldRefresh) {
            ScrollTrigger.refresh();
        }
    });

    // Observe containers with dynamic content
    document.querySelectorAll('[data-gsap-stagger]').forEach(container => {
        mutationObserver.observe(container, observerConfig);
    });

});

/* ==========================================================================
   FRONTEND / LANDING PAGE SCRIPTS
   ========================================================================== */

// Initialize frontend features when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    
    // =========================================================================
    // SCROLL ANIMATIONS - Intersection Observer
    // =========================================================================
    const scrollAnimateElements = document.querySelectorAll('.scroll-animate');
    
    if (scrollAnimateElements.length > 0) {
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const scrollObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    // Add the animation class based on data attribute
                    const animation = entry.target.dataset.animation;
                    if (animation) {
                        entry.target.classList.add(animation);
                    }
                }
            });
        }, observerOptions);

        // Observe all elements with scroll-animate class
        scrollAnimateElements.forEach(el => scrollObserver.observe(el));
    }

    // =========================================================================
    // PARALLAX EFFECT
    // =========================================================================
    const parallaxElements = document.querySelectorAll('[data-parallax]');
    const globeScrollElements = document.querySelectorAll('.globe-scroll');
    
    if (parallaxElements.length > 0 || globeScrollElements.length > 0) {
        let ticking = false;
        
        window.addEventListener('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    const scrolled = window.pageYOffset;
                    
                    // Parallax elements - move based on scroll
                    parallaxElements.forEach(el => {
                        const speed = el.dataset.parallax || 0.5;
                        el.style.transform = `translateY(${scrolled * speed}px)`;
                    });
                    
                    // Globe rotation based on scroll
                    globeScrollElements.forEach(el => {
                        const rotation = scrolled * 0.1;
                        el.style.transform = `rotate(${rotation}deg)`;
                    });
                    
                    ticking = false;
                });
                ticking = true;
            }
        });
    }

    // =========================================================================
    // COUNTER ANIMATION
    // =========================================================================
    const counters = document.querySelectorAll('[data-counter]');
    
    if (counters.length > 0) {
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = entry.target;
                    const targetValue = parseInt(target.dataset.counter);
                    const duration = 2000; // 2 seconds
                    const step = targetValue / (duration / 16); // 60fps
                    let current = 0;
                    
                    const updateCounter = () => {
                        current += step;
                        if (current < targetValue) {
                            target.textContent = Math.floor(current).toLocaleString();
                            requestAnimationFrame(updateCounter);
                        } else {
                            target.textContent = targetValue.toLocaleString();
                        }
                    };
                    
                    updateCounter();
                    counterObserver.unobserve(target);
                }
            });
        }, { threshold: 0.5 });
        
        counters.forEach(counter => counterObserver.observe(counter));
    }

    // =========================================================================
    // INTERACTIVE DOT PATTERN (About Section)
    // =========================================================================
    const aboutSection = document.getElementById('about');
    
    if (aboutSection) {
        const dotsContainer = aboutSection.querySelector('.about-dots-container');
        
        if (dotsContainer) {
            let targetX = 0;
            let targetY = 0;
            let currentX = 0;
            let currentY = 0;
            const ease = 0.08; // Lower = more resistance/lag
            const maxMove = 15; // Maximum pixels to move
            
            // Smooth animation loop
            function animateDots() {
                // Ease towards target
                currentX += (targetX - currentX) * ease;
                currentY += (targetY - currentY) * ease;
                
                // Apply transform with resistance
                dotsContainer.style.transform = `translate(${currentX}px, ${currentY}px)`;
                
                requestAnimationFrame(animateDots);
            }
            
            // Start animation loop
            animateDots();
            
            // Track mouse movement
            aboutSection.addEventListener('mousemove', (e) => {
                const rect = aboutSection.getBoundingClientRect();
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                // Calculate offset from center
                const mouseX = e.clientX - rect.left;
                const mouseY = e.clientY - rect.top;
                
                // Calculate target position (limited movement)
                targetX = ((mouseX - centerX) / centerX) * maxMove;
                targetY = ((mouseY - centerY) / centerY) * maxMove;
            });
            
            // Reset on mouse leave
            aboutSection.addEventListener('mouseleave', () => {
                targetX = 0;
                targetY = 0;
            });
        }
    }
});
