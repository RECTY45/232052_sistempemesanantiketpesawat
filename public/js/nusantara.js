// Nusantara Airways Landing Page JavaScript

document.addEventListener("DOMContentLoaded", function () {
    // Mobile menu toggle functionality
    const mobileMenuButton = document.getElementById("mobile-menu-button");
    const mobileMenu = document.getElementById("mobile-menu");

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener("click", function () {
            mobileMenu.classList.toggle("hidden");

            // Toggle icon between hamburger and close
            const icon = mobileMenuButton.querySelector("i");
            if (mobileMenu.classList.contains("hidden")) {
                icon.className = "fas fa-bars text-xl";
            } else {
                icon.className = "fas fa-times text-xl";
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener("click", function (e) {
            if (
                !mobileMenuButton.contains(e.target) &&
                !mobileMenu.contains(e.target)
            ) {
                mobileMenu.classList.add("hidden");
                const icon = mobileMenuButton.querySelector("i");
                icon.className = "fas fa-bars text-xl";
            }
        });
    }

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute("href"));
            if (target) {
                // Close mobile menu if open
                if (mobileMenu) {
                    mobileMenu.classList.add("hidden");
                    const icon = mobileMenuButton?.querySelector("i");
                    if (icon) icon.className = "fas fa-bars text-xl";
                }

                // Smooth scroll to target
                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                });
            }
        });
    });

    // Navbar background change on scroll
    const navbar = document.getElementById("navbar");
    if (navbar) {
        window.addEventListener("scroll", function () {
            if (window.scrollY > 50) {
                navbar.classList.add("bg-white/98", "shadow-lg");
                navbar.classList.remove("bg-white/95");
            } else {
                navbar.classList.remove("bg-white/98", "shadow-lg");
                navbar.classList.add("bg-white/95");
            }
        });
    }

    // Scroll progress bar
    createScrollProgressBar();

    // Parallax effect for hero section
    const hero = document.querySelector("#beranda");
    if (hero) {
        window.addEventListener("scroll", function () {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.5;
            hero.style.transform = `translate3d(0, ${rate}px, 0)`;
        });
    }

    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px",
    };

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("animate-fade-in");
            }
        });
    }, observerOptions);

    // Observe elements for animation
    document
        .querySelectorAll(".hover-scale, .service-card, .card-destination")
        .forEach((el) => {
            observer.observe(el);
        });

    // Statistics counter animation
    animateCounters();

    // Add scroll reveal for elements
    addScrollReveal();

    // Initialize destination card hover effects
    initDestinationCards();

    // Initialize service cards
    initServiceCards();

    // Add floating elements random movement
    initFloatingElements();

    // Initialize typing animation for hero title
    initTypingAnimation();

    // Add page transition effects
    initPageTransitions();

    // Initialize lazy loading for images
    initLazyLoading();
});

// Create scroll progress bar
function createScrollProgressBar() {
    const progressBar = document.createElement("div");
    progressBar.className = "scroll-progress";
    document.body.appendChild(progressBar);

    window.addEventListener("scroll", function () {
        const scrollTop = window.pageYOffset;
        const documentHeight =
            document.documentElement.scrollHeight - window.innerHeight;
        const scrollPercent = (scrollTop / documentHeight) * 100;
        progressBar.style.width = scrollPercent + "%";
    });
}

// Animate counters
function animateCounters() {
    const counters = document.querySelectorAll('[data-aos="fade-up"]');
    const observerOptions = {
        threshold: 0.5,
    };

    const counterObserver = new IntersectionObserver(function (entries) {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const target = entry.target;
                const statsSection = target.closest(".grid");

                if (statsSection && statsSection.querySelector(".text-3xl")) {
                    animateStatsNumbers(statsSection);
                }
            }
        });
    }, observerOptions);

    counters.forEach((counter) => counterObserver.observe(counter));
}

// Animate statistics numbers
function animateStatsNumbers(statsSection) {
    const numbers = statsSection.querySelectorAll(".text-3xl");

    numbers.forEach((number) => {
        const finalValue = number.textContent;
        let currentValue = 0;
        let increment = 1;

        // Extract numeric value
        const numericValue = parseInt(finalValue.replace(/\D/g, ""));

        if (numericValue > 100) increment = Math.ceil(numericValue / 50);
        else if (numericValue > 50) increment = Math.ceil(numericValue / 30);
        else increment = 1;

        const timer = setInterval(() => {
            currentValue += increment;

            if (currentValue >= numericValue) {
                currentValue = numericValue;
                clearInterval(timer);
            }

            // Update display with original format
            if (finalValue.includes("K+")) {
                number.textContent = Math.floor(currentValue / 1000) + "K+";
            } else if (finalValue.includes("%")) {
                number.textContent = currentValue + "%";
            } else if (finalValue.includes("+")) {
                number.textContent = currentValue + "+";
            } else {
                number.textContent = currentValue;
            }
        }, 30);
    });
}

// Add scroll reveal effects
function addScrollReveal() {
    const scrollElements = document.querySelectorAll(".hover-scale");

    const elementInView = (el, dividend = 1) => {
        const elementTop = el.getBoundingClientRect().top;
        return (
            elementTop <=
            (window.innerHeight || document.documentElement.clientHeight) /
                dividend
        );
    };

    const displayScrollElement = (element) => {
        element.classList.add("animate-fade-in");
    };

    const handleScrollAnimation = () => {
        scrollElements.forEach((el) => {
            if (elementInView(el, 1.25)) {
                displayScrollElement(el);
            }
        });
    };

    window.addEventListener("scroll", handleScrollAnimation);
}

// Initialize destination cards
function initDestinationCards() {
    const destinationCards = document.querySelectorAll(".card-destination");

    destinationCards.forEach((card) => {
        card.addEventListener("mouseenter", function () {
            this.style.transform = "translateY(-10px) scale(1.02)";
            this.style.boxShadow = "0 25px 50px rgba(0,0,0,0.3)";
        });

        card.addEventListener("mouseleave", function () {
            this.style.transform = "translateY(0) scale(1)";
            this.style.boxShadow = "0 10px 30px rgba(0,0,0,0.2)";
        });

        // Add click ripple effect
        card.addEventListener("click", function (e) {
            createRippleEffect(e, this);
        });
    });
}

// Initialize service cards
function initServiceCards() {
    const serviceCards = document.querySelectorAll(".service-card");

    serviceCards.forEach((card) => {
        card.addEventListener("mouseenter", function () {
            const icon = this.querySelector("i");
            if (icon) {
                icon.style.transform = "rotate(10deg) scale(1.1)";
                icon.style.transition = "transform 0.3s ease";
            }
        });

        card.addEventListener("mouseleave", function () {
            const icon = this.querySelector("i");
            if (icon) {
                icon.style.transform = "rotate(0deg) scale(1)";
            }
        });
    });
}

// Initialize floating elements
function initFloatingElements() {
    const floatingElements = document.querySelectorAll(".float-animation");

    floatingElements.forEach((element, index) => {
        // Add random delay to floating animation
        element.style.animationDelay = `${index * 2}s`;

        // Add random gentle movement
        setInterval(() => {
            const randomX = Math.random() * 10 - 5;
            const randomY = Math.random() * 10 - 5;
            element.style.transform += ` translate(${randomX}px, ${randomY}px)`;
        }, 5000 + index * 1000);
    });
}

// Initialize typing animation
function initTypingAnimation() {
    const heroTitle = document.querySelector(".hero-title");
    if (!heroTitle) return;

    const originalText = heroTitle.textContent;
    const words = originalText.split(" ");

    heroTitle.innerHTML = words
        .map(
            (word, index) =>
                `<span class="word" style="animation-delay: ${
                    index * 0.3
                }s">${word}</span>`
        )
        .join(" ");

    // Add CSS for word animation
    const style = document.createElement("style");
    style.textContent = `
        .word {
            opacity: 0;
            animation: slideInUp 0.6s ease forwards;
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
    `;
    document.head.appendChild(style);
}

// Initialize page transitions
function initPageTransitions() {
    const links = document.querySelectorAll('a[href^="/"]');

    links.forEach((link) => {
        link.addEventListener("click", function (e) {
            const href = this.getAttribute("href");

            if (href && href !== "#" && !href.startsWith("#")) {
                e.preventDefault();

                // Create transition overlay
                const overlay = document.createElement("div");
                overlay.className = "page-transition-overlay";
                overlay.style.cssText = `
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: linear-gradient(45deg, #FF0000, #FFD700);
                    z-index: 9999;
                    transform: scaleX(0);
                    transform-origin: left;
                    transition: transform 0.5s ease;
                `;

                document.body.appendChild(overlay);

                // Trigger transition
                setTimeout(() => {
                    overlay.style.transform = "scaleX(1)";
                }, 10);

                // Navigate after animation
                setTimeout(() => {
                    window.location.href = href;
                }, 500);
            }
        });
    });
}

// Initialize lazy loading
function initLazyLoading() {
    const lazyImages = document.querySelectorAll("img[data-src]");

    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove("lazy");
                imageObserver.unobserve(img);
            }
        });
    });

    lazyImages.forEach((img) => imageObserver.observe(img));
}

// Create ripple effect
function createRippleEffect(event, element) {
    const ripple = document.createElement("span");
    const rect = element.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const x = event.clientX - rect.left - size / 2;
    const y = event.clientY - rect.top - size / 2;

    ripple.style.cssText = `
        position: absolute;
        width: ${size}px;
        height: ${size}px;
        left: ${x}px;
        top: ${y}px;
        background: radial-gradient(circle, rgba(255, 215, 0, 0.3) 0%, transparent 70%);
        border-radius: 50%;
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
        z-index: 10;
    `;

    // Add ripple animation keyframes if not exists
    if (!document.querySelector("#ripple-keyframes")) {
        const style = document.createElement("style");
        style.id = "ripple-keyframes";
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(2);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    }

    element.style.position = "relative";
    element.style.overflow = "hidden";
    element.appendChild(ripple);

    // Remove ripple after animation
    setTimeout(() => {
        if (ripple.parentNode) {
            ripple.parentNode.removeChild(ripple);
        }
    }, 600);
}

// Add custom cursor effect
document.addEventListener("mousemove", function (e) {
    const cursor = document.querySelector(".custom-cursor");
    if (cursor) {
        cursor.style.left = e.clientX + "px";
        cursor.style.top = e.clientY + "px";
    }
});

// Add smooth page load animation
window.addEventListener("load", function () {
    document.body.classList.add("page-loaded");

    // Remove loading overlay if exists
    const loader = document.querySelector(".page-loader");
    if (loader) {
        setTimeout(() => {
            loader.style.opacity = "0";
            setTimeout(() => {
                loader.remove();
            }, 300);
        }, 500);
    }
});

// Add keyboard navigation support
document.addEventListener("keydown", function (e) {
    // Navigate sections with arrow keys
    if (e.key === "ArrowDown" || e.key === "ArrowUp") {
        e.preventDefault();
        const sections = ["#beranda", "#destinasi", "#layanan", "#tentang"];
        const current = getCurrentSection();
        let nextIndex = sections.indexOf(current);

        if (e.key === "ArrowDown" && nextIndex < sections.length - 1) {
            nextIndex++;
        } else if (e.key === "ArrowUp" && nextIndex > 0) {
            nextIndex--;
        }

        const target = document.querySelector(sections[nextIndex]);
        if (target) {
            target.scrollIntoView({ behavior: "smooth" });
        }
    }
});

// Get current section in viewport
function getCurrentSection() {
    const sections = ["#beranda", "#destinasi", "#layanan", "#tentang"];
    let current = sections[0];

    sections.forEach((selector) => {
        const section = document.querySelector(selector);
        if (section) {
            const rect = section.getBoundingClientRect();
            if (
                rect.top <= window.innerHeight / 2 &&
                rect.bottom > window.innerHeight / 2
            ) {
                current = selector;
            }
        }
    });

    return current;
}

// Export functions for external use
window.NusantaraAirways = {
    createRippleEffect,
    animateCounters,
    initDestinationCards,
    initServiceCards,
};
