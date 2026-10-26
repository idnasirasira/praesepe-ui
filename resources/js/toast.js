/**
 * Global toast store and ui:toast window event bridge.
 */

const MAX_VISIBLE = 5;

/**
 * @param {import('alpinejs').Alpine} Alpine
 */
export function registerToastStore(Alpine) {
    Alpine.store('toasts', {
        items: [],
        position: 'bottom-right',

        /**
         * @param {{ type?: string, title?: string, message?: string, duration?: number }} payload
         */
        push(payload = {}) {
            const id = `toast-${Date.now()}-${Math.random().toString(36).slice(2, 8)}`;
            const type = ['info', 'success', 'warning', 'danger'].includes(payload.type)
                ? payload.type
                : 'info';
            const duration = Number.isFinite(payload.duration) ? payload.duration : 5000;

            const item = {
                id,
                type,
                title: payload.title || '',
                message: payload.message || '',
                duration,
                remaining: duration,
                hovering: false,
                timer: null,
                startedAt: null,
            };

            this.items = [...this.items, item].slice(-MAX_VISIBLE);
            this.startTimer(id);
        },

        dismiss(id) {
            const item = this.items.find((entry) => entry.id === id);
            if (item?.timer) {
                clearTimeout(item.timer);
            }
            this.items = this.items.filter((entry) => entry.id !== id);
        },

        startTimer(id) {
            const item = this.items.find((entry) => entry.id === id);
            if (!item || item.duration <= 0) {
                return;
            }

            item.startedAt = Date.now();
            item.timer = setTimeout(() => this.dismiss(id), item.remaining);
        },

        pause(id) {
            const item = this.items.find((entry) => entry.id === id);
            if (!item || !item.timer) {
                return;
            }

            clearTimeout(item.timer);
            item.timer = null;
            const elapsed = Date.now() - (item.startedAt || Date.now());
            item.remaining = Math.max(item.remaining - elapsed, 0);
            item.hovering = true;
        },

        resume(id) {
            const item = this.items.find((entry) => entry.id === id);
            if (!item || item.duration <= 0) {
                return;
            }

            item.hovering = false;
            if (item.remaining <= 0) {
                this.dismiss(id);
                return;
            }

            this.startTimer(id);
        },
    });

    window.addEventListener('ui:toast', (event) => {
        Alpine.store('toasts').push(event.detail || {});
    });
}
