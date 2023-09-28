<template>
  <div>
    <h2>Login</h2>
    <form @submit.prevent="login">
      <input v-model="email" type="email" placeholder="Email" />
      <input v-model="password" type="password" placeholder="Password" />
      <button type="submit">Login</button>
    </form>
    <p>
      Don't have an account? <router-link to="/register">Click here to register</router-link>
    </p>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import axios from 'axios';
import { store } from '@/store'; // Import the store directly from your store file

export default defineComponent({
  setup() {
    const email = ref('');
    const password = ref('');

    const login = () => {
      axios.post('/api/login', { email: email.value, password: password.value })
          .then((response) => {
            // Handle successful login
          })
          .catch((error) => {
            // Handle login error
          });
    };

    return { email, password, login };
  },
});
</script>
