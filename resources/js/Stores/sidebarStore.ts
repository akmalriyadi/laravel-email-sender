// src/store/SidebarStore.js
import { defineStore } from 'pinia';

export const useSidebarStore = defineStore('sidebar', {
    state: () => ({
        sidebarOpen: window.innerWidth >= 768, // Default true for desktop
    }),
    actions: {
        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
        },
        offSidebar() {
            this.sidebarOpen = false
        },
        onSidebar() {
            this.sidebarOpen = true
        }
    },
});
