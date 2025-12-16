<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import Navbar from '../components/Navbar.vue'

const router = useRouter()

const isLoaded = ref(false)
const showBadge = ref(false)
const showHero = ref(false)
const showButton = ref(false)

const goToAnalyse = () => {
  router.push('/analyse')
}
const goToEnSavoirPlus = () => {
  router.push('/en-savoir-plus')
}

onMounted(() => {
  setTimeout(() => {
    isLoaded.value = true
  }, 100)

  setTimeout(() => {
    showBadge.value = true
  }, 700)

  setTimeout(() => {
    showHero.value = true
  }, 1000)

  setTimeout(() => {
    showButton.value = true
  }, 1600)
})
</script>

<template>
  <Navbar />
  <div class="relative min-h-screen text-white bg-slate-900 pt-20">

    <!-- IMAGE DE FOND AVEC ANIMATION -->
    <div
      class="absolute inset-0 transition-all duration-[2500ms] ease-out"
      :class="isLoaded ? 'opacity-100 scale-100' : 'opacity-0 scale-110'"
    >
      <img
        src="https://images.unsplash.com/photo-1518837695005-2083093ee35b?w=1920&q=80"
        alt="Océan"
        class="absolute inset-0 w-full h-full object-cover"
      />
    </div>

    <!-- OVERLAY DÉGRADÉ -->
    <div
      class="absolute inset-0 transition-opacity duration-[1500ms]"
      :class="isLoaded ? 'opacity-100' : 'opacity-0'"
    >
      <div class="absolute inset-0 bg-gradient-to-br from-slate-900/95 via-blue-900/80 to-cyan-800/70"></div>
      <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent"></div>
    </div>

    <!-- HERO - Disposition gauche/droite -->
    <section
      class="relative z-10 container mx-auto px-6 py-12 md:py-20
             min-h-[calc(100vh-5rem)] flex items-center"
    >
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 w-full items-center">
        
        <!-- COLONNE GAUCHE - Texte -->
        <div class="space-y-8">
          <!-- Titre principal -->
          <h1
            class="text-4xl md:text-6xl lg:text-7xl font-extralight tracking-tight leading-[1.3]

                   transition-all duration-700 ease-out"
            :class="showHero ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
          >
            <span class="block">Comprendre la</span>
            <span class="block mt-2 font-medium bg-gradient-to-r from-cyan-300 via-blue-300 to-teal-300 bg-clip-text text-transparent">
              désoxygénation
            </span>
            <span class="block mt-2">des océans</span>
          </h1>

          <!-- Description -->
          <p
            class="text-lg md:text-xl text-white/70 leading-relaxed max-w-xl
                   transition-all duration-700 ease-out delay-200"
            :class="showHero ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
          >
            Un phénomène invisible qui menace la vie marine
            et l'équilibre de notre planète. Explorez les données en temps réel.
          </p>

          <!-- Bouton En savoir plus -->
          <div
            class="transition-all duration-700 ease-out delay-300"
            :class="showButton ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
          >
            <button
            @click="goToEnSavoirPlus"
              class="px-8 py-3 rounded-xl
                     bg-white/5 border border-white/20
                     font-medium text-white/80
                     hover:bg-white/10 hover:border-white/30
                     transition-all duration-300"
            >
              En savoir plus
            </button>
          </div>
        </div>

        <!-- COLONNE DROITE - Section interactive avec bouton -->
        <div
          class="relative transition-all duration-700 ease-out delay-400"
          :class="showButton ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
        >
          <!-- Carte interactive avec visualisation -->
          <div class="relative p-8 rounded-3xl
                     backdrop-blur-xl bg-white/5 border border-white/10
                     shadow-2xl shadow-black/30">
            
            <!-- Visualisation de données (placeholder stylé) -->
            <div class="mb-8 space-y-4">
              <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-white">Données en temps réel</h3>
                <div class="flex items-center gap-2">
                  <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                  <span class="text-sm text-white/60">Actif</span>
                </div>
              </div>

              <!-- Graphique simple en barres -->
              <div class="relative h-32 rounded-xl bg-white/5 border border-white/10 p-4">
  <div class="flex items-end justify-between gap-2 h-full">
    
    <div
      class="flex-1 rounded-t
             bg-gradient-to-t from-white/30 to-white/10
             transition-all duration-500
             hover:from-white/50 hover:to-white/20"
      style="height: 60%">
    </div>

    <div
      class="flex-1 rounded-t
             bg-gradient-to-t from-white/35 to-white/15
             transition-all duration-500
             hover:from-white/55 hover:to-white/25"
      style="height: 80%">
    </div>

    <div
      class="flex-1 rounded-t
             bg-gradient-to-t from-white/25 to-white/10
             transition-all duration-500
             hover:from-white/45 hover:to-white/20"
      style="height: 45%">
    </div>

    <div
      class="flex-1 rounded-t
             bg-gradient-to-t from-white/30 to-white/12
             transition-all duration-500
             hover:from-white/50 hover:to-white/22"
      style="height: 70%">
    </div>

    <div
      class="flex-1 rounded-t
             bg-gradient-to-t from-white/28 to-white/12
             transition-all duration-500
             hover:from-white/48 hover:to-white/22"
      style="height: 55%">
    </div>

  </div>
</div>


              <!-- Statistiques rapides -->
              <div class="grid grid-cols-3 gap-4 mt-6">
                <div class="text-center p-4 rounded-xl bg-white/5 border border-white/10">
                  <div class="text-2xl font-bold text-cyan-400">3.2</div>
                  <div class="text-xs text-white/60 mt-1">mg/L</div>
                </div>
                <div class="text-center p-4 rounded-xl bg-white/5 border border-white/10">
                  <div class="text-2xl font-bold text-blue-400">18.5</div>
                  <div class="text-xs text-white/60 mt-1">°C</div>
                </div>
                <div class="text-center p-4 rounded-xl bg-white/5 border border-white/10">
                  <div class="text-2xl font-bold text-teal-400">24</div>
                  <div class="text-xs text-white/60 mt-1">Stations</div>
                </div>
              </div>
            </div>

            <!-- Bouton principal Démarrer l'analyse -->
            <button
              @click="goToAnalyse"
              class="group w-full px-8 py-5 rounded-2xl
                     bg-gradient-to-r from-cyan-500 to-blue-500
                     text-slate-900 font-semibold text-lg
                     shadow-xl shadow-cyan-500/30
                     hover:shadow-2xl hover:shadow-cyan-500/40
                     hover:scale-[1.02]
                     transition-all duration-300
                     flex items-center justify-center gap-3"
            >
              <span>Démarrer l'analyse</span>
              <svg class="w-6 h-6 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
              </svg>
            </button>
          </div>
        </div>

      </div>
    </section>

  </div>
</template>

<style scoped>
@keyframes float {
  0%, 100% {
    transform: translateY(0) translateX(0);
  }
  25% {
    transform: translateY(-20px) translateX(10px);
  }
  50% {
    transform: translateY(-10px) translateX(-10px);
  }
  75% {
    transform: translateY(-30px) translateX(5px);
  }
}

.animate-float {
  animation: float 8s ease-in-out infinite;
}
</style>
