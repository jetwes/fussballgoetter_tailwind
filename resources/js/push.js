const csrf = () => document.querySelector('meta[name="csrf-token"]')?.content ?? '';
const vapidKey = () => document.querySelector('meta[name="vapid-public-key"]')?.content ?? '';

function urlBase64ToUint8Array(base64) {
    const padding = '='.repeat((4 - (base64.length % 4)) % 4);
    const raw = atob((base64 + padding).replace(/-/g, '+').replace(/_/g, '/'));
    return Uint8Array.from([...raw].map((char) => char.charCodeAt(0)));
}

async function post(url, method, body) {
    const response = await fetch(url, {
        method,
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf(), Accept: 'application/json' },
        body: JSON.stringify(body),
    });

    if (! response.ok) throw new Error(`Push request failed: ${response.status}`);
}

export function pushSupported() {
    return 'serviceWorker' in navigator && 'PushManager' in window && 'Notification' in window && vapidKey() !== '';
}

export async function pushStatus() {
    const registration = await navigator.serviceWorker.ready;
    return (await registration.pushManager.getSubscription()) !== null;
}

export async function subscribePush() {
    const permission = await Notification.requestPermission();
    if (permission !== 'granted') return false;

    const registration = await navigator.serviceWorker.ready;
    const subscription = await registration.pushManager.subscribe({
        userVisibleOnly: true,
        applicationServerKey: urlBase64ToUint8Array(vapidKey()),
    });

    const json = subscription.toJSON();
    await post('/push/subscribe', 'POST', {
        endpoint: json.endpoint,
        keys: json.keys,
        contentEncoding: (PushManager.supportedContentEncodings || ['aesgcm'])[0],
    });

    return true;
}

export async function unsubscribePush() {
    const registration = await navigator.serviceWorker.ready;
    const subscription = await registration.pushManager.getSubscription();
    if (! subscription) return;

    await post('/push/subscribe', 'DELETE', { endpoint: subscription.endpoint });
    await subscription.unsubscribe();
}
