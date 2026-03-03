import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

try {
    const reverbKey = import.meta.env.VITE_REVERB_APP_KEY;
    const reverbHost = import.meta.env.VITE_REVERB_HOST;

    // Skip if no key or if host is localhost but we're on a real domain
    const isLocalhost = reverbHost === 'localhost' || reverbHost === '127.0.0.1';
    const isProductionSite = window.location.hostname !== 'localhost' && window.location.hostname !== '127.0.0.1';
    const shouldSkip = isLocalhost && isProductionSite;

    if (reverbKey && !shouldSkip) {
        window.Echo = new Echo({
            broadcaster: 'reverb',
            key: reverbKey,
            wsHost: reverbHost,
            wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
            wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
            forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
            enabledTransports: ['ws', 'wss'],
        });
    } else if (shouldSkip) {
        console.info('Laravel Echo: Realtime disabled (REVERB_HOST=localhost on production).');
    } else {
        console.info('Laravel Echo: Broadcasting disabled (no APP_KEY configured).');
    }
} catch (e) {
    console.error('Laravel Echo initialization failed:', e);
}
