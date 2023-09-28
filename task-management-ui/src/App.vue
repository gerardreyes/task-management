<template>
  <div id="app">
    <nav>
      <router-link to="/">Home</router-link> |
      <!-- Display "Tasks" link if logged in -->
      <router-link v-if="isLoggedIn" to="/tasks">Tasks|</router-link>
      <router-link to="/about">About</router-link>

      <!-- Add a spacer to push the links to the right side -->
      <span class="spacer"></span>

      <!-- Display "Login" link if not logged in -->
      <router-link v-if="!isLoggedIn" to="/login">Login</router-link> |
      <!-- Display "Register" link if not logged in -->
      <router-link v-if="!isLoggedIn" to="/register">Register</router-link>
      <!-- Display "Logout" link if logged in -->
      <router-link v-if="isLoggedIn" @click="logout">Logout</router-link>
    </nav>
    <router-view />
  </div>
</template>

<script>
import { computed } from 'vue';
import { store, useAuthStore } from '@/store'; // Import the store directly from your store file

export default {
  setup() {
    const authStore = useAuthStore(); // Use the auth store

    // Use a computed property to get the isLoggedIn status from the store
    const isLoggedIn = computed(() => authStore.isLoggedIn);

    // Create a logout function that calls the logout action in the store
    const logout = () => {
      authStore.logout();
      // Perform logout actions (e.g., clear tokens, redirect to login)
    };

    return { isLoggedIn, logout };
  },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

nav {
  display: flex;
  justify-content: space-between; /* Align items to the left and right */
  align-items: center;
  padding: 30px;
}

/* Style the spacer element to push the links to the right */
.spacer {
  flex-grow: 1; /* Allow the spacer to grow and push the links to the right */
}

nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #42b983;
}
</style>
