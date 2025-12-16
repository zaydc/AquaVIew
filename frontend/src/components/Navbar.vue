<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'

const router = useRouter()
const route = useRoute()
const isLoggedIn = computed(() => {
  return localStorage.getItem('user') !== null
})

const user = computed(() => {
  const userStr = localStorage.getItem('user')
  return userStr ? JSON.parse(userStr) : null
})

const handleLogout = () => {
  localStorage.removeItem('user')
  router.push('/login')
}

const navigateTo = (path) => {
  router.push(path)
}

const isActive = (path) => {
  return route.path === path
}

const navItems = [
  { label: 'Accueil', path: '/' },
  { label: 'Analyse', path: '/analyse' },
  { label: 'Données', path: '#' },
  { label: 'Équipe', path: '/equipe' },
  { label: 'En savoir plus', path: '/en-savoir-plus' }
]
</script>

<template>
  <!-- Floating Top Navigation -->
  <div class="fixed top-0 left-0 right-0 z-50 flex justify-center px-4 pt-6">
    <header
      class="inline-flex items-center justify-between gap-6 md:gap-12
             px-6 md:px-10 py-4
             rounded-2xl
             backdrop-blur-xl
             bg-white/5
             border border-white/10
             shadow-2xl shadow-black/20
             transition-all duration-300"
    >
      <!-- Logo -->
      <div class="flex items-center gap-3 font-semibold tracking-wide text-lg cursor-pointer" @click="navigateTo('/')">
        <span class="bg-gradient-to-r from-white to-cyan-200 bg-clip-text text-transparent">
          AquaView
        </span>
      </div>

      <!-- Desktop Navigation -->
      <nav class="hidden md:flex gap-8 text-sm">
        <a
          v-for="item in navItems"
          :key="item.path"
          @click.prevent="navigateTo(item.path)"
          :href="item.path"
          class="relative text-white/70 hover:text-white transition-colors duration-300 cursor-pointer group"
          :class="{ 'text-white': isActive(item.path) }"
        >
          {{ item.label }}
          <span 
            class="absolute -bottom-1 left-0 h-0.5 bg-gradient-to-r from-cyan-400 to-blue-400 transition-all duration-300"
            :class="isActive(item.path) ? 'w-full' : 'w-0 group-hover:w-full'"
          ></span>
        </a>
      </nav>

      <!-- Right Side Menu -->
      <div class="hidden md:flex items-center gap-4">
        <div v-if="isLoggedIn" class="flex items-center gap-4">
          <span class="text-white/70 text-sm">{{ user?.email }}</span>
          <button
            @click="handleLogout"
            class="px-4 py-2.5 rounded-xl
                   bg-gradient-to-r from-red-500/20 to-red-500/20
                   border border-red-500/30
                   text-red-300 hover:bg-red-500/30
                   transition-colors duration-300
                   text-sm font-medium"
          >
            Déconnexion
          </button>
        </div>
        <div v-else class="flex items-center gap-3">
          <button
            @click="navigateTo('/login')"
            class="px-6 py-2.5 rounded-xl
                   bg-gradient-to-r from-cyan-500/20 to-blue-500/20
                   border border-white/20
                   text-sm font-medium text-white/70
                   hover:from-cyan-500/30 hover:to-blue-500/30
                   hover:border-white/40
                   hover:shadow-lg hover:shadow-cyan-500/20
                   transition-all duration-300"
          >
            Connexion
          </button>
          <button
            @click="navigateTo('/register')"
            class="px-6 py-2.5 rounded-xl
                   bg-gradient-to-r from-cyan-500 to-blue-600
                   text-white
                   hover:shadow-lg hover:shadow-cyan-500/50
                   transition-all duration-300
                   text-sm font-medium"
          >
            S'inscrire
          </button>
        </div>
      </div>

      <!-- Mobile Menu Button -->
      <button
        @click="toggleMobileMenu"
        class="md:hidden text-white/70 hover:text-white transition-colors"
      >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>
    </header>
  </div>
</template>

<style scoped>
</style>
