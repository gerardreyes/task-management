import axios from 'axios';

// Set the base URL for Axios
// axios.defaults.baseURL = '/api'; // http://localhost
axios.defaults.baseURL = 'http://localhost/api'; // http://localhost

import { createApp } from 'vue';
import App from './App.vue';
import { createPinia } from 'pinia'; // Import Pinia
import router from './router';

const app = createApp(App).use(createPinia());

const pinia = createPinia();
app.use(pinia);
app.use(router);
app.mount('#app');
