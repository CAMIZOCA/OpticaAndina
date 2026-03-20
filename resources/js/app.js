import './bootstrap';
import intersect from '@alpinejs/intersect';

// Livewire 3 bundles Alpine internally — register plugins via alpine:init
// to avoid "multiple instances of Alpine" warning
document.addEventListener('alpine:init', () => {
    window.Alpine.plugin(intersect);
});

// Animaciones scroll con IntersectionObserver
document.addEventListener('DOMContentLoaded', () => {
    const els = document.querySelectorAll('[data-animate]');
    if (!els.length) return;
    const obs = new IntersectionObserver(
        (entries) => {
            entries.forEach((e) => {
                if (e.isIntersecting) {
                    e.target.classList.add('is-visible');
                    obs.unobserve(e.target);
                }
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    );
    els.forEach((el) => obs.observe(el));
});
