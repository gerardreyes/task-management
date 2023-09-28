import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router';

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    redirect: '/login', // Redirect to the login page by default
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('@/views/LoginView.vue'), // Create this view
  },
  {
    path: '/register',
    name: 'Register',
    component: () => import('@/views/RegisterView.vue'), // Create this view
  },
  {
    path: '/about',
    name: 'About',
    component: () => import('@/views/AboutView.vue'), // Check the component import path
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
