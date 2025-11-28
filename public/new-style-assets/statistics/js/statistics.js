// Statistics Page - Interactive JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Animate number counting
    function animateValue(element, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const current = Math.floor(progress * (end - start) + start);
            element.textContent = current;
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    // Animate stat numbers on scroll into view
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const statNumber = entry.target;
                const finalValue = parseInt(statNumber.getAttribute('data-value'));
                const currentValue = parseInt(statNumber.textContent) || 0;
                
                if (finalValue !== currentValue) {
                    animateValue(statNumber, currentValue, finalValue, 1500);
                    statNumber.setAttribute('data-value', finalValue);
                }
                
                observer.unobserve(statNumber);
            }
        });
    }, observerOptions);

    // Observe all stat numbers
    document.querySelectorAll('.stat-number').forEach(stat => {
        const value = parseInt(stat.textContent);
        if (!isNaN(value)) {
            stat.setAttribute('data-value', value);
            stat.textContent = '0';
            observer.observe(stat);
        }
    });

    // Add ripple effect to stat cards
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('click', function(e) {
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

    // Progress bar animation on scroll
    const progressObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const progressBar = entry.target.querySelector('.progress-bar');
                if (progressBar) {
                    const width = progressBar.style.width;
                    progressBar.style.width = '0%';
                    setTimeout(() => {
                        progressBar.style.width = width;
                    }, 100);
                }
                progressObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.capacity-track-item').forEach(item => {
        progressObserver.observe(item);
    });

    // Add tooltip functionality
    document.querySelectorAll('[data-tooltip]').forEach(element => {
        element.addEventListener('mouseenter', function() {
            // Tooltip is handled by CSS
        });
    });

    // Timeline item click effects
    document.querySelectorAll('.timeline-block').forEach(block => {
        block.addEventListener('click', function() {
            this.style.transform = 'scale(1.02)';
            setTimeout(() => {
                this.style.transform = '';
            }, 200);
        });
    });

    // List item click effects
    document.querySelectorAll('.list-group-item').forEach(item => {
        item.addEventListener('click', function(e) {
            if (e.target.tagName !== 'A') {
                const link = this.querySelector('a');
                if (link) {
                    link.click();
                }
            }
        });
    });

    // Card hover sound effect (optional - can be removed)
    document.querySelectorAll('.chart-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
        });
    });
});

// Add ripple CSS dynamically
const style = document.createElement('style');
style.textContent = `
    .stat-card {
        position: relative;
        overflow: hidden;
    }
    .stat-card .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(102, 126, 234, 0.3);
        transform: scale(0);
        animation: ripple-animation 0.6s ease-out;
        pointer-events: none;
    }
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

