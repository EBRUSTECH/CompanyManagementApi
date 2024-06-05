import { createRouter, createWebHistory } from "vue-router";
import HomePage from "./views/HomePage.vue";
import UserDashboard from "./views/UserDashboard.vue";
import UserProfile from "./views/UserProfile.vue";
import LoginForm from "./components/LoginForm.vue";
import RegisterForm from "./components/RegisterForm.vue";
import auth from "./api/auth";

const routes = [
  { path: "/", component: HomePage },
  {
    path: "/dashboard",
    component: UserDashboard,
    meta: { requiresAuth: true },
  },
  { path: "/profile", component: UserProfile, meta: { requiresAuth: true } },
  { path: "/login", name: "Login", component: LoginForm },
  { path: "/register", component: RegisterForm },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Navigation guard to check if the route requires authentication
router.beforeEach(async (to, from, next) => {
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    // Check if user is authenticated
    if (!auth.isAuthenticated()) {
      // Redirect to login page if not authenticated
      next({ name: "Login", query: { redirect: to.fullPath } });
    } else {
      next(); // Proceed to the next middleware
    }
  } else {
    next(); // Proceed to the next middleware
  }
});

export default router;
