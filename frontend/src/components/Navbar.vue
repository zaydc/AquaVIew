<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const isMobileMenuOpen = ref(false)

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
  isMobileMenuOpen.value = false
}
</script>

<template>
  <nav class="fixed top-0 left-0 right-0 z-50 backdrop-blur-xl bg-white/5 border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <!-- Logo -->
        <div class="flex items-center gap-3 cursor-pointer" @click="navigateTo('/')">
          <div class="w-8 h-8 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-lg flex items-center justify-center">
            <span class="text-white font-bold text-sm">AV</span>
          </div>
          <span class="bg-gradient-to-r from-white to-cyan-200 bg-clip-text text-transparent font-semibold text-lg">
            AquaView
          </span>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center gap-8">
          <button @click="navigateTo('/')" class="text-white/70 hover:text-white transition-colors duration-300 text-sm font-medium">
            Accueil
          </button>
          <button @click="navigateTo('/analyse')" class="text-white/70 hover:text-white transition-colors duration-300 text-sm font-medium">
            Analyse
          </button>
          <a href="#" class="text-white/70 hover:text-white transition-colors duration-300 text-sm font-medium">
            Données
          </a>
        </div>

        <!-- Right Side Menu -->
        <div class="hidden md:flex items-center gap-4">
          <div v-if="isLoggedIn" class="flex items-center gap-4">
            <span class="text-white/70 text-sm">{{ user?.email }}</span>
            <button
              @click="handleLogout"
              class="px-4 py-2 rounded-lg bg-red-500/20 text-red-300 hover:bg-red-500/30 transition-colors duration-300 text-sm font-medium border border-red-500/30"
            >
              Déconnexion
            </button>
          </div>
          <div v-else class="flex items-center gap-3">
            <button
              @click="navigateTo('/login')"
              class="px-4 py-2 text-white/70 hover:text-white transition-colors duration-300 text-sm font-medium"
            >
              Connexion
            </button>
            <button
              @click="navigateTo('/register')"
              class="px-4 py-2 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 text-white hover:shadow-lg hover:shadow-cyan-500/50 transition-all duration-300 text-sm font-medium"
            >
              S'inscrire
            </button>
          </div>
        </div>

        <!-- Mobile Menu Button -->
        <button
          @click="isMobileMenuOpen = !isMobileMenuOpen"
          class="md:hidden text-white/70 hover:text-white transition-colors"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>

      <!-- Mobile Menu -->
      <div v-if="isMobileMenuOpen" class="md:hidden border-t border-white/10 py-4 space-y-2">
        <button @click="navigateTo('/')" class="block w-full text-left px-4 py-2 text-white/70 hover:text-white hover:bg-white/5 rounded transition-colors">
          Accueil
        </button>
        <button @click="navigateTo('/analyse')" class="block w-full text-left px-4 py-2 text-white/70 hover:text-white hover:bg-white/5 rounded transition-colors">
          Analyse
        </button>
        <a href="#" class="block px-4 py-2 text-white/70 hover:text-white hover:bg-white/5 rounded transition-colors">
          Données
        </a>

        <div class="border-t border-white/10 pt-4 mt-4 space-y-2">
          <div v-if="isLoggedIn" class="space-y-2">
            <span class="block px-4 py-2 text-white/70 text-sm">{{ user?.email }}</span>
            <button
              @click="handleLogout"
              class="block w-full text-left px-4 py-2 text-red-300 hover:bg-red-500/20 rounded transition-colors"
            >
              Déconnexion
            </button>
          </div>
          <div v-else class="space-y-2">
            <button @click="navigateTo('/login')" class="block w-full text-left px-4 py-2 text-white/70 hover:text-white hover:bg-white/5 rounded transition-colors">
              Connexion
            </button>
            <button @click="navigateTo('/register')" class="block w-full text-left px-4 py-2 text-white rounded bg-gradient-to-r from-cyan-500 to-blue-600 transition-colors">
              S'inscrire
            </button>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<style scoped>
</style>
