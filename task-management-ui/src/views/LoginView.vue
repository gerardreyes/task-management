<template>
  <div>
    <h2>Login</h2>
    <form @submit.prevent="login">
      <div class="form-group">
        <label for="email">Email</label>
        <input v-model="email" type="email" id="email" placeholder="Email" required />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input v-model="password" type="password" id="password" placeholder="Password" required />
      </div>
      <button type="submit" class="login-button">Login</button>
    </form>
    <p>
      Don't have an account? <router-link to="/register">Click here to register</router-link>
    </p>
    <!-- Display an error message when login fails -->
    <div v-if="errorMessage" class="error">{{ errorMessage }}</div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

export default defineComponent({
  setup() {
    const email = ref('');
    const password = ref('');
    const errorMessage = ref('');
    const router = useRouter();

    const login = () => {
      // Clear previous error message
      errorMessage.value = '';

      // Send login request to Laravel API
      axios.post('http://localhost/api/login', { email: email.value, password: password.value })
          .then(() => {
            // Handle successful login
            router.push('/tasks'); // Redirect to the tasks view on success
          })
          .catch((error) => {
            errorMessage.value = 'Login failed. Please try again.';
          });
    };

    return { email, password, login, errorMessage };
  },
});
</script>

<style scoped>
/* Add your CSS styles for the form here */
.form-group {
  margin-bottom: 15px;
}

label {
  display: block;
}

.error {
  color: red;
  margin-top: 10px;
}

/* Add spacing between buttons */
.login-button {
  margin-top: 10px; /* Add margin to separate the button from the error message */
}
</style>
