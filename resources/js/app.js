import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Hero background video: only download it where it adds value (wide screens,
// no reduced-motion preference, no data saver). Everyone else sees the poster.
const heroVideo = document.querySelector('[data-hero-video]');

if (heroVideo) {
    const wide = window.matchMedia('(min-width: 768px)').matches;
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const saveData = navigator.connection?.saveData === true;

    if (wide && ! reducedMotion && ! saveData) {
        heroVideo.querySelectorAll('source[data-src]').forEach((source) => {
            source.src = source.dataset.src;
        });
        heroVideo.load();
        heroVideo.play().catch(() => {});
    }
}
