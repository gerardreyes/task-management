<template>
  <div>
    <h2>Register</h2>
    <form @submit.prevent="register">
      <div class="form-group">
        <label for="name">Name</label>
        <input v-model="name" type="text" id="name" placeholder="Name" required />
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input v-model="email" type="email" id="email" placeholder="Email" required />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input v-model="password" type="password" id="password" placeholder="Password" required minlength="8" />
      </div>
      <button type="submit" class="register-button">Register</button>
      <button type="button" @click="clearForm" class="clear-button">Clear</button>
    </form>
    <p>
      Already registered? <router-link to="/login">Click here to login</router-link>
    </p>
    <!-- Display a success message when registration is successful -->
    <div v-if="successMessage" class="success">{{ successMessage }}</div>
    <!-- Display a warning message when the registration fails -->
    <div v-if="warning" class="warning">{{ warning }}</div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
// import { API_URL } from '@/config'; // Adjust the import path as needed

export default defineComponent({
  setup() {
    const name = ref('');
    const email = ref('');
    const password = ref('');
    const successMessage = ref('');
    const warning = ref('');
    const router = useRouter();

    // Define your request headers
    const headers = {
      'Accept': 'application/json', // Set the Accept header to JSON
      // Add any other headers you need here
    };

    const register = () => {
      // Clear success message when trying to register again
      successMessage.value = '';
      warning.value = '';

      // Send registration request to Laravel API
      axios
          .post('http://localhost/api/register', {
            name: name.value,
            email: email.value,
            password: password.value,
          }, { headers })
          .then((response) => {
            // Registration was successful
            successMessage.value = 'Registration successful. Please login.';
            // Clear the form fields
            name.value = '';
            email.value = '';
            password.value = '';
            // Clear the warning if it was previously shown
            warning.value = '';
          })
          .catch((error) => {
            // Registration failed, handle errors
            // You can show error messages to the user
            if (error.response && error.response.data && error.response.data.error) {
              // Convert the error message object to a more readable format
              const errorObj = error.response.data.error;
              const errorMessage = Object.keys(errorObj)
                  .map((key) => `${errorObj[key][0]}`)
                  .join(', ');
              warning.value = 'Registration error: ' + errorMessage;
            } else {
              warning.value = 'Registration error';
            }
          });
    };

    // Function to clear the form fields
    const clearForm = () => {
      name.value = '';
      email.value = '';
      password.value = '';
    };

    return { name, email, password, register, warning, successMessage, clearForm };
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

.warning {
  color: red;
  margin-top: 10px;
}

.success {
  color: green;
  margin-top: 10px;
}

/* Add spacing between buttons */
.register-button {
  margin-right: 10px;
}
</style>
