<script setup>
import { ref, onMounted } from 'vue'
import Navbar from '../components/Navbar.vue'
import { Waves, Database, Fish, Code, Sparkles, Users, Linkedin, Mail } from 'lucide-vue-next'

const isLoaded = ref(false)
const showContent = ref(false)

onMounted(() => {
  setTimeout(() => {
    isLoaded.value = true
  }, 100)

  setTimeout(() => {
    showContent.value = true
  }, 400)
})
</script>

<template>
  <Navbar />
  <div class="relative min-h-screen text-white bg-slate-900 pt-20">

    <!-- IMAGE DE FOND AVEC ANIMATION -->
    <div
      class="absolute inset-0 transition-all duration-[2000ms] ease-out"
      :class="isLoaded ? 'opacity-100' : 'opacity-0'"
    >
      <img
        src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=1920&q=80"
        alt="Océan"
        class="absolute inset-0 w-full h-full object-cover"
      />
    </div>

    <!-- OVERLAY DÉGRADÉ -->
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900/95 via-blue-900/85 to-cyan-800/75"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-slate-900/60"></div>

    <!-- CONTENU PRINCIPAL -->
    <main class="relative z-10 max-w-7xl mx-auto px-6 py-12">
      
      <!-- En-tête de la page -->
      <div
        class="mb-12 transition-all duration-700 ease-out delay-100"
        :class="showContent ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
      >
        <h1 class="text-4xl md:text-5xl font-light mb-4">
          Notre Équipe
        </h1>
        <p class="text-white/60 text-lg max-w-2xl leading-relaxed">
          Découvrez les experts passionnés qui travaillent à comprendre et protéger nos océans
        </p>
      </div>

      <!-- Team Grid -->
      <div
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto transition-all duration-700 ease-out delay-200"
        :class="showContent ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
      >
        <!-- Team Member 1 -->
        <div class="group bg-slate-800/40 backdrop-blur-sm rounded-2xl p-6 border border-blue-500/20 hover:border-cyan-400/50 transition-all duration-300 hover:transform hover:scale-105">
          <div class="relative mb-6">
            <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-cyan-400 to-blue-600 p-1">
              <img 
                :src="`/placeholder.svg?height=128&width=128&query=oceanographer+portrait`" 
                alt="Ahmed"
                class="w-full h-full rounded-full object-cover bg-slate-700"
              />
            </div>
          </div>
          <div class="text-center">
            <h3 class="text-xl font-semibold text-white mb-2"> Ahmed</h3>
            <p class="text-cyan-400 font-medium mb-3">Chef de projet</p>
            <p class="text-blue-200/80 text-sm leading-relaxed mb-4">
                Coordination de l’équipe, planification des tâches et garantie du respect des objectifs et des délais du projet
            </p>
          </div>
        </div>

        <!-- Team Member 2 -->
        <div class="group bg-slate-800/40 backdrop-blur-sm rounded-2xl p-6 border border-blue-500/20 hover:border-cyan-400/50 transition-all duration-300 hover:transform hover:scale-105">
          <div class="relative mb-6">
            <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-cyan-400 to-blue-600 p-1">
              <img 
                :src="`/placeholder.svg?height=128&width=128&query=data+scientist+portrait`" 
                alt="Zayd"
                class="w-full h-full rounded-full object-cover bg-slate-700"
              />
            </div>
          </div>
          <div class="text-center">
            <h3 class="text-xl font-semibold text-white mb-2">Zayd</h3>
            <p class="text-cyan-400 font-medium mb-3">Développeur Frontend</p>
            <p class="text-blue-200/80 text-sm leading-relaxed mb-4">
              Création d’interfaces utilisateur claires, intuitives et responsives pour la visualisation des données
            </p>
          </div>
        </div>

        <!-- Team Member 3 -->
        <div class="group bg-slate-800/40 backdrop-blur-sm rounded-2xl p-6 border border-blue-500/20 hover:border-cyan-400/50 transition-all duration-300 hover:transform hover:scale-105">
          <div class="relative mb-6">
            <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-cyan-400 to-blue-600 p-1">
              <img 
                :src="`/placeholder.svg?height=128&width=128&query=marine+biologist+portrait`" 
                alt="Ryan"
                class="w-full h-full rounded-full object-cover bg-slate-700"
              />
            </div>
          </div>
          <div class="text-center">
            <h3 class="text-xl font-semibold text-white mb-2">Ryan</h3>
            <p class="text-cyan-400 font-medium mb-3">Développeur Backend</p>
            <p class="text-blue-200/80 text-sm leading-relaxed mb-4">
              Gestion de la logique métier et communication entre la base de données et l’application
            </p>
          </div>
        </div>

        <!-- Team Member 4 -->
        <div class="group bg-slate-800/40 backdrop-blur-sm rounded-2xl p-6 border border-blue-500/20 hover:border-cyan-400/50 transition-all duration-300 hover:transform hover:scale-105">
          <div class="relative mb-6">
            <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-cyan-400 to-blue-600 p-1">
              <img 
                :src="`/placeholder.svg?height=128&width=128&query=software+engineer+portrait`" 
                alt="Adam"
                class="w-full h-full rounded-full object-cover bg-slate-700"
              />
            </div>
          </div>
          <div class="text-center">
            <h3 class="text-xl font-semibold text-white mb-2">Adam</h3>
            <p class="text-cyan-400 font-medium mb-3">Gestionnaire de Base de Données</p>
            <p class="text-blue-200/80 text-sm leading-relaxed mb-4">
              Conception, optimisation et sécurisation des bases de données pour garantir la fiabilité et la cohérence des données
            </p>
          </div>
        </div>

        <!-- Team Member 5 -->
        <div class="group bg-slate-800/40 backdrop-blur-sm rounded-2xl p-6 border border-blue-500/20 hover:border-cyan-400/50 transition-all duration-300 hover:transform hover:scale-105">
          <div class="relative mb-6">
            <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-cyan-400 to-blue-600 p-1">
              <img 
                src="/team/fiona.JPG" 
                alt="Fiona"
                class="w-full h-full rounded-full object-cover bg-slate-700"
              />
            </div>
          </div>
          <div class="text-center">
            <h3 class="text-xl font-semibold text-white mb-2">Fiona</h3>
            <p class="text-cyan-400 font-medium mb-3">Analyste de Données</p>
            <p class="text-blue-200/80 text-sm leading-relaxed mb-4">
              Traitement, analyse et mise en forme des données à travers des visualisations interactives et lisibles
            </p>
          </div>
        </div>

        <!-- Team Member 6 -->
        <div class="group bg-slate-800/40 backdrop-blur-sm rounded-2xl p-6 border border-blue-500/20 hover:border-cyan-400/50 transition-all duration-300 hover:transform hover:scale-105">
          <div class="relative mb-6">
            <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-cyan-400 to-blue-600 p-1">
              <img 
                :src="`/placeholder.svg?height=128&width=128&query=communications+manager+portrait`" 
                alt="Selmane"
                class="w-full h-full rounded-full object-cover bg-slate-700"
              />
            </div>
          </div>
          <div class="text-center">
            <h3 class="text-xl font-semibold text-white mb-2">Selmane</h3>
            <p class="text-cyan-400 font-medium mb-3">Responsable Tests</p>
            <p class="text-blue-200/80 text-sm leading-relaxed mb-4">
              Tests fonctionnels, validation de la stabilité de l’application et rédaction de la documentation du projet
            </p>
          </div>
        </div>
      </div>

    </main>
  </div>
</template>

<style scoped>
/* Animations additionnelles si nécessaire */
</style>