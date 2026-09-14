import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import Cropper from 'cropperjs';
import 'cropperjs/dist/cropper.css';
import { pushSupported, pushStatus, subscribePush, unsubscribePush } from './push';

/**
 * Countdown bis zur Anmeldefrist (im Hero der Startseite).
 */
Alpine.data('countdown', (deadlineIso) => ({
    deadline: new Date(deadlineIso),
    label: '',
    urgent: false,
    closed: false,
    timer: null,
    init() {
        this.tick();
        this.timer = setInterval(() => this.tick(), 30_000);
    },
    destroy() {
        clearInterval(this.timer);
    },
    tick() {
        const diff = this.deadline.getTime() - Date.now();
        this.closed = diff <= 0;
        this.urgent = diff > 0 && diff <= 3 * 3_600_000;

        if (this.closed) {
            this.label = 'Anmeldung geschlossen';
            return;
        }

        const minutes = Math.floor(diff / 60_000);
        const days = Math.floor(minutes / 1_440);
        const hours = Math.floor((minutes % 1_440) / 60);
        const mins = minutes % 60;

        if (days > 0) {
            this.label = `noch ${days} ${days === 1 ? 'Tag' : 'Tage'} ${hours} Std.`;
        } else if (hours > 0) {
            this.label = `noch ${hours} Std. ${mins} Min.`;
        } else {
            this.label = `noch ${mins} Min.`;
        }
    },
}));

/**
 * Bildzuschnitt für den Avatar-Upload (Cropper.js).
 */
Alpine.data('avatarCropper', () => ({
    cropper: null,
    start(img) {
        this.stop();
        this.cropper = new Cropper(img, {
            aspectRatio: 1,
            viewMode: 1,
            dragMode: 'move',
            autoCropArea: 1,
            background: false,
            responsive: true,
        });
    },
    stop() {
        this.cropper?.destroy();
        this.cropper = null;
    },
    save() {
        const data = this.cropper ? this.cropper.getData(true) : null;
        this.$wire.save(data ? { x: data.x, y: data.y, width: data.width, height: data.height } : null);
    },
    destroy() {
        this.stop();
    },
}));

/**
 * Schalter für Push-Benachrichtigungen.
 */
Alpine.data('pushToggle', () => ({
    supported: pushSupported(),
    enabled: false,
    busy: false,
    denied: false,
    async init() {
        if (! this.supported) return;
        this.denied = Notification.permission === 'denied';
        this.enabled = await pushStatus();
    },
    async toggle() {
        if (this.busy || ! this.supported) return;
        this.busy = true;
        try {
            if (this.enabled) {
                await unsubscribePush();
                this.enabled = false;
            } else {
                this.enabled = await subscribePush();
                this.denied = Notification.permission === 'denied';
            }
        } catch (error) {
            console.error(error);
        } finally {
            this.busy = false;
        }
    },
}));

if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => navigator.serviceWorker.register('/sw.js').catch(() => {}));
}

Livewire.start();
