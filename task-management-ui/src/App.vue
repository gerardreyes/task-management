<template>
  <div id="app">
    <nav>
      <router-link to="/">Home</router-link> |
      <!-- Display "Tasks" link if logged in -->
      <router-link v-if="isLoggedIn" to="/tasks">Tasks|</router-link>
      <router-link to="/about">About</router-link>

      <!-- Add a spacer to push the links to the right side -->
      <span class="spacer"></span>

      <!-- Display "Logout" link if logged in -->
      <router-link v-if="isLoggedIn" @click="logout" to="#">Logout</router-link>

      <!-- Display "Login" link if not logged in -->
      <router-link v-if="!isLoggedIn" to="/login">Login|</router-link>
      <!-- Display "Register" link if not logged in -->
      <router-link v-if="!isLoggedIn" to="/register">Register</router-link>
    </nav>
    <!-- Display a greeting to the logged-in user -->
    <div v-if="isLoggedIn">Hello, {{ user.user.name }}. You are now logged in.</div>
    <router-view />
  </div>
</template>

<script>
import { computed } from 'vue';
import { useAuthStore } from '@/store/auth'; // Import the store directly from your store file
import { useRouter } from 'vue-router'; // Import the router

export default {
  setup() {
    const authStore = useAuthStore(); // Use the auth store
    const router = useRouter(); // Get the router instance

    // Use a computed property to get the isLoggedIn status from the store
    const isLoggedIn = computed(() => authStore.isAuthenticated);

    // Use a computed property to get the user's name from the store
    const user = computed(() => authStore.getUser() || '');

    // if (isLoggedIn.value) {
    //   const user = authStore.getUser();
    //   const userName = user.name;
    // } else {
    //   const userName = 'gerear'
    // }
    // const userName = 'gerear';

    // Create a method to log out the user
    const logout = () => {
      authStore.logout(); // Call the logout method from your auth store
      router.push('/login'); // Redirect to the login page after logout
    };

    return { isLoggedIn, user, logout };
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
