// src/store/auth.ts
import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        isAuthenticated: false,
    }),
    actions: {
        login() {
            // You can implement your login logic here.
            // For simplicity, we'll just set isAuthenticated to true.
            this.isAuthenticated = true;
        },
        logout() {
            // Log out logic here.
            this.isAuthenticated = false;
        },
    },
});
