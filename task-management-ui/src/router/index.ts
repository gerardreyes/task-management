// Import necessary modules
import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router';
import { useAuthStore } from '@/store/auth'; // Import your Pinia store

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
    meta: { requiresAuth: true }, // Add this to indicate that this route requires authentication
  },
];

// Create the router
const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});


export default router;
