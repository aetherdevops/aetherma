import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Analytics consent: GA4 (which sets cookies) only loads after the visitor accepts.
const CONSENT_KEY = 'aether-analytics-consent';

const readConsent = () => {
    try {
        return localStorage.getItem(CONSENT_KEY);
    } catch {
        return null;
    }
};

const loadGa4 = () => {
    const id = document.querySelector('meta[name="ga4-id"]')?.content;

    if (! id || window.gtag) {
        return;
    }

    const script = document.createElement('script');
    script.async = true;
    script.src = `https://www.googletagmanager.com/gtag/js?id=${encodeURIComponent(id)}`;
    document.head.appendChild(script);

    window.dataLayer = window.dataLayer || [];
    window.gtag = function gtag() {
        window.dataLayer.push(arguments);
    };
    window.gtag('js', new Date());
    window.gtag('config', id, { anonymize_ip: true });
};

if (readConsent() === 'granted') {
    loadGa4();
}

Alpine.data('cookieConsent', () => ({
    visible: readConsent() === null,
    store(value) {
        try {
            localStorage.setItem(CONSENT_KEY, value);
        } catch {
            // Storage blocked: the banner simply shows again next visit.
        }
        this.visible = false;
    },
    accept() {
        this.store('granted');
        loadGa4();
    },
    decline() {
        this.store('denied');
    },
}));

// Lets the privacy page reopen the choice.
window.resetCookieConsent = () => {
    try {
        localStorage.removeItem(CONSENT_KEY);
    } catch {
        // ignore
    }
    window.location.reload();
};

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
