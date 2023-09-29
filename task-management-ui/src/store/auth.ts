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
        login(user: User) {
            // You can implement your login logic here.
            // For simplicity, we'll just set isAuthenticated to true.
            this.isAuthenticated = true;
            this.setUser(user); // Set the user details in the store
            // this.setUserId(user.id); // Set the user_id in the store
        },
        setUser(user: User | null) {
            console.log('I am inside setUser');
            console.log(user)
            this.user = user;
            console.log(this.user)
        },
        setToken(token: string) {
            console.log('I am inside setToken');
            this.token = token; // Store the token
        },
        getToken() {
            return this.token; // Return the stored token
        },
        logout() {
            // Log out logic here.
            this.isAuthenticated = false;
            this.user = null;
            this.token = ''; // Clear the token on logout
        },
    },
});
