import { createRouter, createWebHistory } from 'vue-router'

import HomePage from '../pages/HomePage.vue'
import Analyse from '../pages/Analyse.vue'
import RegisterPage from '../pages/RegisterPage.vue'
import LoginPage from '../pages/LoginPage.vue'
import Equipe from '../pages/Equipe.vue'
import EnSavoirPlus from '../pages/EnSavoirPlus.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', name: 'home', component: HomePage },
    { path: '/analyse', name: 'analyse', component: Analyse },
    { path: '/register', name: 'register', component: RegisterPage },
    { path: '/login', name: 'login', component: LoginPage },
    { path: '/equipe', name: 'equipe', component: Equipe },
    { path: '/en-savoir-plus', name: 'en-savoir-plus', component: EnSavoirPlus }
  ],
  scrollBehavior() {
    return { top: 0 }
  }
})

export default router
