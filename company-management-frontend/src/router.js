import { createRouter, createWebHistory } from "vue-router";
import HomePage from "./views/HomePage.vue";
import UserDashboard from "./views/UserDashboard.vue";
import UserProfile from "./views/UserProfile.vue";
import LoginForm from "./components/LoginForm.vue";
import RegisterForm from "./components/RegisterForm.vue";

const routes = [
  { path: "/", component: HomePage },
  { path: "/dashboard", component: UserDashboard },
  { path: "/profile", component: UserProfile },
  { path: "/login", component: LoginForm },
  { path: "/register", component: RegisterForm },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
