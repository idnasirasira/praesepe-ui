const RECENT_KEY = 'praesepe-ui.recent-searches';
const MAX_RECENT = 6;
const MAX_RESULTS = 12;

/**
 * @param {string} indexUrl
 */
export function commandPalette(indexUrl) {
    return {
        sidebarOpen: false,
        searchOpen: false,
        query: '',
        results: [],
        recent: [],
        index: [],
        activeIndex: -1,
        indexUrl,

        init() {
            this.recent = this.loadRecent();
        },

        async loadIndex() {
            if (this.index.length) {
                return;
            }

            try {
                const response = await fetch(this.indexUrl);
                const data = await response.json();
                this.index = data.entries || [];
            } catch (error) {
                this.index = [];
            }
        },

        loadRecent() {
            try {
                const raw = window.localStorage.getItem(RECENT_KEY);
                const parsed = raw ? JSON.parse(raw) : [];

                return Array.isArray(parsed) ? parsed.slice(0, MAX_RECENT) : [];
            } catch (error) {
                return [];
            }
        },

        persistRecent() {
            window.localStorage.setItem(RECENT_KEY, JSON.stringify(this.recent.slice(0, MAX_RECENT)));
        },

        openSearch() {
            this.searchOpen = true;
            this.activeIndex = -1;
            this.loadIndex();
            this.recent = this.loadRecent();
            this.$nextTick(() => this.$refs.searchInput?.focus());
        },

        closeSearch() {
            this.searchOpen = false;
            this.query = '';
            this.results = [];
            this.activeIndex = -1;
        },

        entryHaystack(entry) {
            return [
                entry.title,
                entry.description,
                entry.type,
                ...(entry.tags || []),
                ...(entry.props || []),
                ...(entry.variants || []),
                ...(entry.headings || []),
            ]
                .join(' ')
                .toLowerCase();
        },

        runSearch() {
            const q = this.query.trim().toLowerCase();

            if (!q) {
                this.results = [];
                this.activeIndex = -1;

                return;
            }

            this.results = this.index
                .filter((entry) => this.entryHaystack(entry).includes(q))
                .slice(0, MAX_RESULTS);
            this.activeIndex = this.results.length ? 0 : -1;
        },

        activeOptionId() {
            if (this.activeIndex < 0 || !this.results[this.activeIndex]) {
                return null;
            }

            return `search-option-${this.activeIndex}`;
        },

        moveActive(delta) {
            if (!this.results.length) {
                this.activeIndex = -1;

                return;
            }

            const next = this.activeIndex + delta;

            if (next < 0) {
                this.activeIndex = this.results.length - 1;
            } else if (next >= this.results.length) {
                this.activeIndex = 0;
            } else {
                this.activeIndex = next;
            }

            this.$nextTick(() => {
                document.getElementById(this.activeOptionId())?.scrollIntoView({ block: 'nearest' });
            });
        },

        remember(entry) {
            this.recent = [entry, ...this.recent.filter((item) => item.href !== entry.href)].slice(0, MAX_RECENT);
            this.persistRecent();
        },

        goTo(entry) {
            if (!entry?.href) {
                return;
            }

            this.remember(entry);
            this.closeSearch();
            window.location.assign(entry.href);
        },

        activateSelection() {
            if (this.activeIndex >= 0 && this.results[this.activeIndex]) {
                this.goTo(this.results[this.activeIndex]);
            }
        },

        onComboboxKeydown(event) {
            switch (event.key) {
                case 'ArrowDown':
                    event.preventDefault();
                    if (!this.query && this.recent.length && !this.results.length) {
                        return;
                    }
                    this.moveActive(1);
                    break;
                case 'ArrowUp':
                    event.preventDefault();
                    this.moveActive(-1);
                    break;
                case 'Home':
                    if (this.results.length) {
                        event.preventDefault();
                        this.activeIndex = 0;
                    }
                    break;
                case 'End':
                    if (this.results.length) {
                        event.preventDefault();
                        this.activeIndex = this.results.length - 1;
                    }
                    break;
                case 'Enter':
                    if (this.activeIndex >= 0) {
                        event.preventDefault();
                        this.activateSelection();
                    }
                    break;
            }
        },

        openSearchFromSlash(event) {
            if (event.key !== '/' || this.searchOpen) {
                return;
            }

            const target = event.target;

            if (!(target instanceof Element)) {
                return;
            }

            const tag = target.tagName;

            if (['INPUT', 'TEXTAREA', 'SELECT'].includes(tag) || target.isContentEditable) {
                return;
            }

            event.preventDefault();
            this.openSearch();
        },
    };
}
