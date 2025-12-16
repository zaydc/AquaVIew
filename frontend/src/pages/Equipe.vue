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
                alt="Zayd Crombez"
                class="w-full h-full rounded-full object-cover bg-slate-700"
              />
            </div>
            <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-cyan-400 rounded-full p-2">
              <Waves class="w-5 h-5 text-slate-900" />
            </div>
          </div>
          <div class="text-center">
            <h3 class="text-xl font-semibold text-white mb-2"> Zayd Crombez</h3>
            <p class="text-cyan-400 font-medium mb-3">Chargé du développement du front-end</p>
            <p class="text-blue-200/80 text-sm leading-relaxed mb-4">
                Développement d'interfaces utilisateur intuitives pour la visualisation des données océaniques
            </p>
          </div>
        </div>

        <!-- Team Member 2 -->
        <div class="group bg-slate-800/40 backdrop-blur-sm rounded-2xl p-6 border border-blue-500/20 hover:border-cyan-400/50 transition-all duration-300 hover:transform hover:scale-105">
          <div class="relative mb-6">
            <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-cyan-400 to-blue-600 p-1">
              <img 
                :src="`/placeholder.svg?height=128&width=128&query=data+scientist+portrait`" 
                alt="Marc Dubois"
                class="w-full h-full rounded-full object-cover bg-slate-700"
              />
            </div>
            <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-cyan-400 rounded-full p-2">
              <Database class="w-5 h-5 text-slate-900" />
            </div>
          </div>
          <div class="text-center">
            <h3 class="text-xl font-semibold text-white mb-2">Marc Dubois</h3>
            <p class="text-cyan-400 font-medium mb-3">Analyste de Données</p>
            <p class="text-blue-200/80 text-sm leading-relaxed mb-4">
              Expert en traitement et visualisation des données océaniques
            </p>
            <div class="flex justify-center gap-3">
              <a href="#" class="text-blue-300 hover:text-cyan-400 transition-colors">
                <Linkedin class="w-5 h-5" />
              </a>
              <a href="#" class="text-blue-300 hover:text-cyan-400 transition-colors">
                <Mail class="w-5 h-5" />
              </a>
            </div>
          </div>
        </div>

        <!-- Team Member 3 -->
        <div class="group bg-slate-800/40 backdrop-blur-sm rounded-2xl p-6 border border-blue-500/20 hover:border-cyan-400/50 transition-all duration-300 hover:transform hover:scale-105">
          <div class="relative mb-6">
            <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-cyan-400 to-blue-600 p-1">
              <img 
                :src="`/placeholder.svg?height=128&width=128&query=marine+biologist+portrait`" 
                alt="Emma Chen"
                class="w-full h-full rounded-full object-cover bg-slate-700"
              />
            </div>
            <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-cyan-400 rounded-full p-2">
              <Fish class="w-5 h-5 text-slate-900" />
            </div>
          </div>
          <div class="text-center">
            <h3 class="text-xl font-semibold text-white mb-2">Emma Chen</h3>
            <p class="text-cyan-400 font-medium mb-3">Biologiste Marine</p>
            <p class="text-blue-200/80 text-sm leading-relaxed mb-4">
              Recherche sur l'impact de l'hypoxie sur les écosystèmes marins
            </p>
            <div class="flex justify-center gap-3">
              <a href="#" class="text-blue-300 hover:text-cyan-400 transition-colors">
                <Linkedin class="w-5 h-5" />
              </a>
              <a href="#" class="text-blue-300 hover:text-cyan-400 transition-colors">
                <Mail class="w-5 h-5" />
              </a>
            </div>
          </div>
        </div>

        <!-- Team Member 4 -->
        <div class="group bg-slate-800/40 backdrop-blur-sm rounded-2xl p-6 border border-blue-500/20 hover:border-cyan-400/50 transition-all duration-300 hover:transform hover:scale-105">
          <div class="relative mb-6">
            <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-cyan-400 to-blue-600 p-1">
              <img 
                :src="`/placeholder.svg?height=128&width=128&query=software+engineer+portrait`" 
                alt="Thomas Martin"
                class="w-full h-full rounded-full object-cover bg-slate-700"
              />
            </div>
            <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-cyan-400 rounded-full p-2">
              <Code class="w-5 h-5 text-slate-900" />
            </div>
          </div>
          <div class="text-center">
            <h3 class="text-xl font-semibold text-white mb-2">Thomas Martin</h3>
            <p class="text-cyan-400 font-medium mb-3">Développeur Full-Stack</p>
            <p class="text-blue-200/80 text-sm leading-relaxed mb-4">
              Création de plateformes innovantes pour la recherche océanique
            </p>
            <div class="flex justify-center gap-3">
              <a href="#" class="text-blue-300 hover:text-cyan-400 transition-colors">
                <Linkedin class="w-5 h-5" />
              </a>
              <a href="#" class="text-blue-300 hover:text-cyan-400 transition-colors">
                <Mail class="w-5 h-5" />
              </a>
            </div>
          </div>
        </div>

        <!-- Team Member 5 -->
        <div class="group bg-slate-800/40 backdrop-blur-sm rounded-2xl p-6 border border-blue-500/20 hover:border-cyan-400/50 transition-all duration-300 hover:transform hover:scale-105">
          <div class="relative mb-6">
            <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-cyan-400 to-blue-600 p-1">
              <img 
                :src="`/placeholder.svg?height=128&width=128&query=environmental+scientist+portrait`" 
                alt="Léa Rousseau"
                class="w-full h-full rounded-full object-cover bg-slate-700"
              />
            </div>
            <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-cyan-400 rounded-full p-2">
              <Sparkles class="w-5 h-5 text-slate-900" />
            </div>
          </div>
          <div class="text-center">
            <h3 class="text-xl font-semibold text-white mb-2">Léa Rousseau</h3>
            <p class="text-cyan-400 font-medium mb-3">Scientifique Environnementale</p>
            <p class="text-blue-200/80 text-sm leading-relaxed mb-4">
              Modélisation climatique et prévision des zones hypoxiques
            </p>
            <div class="flex justify-center gap-3">
              <a href="#" class="text-blue-300 hover:text-cyan-400 transition-colors">
                <Linkedin class="w-5 h-5" />
              </a>
              <a href="#" class="text-blue-300 hover:text-cyan-400 transition-colors">
                <Mail class="w-5 h-5" />
              </a>
            </div>
          </div>
        </div>

        <!-- Team Member 6 -->
        <div class="group bg-slate-800/40 backdrop-blur-sm rounded-2xl p-6 border border-blue-500/20 hover:border-cyan-400/50 transition-all duration-300 hover:transform hover:scale-105">
          <div class="relative mb-6">
            <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-cyan-400 to-blue-600 p-1">
              <img 
                :src="`/placeholder.svg?height=128&width=128&query=communications+manager+portrait`" 
                alt="Alex Bernard"
                class="w-full h-full rounded-full object-cover bg-slate-700"
              />
            </div>
            <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-cyan-400 rounded-full p-2">
              <Users class="w-5 h-5 text-slate-900" />
            </div>
          </div>
          <div class="text-center">
            <h3 class="text-xl font-semibold text-white mb-2">Alex Bernard</h3>
            <p class="text-cyan-400 font-medium mb-3">Responsable Communication</p>
            <p class="text-blue-200/80 text-sm leading-relaxed mb-4">
              Sensibilisation du public aux enjeux de l'océan
            </p>
            <div class="flex justify-center gap-3">
              <a href="#" class="text-blue-300 hover:text-cyan-400 transition-colors">
                <Linkedin class="w-5 h-5" />
              </a>
              <a href="#" class="text-blue-300 hover:text-cyan-400 transition-colors">
                <Mail class="w-5 h-5" />
              </a>
            </div>
          </div>
        </div>
      </div>

    </main>
  </div>
</template>

<style scoped>
/* Animations additionnelles si nécessaire */
</style>