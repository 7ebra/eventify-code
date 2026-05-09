/**
 * Eventify — interactions
 * Apple-style 3D parallax, custom cursor, scroll reveal.
 * Plain JavaScript, no dependencies.
 */
(function () {
    'use strict';

    // ============================================
    // 3D Hero parallax — mouse-tracked tilt
    // ============================================
    const stage = document.querySelector('.hero-stage');
    const ornaments = document.querySelectorAll('.hero-ornament');
    const numerals = document.querySelectorAll('.hero-numeral');
    
    if (stage && window.matchMedia('(pointer: fine)').matches) {
        let targetX = 0, targetY = 0;
        let currentX = 0, currentY = 0;

        const heroSection = document.querySelector('.hero');

        heroSection.addEventListener('mousemove', (e) => {
            const rect = heroSection.getBoundingClientRect();
            const cx = rect.left + rect.width / 2;
            const cy = rect.top + rect.height / 2;
            
            // Normalize -1 to 1
            targetX = (e.clientX - cx) / (rect.width / 2);
            targetY = (e.clientY - cy) / (rect.height / 2);
        });

        heroSection.addEventListener('mouseleave', () => {
            targetX = 0;
            targetY = 0;
        });

        const animate = () => {
            // Smooth lerp
            currentX += (targetX - currentX) * 0.08;
            currentY += (targetY - currentY) * 0.08;

            // Stage rotates slightly
            const rotY = currentX * 4;   // max 4deg
            const rotX = -currentY * 3;  // max 3deg
            stage.style.transform = `rotateY(${rotY}deg) rotateX(${rotX}deg)`;

            // Each ornament moves at different depth — true parallax
            ornaments.forEach((el, i) => {
                const depth = (i + 1) * 25;
                const baseRotate = el.dataset.rotate || 0;
                const tx = currentX * depth;
                const ty = currentY * depth;
                el.style.transform = `translate3d(${tx}px, ${ty}px, 0) rotate(${baseRotate}deg)`;
            });

            // Numerals drift slower (further "away")
            numerals.forEach((el) => {
                el.style.transform = `translate3d(${currentX * 15}px, ${currentY * 15}px, 0)`;
            });

            requestAnimationFrame(animate);
        };
        animate();
    }

    // ============================================
    // Custom cursor
    // ============================================
    if (window.matchMedia('(pointer: fine)').matches) {
        const dot = document.createElement('div');
        const ring = document.createElement('div');
        dot.className = 'cursor-dot';
        ring.className = 'cursor-ring';
        document.body.appendChild(dot);
        document.body.appendChild(ring);

        let mx = 0, my = 0;
        let rx = 0, ry = 0;

        document.addEventListener('mousemove', (e) => {
            mx = e.clientX;
            my = e.clientY;
            dot.style.transform = `translate(${mx - 3}px, ${my - 3}px)`;
        });

        const trail = () => {
            rx += (mx - rx) * 0.15;
            ry += (my - ry) * 0.15;
            ring.style.transform = `translate(${rx - 16}px, ${ry - 16}px)`;
            requestAnimationFrame(trail);
        };
        trail();

        // Expand ring on hoverable elements
        document.querySelectorAll('a, button, input, select, textarea, .event-card').forEach(el => {
            el.addEventListener('mouseenter', () => {
                ring.style.width = '50px';
                ring.style.height = '50px';
            });
            el.addEventListener('mouseleave', () => {
                ring.style.width = '32px';
                ring.style.height = '32px';
            });
        });

        document.addEventListener('mouseleave', () => {
            dot.style.opacity = '0';
            ring.style.opacity = '0';
        });
        document.addEventListener('mouseenter', () => {
            dot.style.opacity = '1';
            ring.style.opacity = '1';
        });
    }

    // ============================================
    // Mobile menu
    // ============================================
    const menuBtn = document.getElementById('menuToggle');
    const navList = document.getElementById('navList');
    if (menuBtn && navList) {
        menuBtn.addEventListener('click', () => navList.classList.toggle('open'));
    }

    // ============================================
    // Scroll reveal
    // ============================================
    if ('IntersectionObserver' in window) {
        const els = document.querySelectorAll('.event-card, .stat-cell, .reveal, .form-card');
        els.forEach(el => el.classList.add('reveal'));

        const obs = new IntersectionObserver((entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    setTimeout(() => entry.target.classList.add('visible'), i * 80);
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });

        els.forEach(el => obs.observe(el));
    }

    // ============================================
    // Char counter
    // ============================================
    const desc = document.getElementById('description');
    const count = document.getElementById('charCount');
    if (desc && count) {
        const max = desc.getAttribute('maxlength') || 1000;
        const update = () => count.textContent = `${desc.value.length} / ${max}`;
        desc.addEventListener('input', update);
        update();
    }

    // ============================================
    // Form validation
    // ============================================
    const form = document.querySelector('.event-form');
    if (form) {
        form.addEventListener('submit', (e) => {
            const issues = [];
            if (form.event_name.value.trim().length < 3)
                issues.push('Event name needs at least 3 characters.');
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.contact_email.value.trim()))
                issues.push('Email looks incorrect.');
            
            if (issues.length) {
                e.preventDefault();
                alert(issues.join('\n'));
            }
        });
    }

    // ============================================
    // Auto-dismiss success alerts
    // ============================================
    document.querySelectorAll('.alert-success').forEach(a => {
        setTimeout(() => {
            a.style.transition = 'opacity 0.8s, transform 0.8s';
            a.style.opacity = '0';
            a.style.transform = 'translateY(-10px)';
            setTimeout(() => a.remove(), 800);
        }, 7000);
    });

})();