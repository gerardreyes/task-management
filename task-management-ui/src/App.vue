<template>
  <div id="app">
    <nav>
      <router-link to="/">Home</router-link> |
      <!-- Display "Tasks" link -->
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
export default {
  data() {
    return {
      // Simulate user authentication status (you should replace this with actual authentication logic)
      isLoggedIn: false,
    };
  },
  methods: {
    // Simulate the logout action (you should replace this with actual logout logic)
    logout() {
      this.isLoggedIn = false;
      // Perform logout actions (e.g., clear tokens, redirect to login)
    },
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
