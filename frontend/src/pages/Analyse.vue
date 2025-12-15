<script setup>
import { ref, onMounted } from 'vue'

const isLoaded = ref(false)
const showContent = ref(false)

// Paramètres de sélection
const selectedRegion = ref('atlantique-nord')
const selectedPeriod = ref('30-jours')
const selectedMetric = ref('oxygene')

// Données d'analyse (exemple)
const regions = [
  { value: 'atlantique-nord', label: 'Atlantique Nord' },
  { value: 'pacifique', label: 'Pacifique' },
  { value: 'indien', label: 'Océan Indien' },
  { value: 'mediterranee', label: 'Méditerranée' }
]

const periods = [
  { value: '7-jours', label: '7 derniers jours' },
  { value: '30-jours', label: '30 derniers jours' },
  { value: '1-an', label: '1 an' },
  { value: '5-ans', label: '5 ans' }
]

const metrics = [
  { value: 'oxygene', label: 'Niveau d\'oxygène', unit: 'mg/L', color: 'cyan' },
  { value: 'temperature', label: 'Température', unit: '°C', color: 'orange' },
  { value: 'salinite', label: 'Salinité', unit: 'PSU', color: 'blue' },
  { value: 'ph', label: 'pH', unit: '', color: 'purple' }
]

// Données simulées pour les cartes
const analysisCards = ref([
  {
    title: 'Zone Critique Détectée',
    value: '3.2 mg/L',
    change: '-12%',
    status: 'danger',
    description: 'Niveau d\'oxygène critique dans la zone sélectionnée'
  },
  {
    title: 'Température Moyenne',
    value: '18.5°C',
    change: '+2.1°C',
    status: 'warning',
    description: 'Augmentation notable par rapport à la moyenne historique'
  },
  {
    title: 'Zone Surveillée',
    value: '2,450 km²',
    change: '+15%',
    status: 'info',
    description: 'Surface totale de la zone d\'analyse'
  },
  {
    title: 'Stations Actives',
    value: '24',
    change: '+3',
    status: 'success',
    description: 'Stations de mesure opérationnelles'
  }
])

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
  <div class="relative min-h-screen text-white bg-slate-900">

    <!-- IMAGE DE FOND -->
    <div
      class="absolute inset-0 transition-all duration-[2000ms] ease-out"
      :class="isLoaded ? 'opacity-100' : 'opacity-0'"
    >
      <img
        src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=1920&q=80"
        alt="Analyse océanique"
        class="absolute inset-0 w-full h-full object-cover"
      />
    </div>

    <!-- OVERLAY DÉGRADÉ -->
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900/95 via-blue-900/85 to-cyan-800/75"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-slate-900/60"></div>

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
        :class="showContent ? 'opacity-100 translate-y-0' : 'opacity-0 -translate-y-8'"
      >
        <div class="flex items-center gap-3 font-semibold tracking-wide text-lg">
          <span class="bg-gradient-to-r from-white to-cyan-200 bg-clip-text text-transparent">
            AquaView
          </span>
        </div>

        <nav class="hidden md:flex gap-8 text-sm">
          <a
            v-for="item in ['Accueil', 'Explorer', 'Données', 'Équipe']"
            :key="item"
            :href="item === 'Accueil' ? '/' : '#'"
            class="relative text-white/70 hover:text-white transition-colors duration-300 cursor-pointer group"
            :class="{ 'text-white': item === 'Explorer' }"
          >
            {{ item }}
            <span 
              class="absolute -bottom-1 left-0 h-0.5 bg-gradient-to-r from-cyan-400 to-blue-400 transition-all duration-300"
              :class="item === 'Explorer' ? 'w-full' : 'w-0 group-hover:w-full'"
            ></span>
          </a>
        </nav>

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

    <!-- CONTENU PRINCIPAL -->
    <main class="relative z-10 max-w-7xl mx-auto px-6 py-12">
      
      <!-- En-tête de la page -->
      <div
        class="mb-12 transition-all duration-700 ease-out delay-100"
        :class="showContent ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
      >
        <h1 class="text-4xl md:text-5xl font-light mb-4">
          Analyse des données
          <span class="block mt-2 font-medium bg-gradient-to-r from-cyan-300 to-blue-300 bg-clip-text text-transparent">
            océaniques
          </span>
        </h1>
        <p class="text-white/60 text-lg max-w-2xl leading-relaxed">
          Explorez les données de désoxygénation en temps réel et identifiez les zones critiques.
        </p>
      </div>

      <!-- Panneau de sélection -->
      <div
        class="mb-8 p-6 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10
               transition-all duration-700 ease-out delay-200"
        :class="showContent ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
      >
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          
          <!-- Sélection de région -->
          <div>
            <label class="block text-sm font-medium text-white/70 mb-2">
              Région océanique
            </label>
            <select
              v-model="selectedRegion"
              class="w-full px-4 py-3 rounded-xl
                     bg-white/5 border border-white/20
                     text-white
                     focus:outline-none focus:border-cyan-400/50 focus:bg-white/10
                     transition-all duration-300 cursor-pointer"
            >
              <option v-for="region in regions" :key="region.value" :value="region.value">
                {{ region.label }}
              </option>
            </select>
          </div>

          <!-- Sélection de période -->
          <div>
            <label class="block text-sm font-medium text-white/70 mb-2">
              Période d'analyse
            </label>
            <select
              v-model="selectedPeriod"
              class="w-full px-4 py-3 rounded-xl
                     bg-white/5 border border-white/20
                     text-white
                     focus:outline-none focus:border-cyan-400/50 focus:bg-white/10
                     transition-all duration-300 cursor-pointer"
            >
              <option v-for="period in periods" :key="period.value" :value="period.value">
                {{ period.label }}
              </option>
            </select>
          </div>

          <!-- Sélection de métrique -->
          <div>
            <label class="block text-sm font-medium text-white/70 mb-2">
              Métrique principale
            </label>
            <select
              v-model="selectedMetric"
              class="w-full px-4 py-3 rounded-xl
                     bg-white/5 border border-white/20
                     text-white
                     focus:outline-none focus:border-cyan-400/50 focus:bg-white/10
                     transition-all duration-300 cursor-pointer"
            >
              <option v-for="metric in metrics" :key="metric.value" :value="metric.value">
                {{ metric.label }}
              </option>
            </select>
          </div>

        </div>

        <!-- Bouton d'analyse -->
        <div class="mt-6 flex justify-end">
          <button
            class="group px-8 py-3 rounded-xl
                   bg-gradient-to-r from-cyan-500 to-blue-500
                   text-slate-900 font-semibold
                   shadow-lg shadow-cyan-500/30
                   hover:shadow-xl hover:shadow-cyan-500/40
                   hover:scale-105
                   transition-all duration-300"
          >
            <span class="flex items-center gap-2">
              Lancer l'analyse
              <svg class="w-5 h-5 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
              </svg>
            </span>
          </button>
        </div>
      </div>

      <!-- Cartes d'analyse -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div
          v-for="(card, index) in analysisCards"
          :key="index"
          class="p-6 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10
                 hover:bg-white/10 hover:border-white/20
                 transition-all duration-700 ease-out"
          :class="showContent ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
          :style="{ transitionDelay: `${300 + index * 100}ms` }"
        >
          <div class="flex items-start justify-between mb-4">
            <h3 class="text-sm font-medium text-white/70">{{ card.title }}</h3>
            <div
              class="w-2 h-2 rounded-full"
              :class="{
                'bg-red-400': card.status === 'danger',
                'bg-orange-400': card.status === 'warning',
                'bg-blue-400': card.status === 'info',
                'bg-green-400': card.status === 'success'
              }"
            ></div>
          </div>

          <div class="mb-2">
            <div class="text-3xl font-semibold text-white">{{ card.value }}</div>
            <div
              class="text-sm font-medium mt-1"
              :class="{
                'text-red-400': card.change.startsWith('-') || card.change.startsWith('+') && card.status === 'warning',
                'text-green-400': card.change.startsWith('+') && card.status === 'success',
                'text-cyan-400': card.status === 'info'
              }"
            >
              {{ card.change }}
            </div>
          </div>

          <p class="text-xs text-white/50 leading-relaxed">{{ card.description }}</p>
        </div>
      </div>

      <!-- Zone de visualisation -->
      <div
        class="p-8 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10
               transition-all duration-700 ease-out delay-500"
        :class="showContent ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
      >
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-2xl font-medium">Visualisation des données</h2>
          <div class="flex gap-2">
            <button
              v-for="view in ['Carte', 'Graphique', 'Tableau']"
              :key="view"
              class="px-4 py-2 rounded-lg text-sm
                     bg-white/5 border border-white/10
                     hover:bg-white/10 hover:border-white/20
                     transition-all duration-300"
              :class="view === 'Graphique' ? 'bg-white/10 border-white/20' : ''"
            >
              {{ view }}
            </button>
          </div>
        </div>

        <!-- Placeholder pour le graphique -->
        <div class="h-96 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center">
          <div class="text-center">
            <svg class="w-16 h-16 mx-auto mb-4 text-cyan-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <p class="text-white/50 text-lg">Graphique de désoxygénation</p>
            <p class="text-white/30 text-sm mt-2">Les données seront affichées ici</p>
          </div>
        </div>
      </div>

    </main>
  </div>
</template>

<style scoped>
select option {
  background-color: #0f172a;
  color: white;
}
</style>
