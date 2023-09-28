// src/store/store.ts
import { createPinia } from 'pinia';

// Create a Pinia store
export const store = createPinia();

// ...other store setup

export default store; // Export the store as the default export

import { defineStore } from 'pinia';

export const useAuthStore = defineStore({
    id: 'auth',
    state: () => ({
        isLoggedIn: false,
    }),
    actions: {
        login() {
            this.isLoggedIn = true;
        },
        logout() {
            this.isLoggedIn = false;
        },
    },
});
