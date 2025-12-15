<script setup>
import { ref, onMounted } from 'vue'

const isLoaded = ref(false)
const showNavbar = ref(false)
const showBadge = ref(false)
const showHero = ref(false)
const showButton = ref(false)

onMounted(() => {
  setTimeout(() => {
    isLoaded.value = true
  }, 100)

  setTimeout(() => {
    showNavbar.value = true
  }, 400)

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
  <div class="relative min-h-screen text-white bg-slate-900">

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



    <!-- NAVBAR -->
    <div class="relative z-20 flex justify-center pt-8 px-4">
      <header
        class="inline-flex items-center justify-between gap-6 md:gap-12
               px-6 md:px-10 py-4
               rounded-2xl
               backdrop-blur-xl
               bg-white/5
               border border-white/10
               shadow-2xl shadow-black/20
               transition-all duration-700 ease-out"
        :class="showNavbar
          ? 'opacity-100 translate-y-0'
          : 'opacity-0 -translate-y-8'"
      >
        <!-- Logo -->
        <div class="flex items-center gap-3 font-semibold tracking-wide text-lg">
          
          <span class="bg-gradient-to-r from-white to-cyan-200 bg-clip-text text-transparent">
            AquaView
          </span>
        </div>

        <!-- Menu -->
        <nav class="hidden md:flex gap-8 text-sm">
          <a
            v-for="item in ['Accueil', 'Explorer', 'Données', 'Équipe']"
            :key="item"
            class="relative text-white/70 hover:text-white transition-colors duration-300 cursor-pointer group"
          >
            {{ item }}
            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-cyan-400 to-blue-400 transition-all duration-300 group-hover:w-full"></span>
          </a>
        </nav>

        <!-- Bouton -->
        <button
          class="px-6 py-2.5 rounded-xl
                 bg-gradient-to-r from-cyan-500/20 to-blue-500/20
                 border border-white/20
                 text-sm font-medium
                 hover:from-cyan-500/30 hover:to-blue-500/30
                 hover:border-white/40
                 hover:shadow-lg hover:shadow-cyan-500/20
                 transition-all duration-300"
        >
          Connexion
        </button>
      </header>
    </div>

    <!-- HERO -->
    <section
      class="relative z-10 flex flex-col items-center justify-center
             py-8 md:py-12
             px-6 text-center"
    >

      <!-- Titre principal -->
      <h1
        class="text-5xl md:text-7xl font-extralight tracking-tight leading-tight
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
        class="mt-8 max-w-2xl text-lg md:text-xl text-white/60 leading-relaxed
               transition-all duration-700 ease-out delay-200"
        :class="showHero ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
      >
        Un phénomène invisible qui menace la vie marine
        et l'équilibre de notre planète. Explorez les données en temps réel.
      </p>

      <!-- Boutons -->
      <div
        class="mt-12 flex flex-col sm:flex-row gap-4
               transition-all duration-700 ease-out"
        :class="showButton ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
      >
        <button
          class="group px-10 py-4 rounded-2xl
                 bg-gradient-to-r from-cyan-500 to-blue-500
                 text-slate-900 font-semibold
                 shadow-xl shadow-cyan-500/30
                 hover:shadow-2xl hover:shadow-cyan-500/40
                 hover:scale-105
                 transition-all duration-300"
        >
          <span class="flex items-center gap-2">
            Démarrer l'analyse
            <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
          </span>
        </button>

        <button
          class="px-10 py-4 rounded-2xl
                 bg-white/5 border border-white/20
                 font-medium
                 hover:bg-white/10 hover:border-white/30
                 transition-all duration-300"
        >
          En savoir plus
        </button>
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
