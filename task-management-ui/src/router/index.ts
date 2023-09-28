import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router';

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    redirect: '/login', // Redirect to the login page by default
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('@/views/LoginView.vue'),
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

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

// Add a global navigation guard to check for authentication
router.beforeEach((to, from, next) => {
  const requiresAuth = to.matched.some((record) => record.meta.requiresAuth);

  // Replace this with your actual authentication logic (e.g., checking if the user is logged in)
  const isLoggedIn = true; // Example: Assuming the user is logged in

  if (requiresAuth && !isLoggedIn) {
    // If the route requires authentication and the user is not logged in, redirect to the login page
    next('/login'); // Replace '/login' with your actual login route
  } else {
    // If no authentication is required or the user is logged in, proceed to the route
    next();
  }
});

export default router;
