import './bootstrap';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

window.Alpine = Alpine;

Alpine.data('profilePage', () => ({
    activeTab: 'sejarah',
    contentTitles: {},
    pathTabs: {},
    profiles: {},
    lightboxOpen: false,
    lightboxData: {},

    init() {
        this.activeTab = this.$el.dataset.activeTab || 'sejarah';
        this.contentTitles = {
            sejarah: 'Tonggak Sejarah',
            motto: 'Moto, Visi, & Misi',
            tugas: 'Tugas dan Fungsi',
            struktur: 'Struktur Organisasi',
            profil: 'Profil Pejabat',
            ...this.parseJson(this.$el.dataset.contentTitles, {}),
        };
        this.pathTabs = this.parseJson(this.$el.dataset.pathTabs, {});

        const profileData = document.getElementById(this.$el.dataset.profilesId);
        this.profiles = this.parseJson(profileData?.textContent, {});

        window.addEventListener('popstate', () => {
            this.activeTab = this.pathTabs[window.location.pathname] || 'sejarah';
        });
    },

    parseJson(value, fallback) {
        try {
            return value ? JSON.parse(value) : fallback;
        } catch {
            return fallback;
        }
    },

    setTab(tab, url) {
        this.activeTab = tab;

        const nextUrl = new URL(url, window.location.origin);
        if (window.location.pathname !== nextUrl.pathname) {
            history.pushState({ tab }, '', nextUrl.pathname);
        }
    },

    openProfile(id) {
        this.lightboxData = this.profiles[id] || {};
        this.lightboxOpen = true;
    },

    closeProfile() {
        this.lightboxOpen = false;
    },

    contentTitle() {
        return this.contentTitles[this.activeTab] || 'Profil';
    },
}));

import { createIcons, icons } from 'lucide';

Livewire.start();

document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});
