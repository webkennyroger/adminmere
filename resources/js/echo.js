import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

try {
    const reverbKey = import.meta.env.VITE_REVERB_APP_KEY;
    
    if (reverbKey) {
        window.Echo = new Echo({
            broadcaster: 'reverb',
            key: reverbKey,
            wsHost: import.meta.env.VITE_REVERB_HOST,
            wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
            wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
            forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
            enabledTransports: ['ws', 'wss'],
        });
    } else {
        console.warn('Laravel Echo: VITE_REVERB_APP_KEY not found. Broadcasting disabled.');
    }
} catch (e) {
    console.error('Laravel Echo initialization failed:', e);
}
