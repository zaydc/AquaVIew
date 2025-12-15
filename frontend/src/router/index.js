import { createRouter, createWebHistory } from "vue-router";
import HomePage from "../pages/HomePage.vue";

export default createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: "/",
      component: HomePage,
      name: "home"
    }
    // Ajoute d'autres routes ici au fur et à mesure
  ]
});
