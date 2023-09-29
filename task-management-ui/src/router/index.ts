// Import necessary modules
import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router';
import { useAuthStore } from '@/store/auth'; // Import your auth store

// Define a navigation guard function
const isAuthenticated = () => {
  const authStore = useAuthStore(); // Use the auth store
  return authStore.isAuthenticated; // Check if the user is authenticated
};

// Define your routes
const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    component: () => import('@/views/HomeView.vue'),
  },
  {
    path: '/home',
    component: () => import('@/views/HomeView.vue'),
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('@/views/LoginView.vue'),
    // Add a meta field to specify that this route does not require authentication
    meta: { requiresAuth: false },
  },
  {
    path: '/register',
    name: 'Register',
    component: () => import('@/views/RegisterView.vue'),
  },
  {
    path: '/about',
    name: 'About',
    component: () => import('@/views/AboutView.vue'),
  },
  {
    path: '/tasks',
    name: 'TaskView',
    component: () => import('@/views/TaskView.vue'),
    meta: { requiresAuth: true },
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Allow access if authenticated
      } else {
        next('/home'); // Redirect to home if not authenticated
      }
    },
  },
];

// Create the router
const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
