<template>
  <div>
    <h2>Register</h2>
    <form @submit.prevent="register">
      <div class="form-group">
        <label for="name">Name</label>
        <input v-model="name" type="text" id="name" placeholder="Name" />
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input v-model="email" type="email" id="email" placeholder="Email" />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input v-model="password" type="password" id="password" placeholder="Password" />
      </div>
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
    const name = ref('');
    const email = ref('');
    const password = ref('');

    // Define your request headers
    const headers = {
      'Accept': 'application/json', // Set the Accept header to JSON
      // Add any other headers you need here
    };

    const register = () => {
      // Send registration request to Laravel API
      axios
          .post('http://localhost/api/register', {
          // .post('/api/register', {
            name: name.value,
            email: email.value,
            password: password.value,
          }, { headers })
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

    return { name, email, password, register };
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
</style>
