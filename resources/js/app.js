import './bootstrap';
import intersect from '@alpinejs/intersect';

const TRACKING_ENDPOINT = '/conversion-events';
const SESSION_COOKIE = 'oa_session_token';

document.addEventListener('alpine:init', () => {
    window.Alpine.plugin(intersect);
});

const readCookie = (name) => {
    const match = document.cookie.match(new RegExp(`(^|; )${name}=([^;]*)`));

    return match ? decodeURIComponent(match[2]) : null;
};

const writeCookie = (name, value, days = 365) => {
    const expires = new Date(Date.now() + days * 864e5).toUTCString();
    document.cookie = `${name}=${encodeURIComponent(value)}; expires=${expires}; path=/; SameSite=Lax`;
};

const ensureSessionToken = () => {
    const existing = readCookie(SESSION_COOKIE);

    if (existing) {
        return existing;
    }

    const token = window.crypto?.randomUUID?.() ?? `${Date.now()}-${Math.random().toString(16).slice(2)}`;
    writeCookie(SESSION_COOKIE, token);

    return token;
};

const sendGaEvent = (eventName, payload = {}) => {
    if (typeof window.gtag !== 'function') {
        return;
    }

    window.gtag('event', eventName, payload);
};

const trackEvent = async (eventName, payload = {}) => {
    ensureSessionToken();

    const routeName = document.querySelector('meta[name="route-name"]')?.content || null;
    const body = {
        event_name: eventName,
        event_category: payload.event_category ?? null,
        page_path: payload.page_path ?? window.location.pathname,
        page_url: payload.page_url ?? window.location.href,
        route_name: payload.route_name ?? routeName,
        meta: {
            label: payload.label ?? null,
            location: payload.location ?? null,
            destination: payload.destination ?? null,
        },
    };

    sendGaEvent(eventName, {
        event_category: body.event_category,
        page_path: body.page_path,
        page_location: body.page_url,
        label: body.meta.label,
        location: body.meta.location,
        destination: body.meta.destination,
    });

    try {
        await fetch(TRACKING_ENDPOINT, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
            keepalive: true,
            body: JSON.stringify(body),
        });
    } catch (error) {
        console.debug('Tracking error', error);
    }
};

document.addEventListener('DOMContentLoaded', () => {
    ensureSessionToken();

    const animatedElements = document.querySelectorAll('[data-animate]');
    if (animatedElements.length) {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
        );

        animatedElements.forEach((element) => observer.observe(element));
    }

    trackEvent('page_view', {
        event_category: 'engagement',
    });

    document.querySelectorAll('[data-track-event]').forEach((element) => {
        element.addEventListener('click', () => {
            trackEvent(element.dataset.trackEvent, {
                event_category: element.dataset.trackCategory ?? null,
                label: element.dataset.trackLabel ?? element.textContent?.trim() ?? null,
                location: element.dataset.trackLocation ?? null,
                destination: element.dataset.trackDestination ?? null,
            });
        });
    });

    (window.__oaTrackedEvents || []).forEach((event) => {
        sendGaEvent(event.event_name, {
            event_category: event.event_category ?? null,
            page_path: event.meta?.page_path ?? window.location.pathname,
        });
    });
});
