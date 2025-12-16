import { createRouter, createWebHistory } from "vue-router";
import HomePage from "../pages/HomePage.vue";
import Analyse from "../pages/Analyse.vue";
import RegisterPage from "../pages/RegisterPage.vue"; // <-- Import correct pour Register
import LoginPage from "../pages/LoginPage.vue"; // <-- Import correct pour Login
const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: "/", name: "home", component: HomePage },
    { path: "/analyse", name: "analyse", component: Analyse },
    { path: "/register", name: "register", component: RegisterPage }, // Route Register
    {path: "/login", name: "login",component: LoginPage}
  ],
});

export default router;