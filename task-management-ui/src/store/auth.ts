// src/store/auth.ts
import { defineStore } from 'pinia';

interface User {
    id: number;
    name: string;
    email: string;
    // Add other fields as needed
}

export const useAuthStore = defineStore('auth', {
    state: () => ({
        isAuthenticated: false,
        user: null as User | null,
        token: '', // Store the authentication token
    }),
    actions: {
        login() {
            // You can implement your login logic here.
            // For simplicity, we'll just set isAuthenticated to true.
            this.isAuthenticated = true;
        },
        setUser(user: User | null) {
            this.user = user;
        },
        setToken(token: string) {
            this.token = token; // Store the token
        },
        logout() {
            // Log out logic here.
            this.isAuthenticated = false;
            this.user = null;
            this.token = ''; // Clear the token on logout
        },
    },
});
