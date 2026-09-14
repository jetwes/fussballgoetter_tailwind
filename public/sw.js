/* Service Worker der Fußballgötter-App: nimmt Push-Nachrichten entgegen. Kein Offline-Cache. */

self.addEventListener('install', () => self.skipWaiting());
self.addEventListener('activate', (event) => event.waitUntil(self.clients.claim()));

self.addEventListener('push', (event) => {
    let payload = {};
    try {
        payload = event.data ? event.data.json() : {};
    } catch (e) {
        payload = { title: 'Fußballgötter', body: event.data ? event.data.text() : '' };
    }

    const title = payload.title || 'Fußballgötter';
    const options = Object.assign(
        {
            body: payload.body || '',
            icon: payload.icon || '/img/icons/icon-192.png',
            badge: payload.badge || '/img/icons/badge-96.png',
            data: payload.data || {},
            tag: payload.tag,
            renotify: !! payload.renotify,
            actions: payload.actions || [],
        },
        payload.options || {},
    );

    event.waitUntil(self.registration.showNotification(title, options));
});

self.addEventListener('notificationclick', (event) => {
    event.notification.close();
    const url = (event.notification.data && event.notification.data.url) || '/';

    event.waitUntil(
        self.clients.matchAll({ type: 'window', includeUncontrolled: true }).then((clients) => {
            for (const client of clients) {
                if ('focus' in client) {
                    client.navigate(url);
                    return client.focus();
                }
            }
            return self.clients.openWindow(url);
        }),
    );
});
