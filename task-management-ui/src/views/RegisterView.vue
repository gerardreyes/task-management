<template>
  <div>
    <h2>Register</h2>
    <form @submit.prevent="register">
      <input v-model="email" type="email" placeholder="Email" />
      <input v-model="password" type="password" placeholder="Password" />
      <button type="submit">Register</button>
    </form>
    <p>
      Already registered? <router-link to="/login">Click here to login</router-link>
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

    const register = () => {
      // Send registration request to Laravel API
      axios.post('/api/register', {
        email: email.value,
        password: password.value,
      })
          .then((response) => {
            // Registration was successful
            // You can handle the response as needed, e.g., redirect to a login page
          })
          .catch((error) => {
            // Registration failed, handle errors
            // You can show error messages to the user
            console.error('Registration error:', error);
          });
    };

    return { email, password, register };
  },
});
</script>
