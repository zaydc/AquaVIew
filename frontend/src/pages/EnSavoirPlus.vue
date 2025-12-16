<script setup>
import { ref, onMounted } from 'vue'
import Navbar from '../components/Navbar.vue'

const isLoaded = ref(false)
const showContent = ref(false)

const sections = [
  {
    title: "Qu'est-ce que la désoxygénation ?",
    description: "La désoxygénation des océans est la diminution progressive de la concentration en oxygène dissous dans l'eau de mer. Ce phénomène touche aussi bien les eaux de surface que les profondeurs marines, créant des zones hypoxiques (pauvres en oxygène) et anoxiques (dépourvues d'oxygène).",
    points: null
  },
  {
    title: "Les Causes Principales",
    description: "La désoxygénation océanique résulte de plusieurs facteurs interconnectés :",
    points: [
      "Réchauffement climatique : L'augmentation de la température réduit la capacité de l'eau à retenir l'oxygène",
      "Eutrophisation : Les nutriments agricoles favorisent la prolifération d'algues qui consomment l'oxygène",
      "Pollution industrielle : Les rejets chimiques perturbent l'équilibre écologique",
      "Stratification océanique : Les couches d'eau se mélangent moins, limitant l'oxygénation des profondeurs"
    ]
  },
  {
    title: "Impact sur la Vie Marine",
    description: "Les conséquences de la désoxygénation sont dramatiques pour les écosystèmes marins :",
    points: [
      "Mortalité massive de poissons et d'organismes marins",
      "Migration forcée des espèces vers des eaux plus riches en oxygène",
      "Perturbation des chaînes alimentaires marines",
      "Réduction de la biodiversité dans les zones affectées",
      "Impacts sur l'industrie de la pêche et les économies locales"
    ]
  },
  {
    title: "Les Zones les Plus Touchées",
    description: "Certaines régions océaniques sont particulièrement vulnérables à la désoxygénation. Les zones mortes (zones hypoxiques sévères) se sont multipliées au cours des dernières décennies, notamment dans le Golfe du Mexique, la Mer Baltique, et certaines zones côtières d'Asie et d'Amérique du Sud.",
    points: null
  },
  {
    title: "Pourquoi Surveiller ?",
    description: "La surveillance continue des niveaux d'oxygène océanique est essentielle pour comprendre l'évolution du phénomène et anticiper ses impacts futurs. Les données en temps réel permettent aux scientifiques, décideurs politiques et communautés côtières de prendre des mesures préventives et correctives.",
    points: null
  },
  {
    title: "Solutions et Actions",
    description: "Plusieurs approches peuvent contribuer à atténuer la désoxygénation :",
    points: [
      "Réduction des émissions de gaz à effet de serre",
      "Limitation des rejets de nutriments agricoles",
      "Protection et restauration des écosystèmes côtiers",
      "Création de zones marines protégées",
      "Développement de technologies de surveillance avancées",
      "Sensibilisation et éducation du public"
    ]
  }
]

const statistics = [
  { value: "2%", label: "de l'oxygène océanique perdu depuis 1960" },
  { value: "500+", label: "zones mortes identifiées dans le monde" },
  { value: "4,5M", label: "km² d'océans affectés par l'hypoxie" }
]

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
        class="mb-16 transition-all duration-700 ease-out delay-100"
        :class="showContent ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
      >
        <h1 class="text-4xl md:text-5xl font-light mb-4">
          La Désoxygénation
          <span class="block mt-2 font-medium bg-gradient-to-r from-cyan-300 to-blue-300 bg-clip-text text-transparent">
            des Océans
          </span>
        </h1>
        <p class="text-white/60 text-lg max-w-2xl leading-relaxed">
          Un phénomène invisible qui menace la vie marine et l'équilibre de notre planète. Découvrez les causes, les conséquences et les solutions pour protéger nos océans.
        </p>
      </div>

      <!-- Sections d'information -->
      <div class="space-y-8 mb-16">
        <div
          v-for="(section, index) in sections"
          :key="index"
          class="group bg-slate-800/40 backdrop-blur-xl border border-white/20 rounded-2xl p-8 hover:bg-slate-800/60 hover:border-cyan-400/50 transition-all duration-300"
          :class="showContent ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
          :style="{ transitionDelay: showContent ? `${index * 100}ms` : '0ms' }"
        >
          <h2 class="text-2xl font-semibold text-white mb-4 group-hover:text-cyan-300 transition-colors">{{ section.title }}</h2>
          <p class="text-white/70 leading-relaxed mb-4">{{ section.description }}</p>
          <ul v-if="section.points" class="space-y-3">
            <li
              v-for="(point, idx) in section.points"
              :key="idx"
              class="flex items-start gap-3 text-white/60"
            >
              <svg class="w-5 h-5 text-cyan-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span>{{ point }}</span>
            </li>
          </ul>
        </div>
      </div>

      <!-- Section Statistiques -->
      <div
        class="mb-16 transition-all duration-700 ease-out delay-300"
        :class="showContent ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
      >
        <h2 class="text-3xl font-light mb-4">
          Chiffres Clés
          <span class="block font-medium bg-gradient-to-r from-cyan-300 to-blue-300 bg-clip-text text-transparent">
            alarmants
          </span>
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div
            v-for="(stat, index) in statistics"
            :key="index"
            class="bg-gradient-to-br from-slate-800/40 to-slate-900/40 backdrop-blur-xl border border-white/20 rounded-2xl p-8 text-center hover:scale-105 hover:border-cyan-400/50 transition-all duration-300"
          >
            <div class="text-5xl font-bold bg-gradient-to-r from-cyan-300 to-blue-300 bg-clip-text text-transparent mb-3">
              {{ stat.value }}
            </div>
            <div class="text-white/70">{{ stat.label }}</div>
          </div>
        </div>
      </div>

      <!-- Call to Action -->
      <div
        class="transition-all duration-700 ease-out delay-400"
        :class="showContent ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
      >
        <div class="bg-gradient-to-r from-cyan-500/20 to-blue-600/20 backdrop-blur-xl border border-cyan-500/40 rounded-2xl p-12 text-center group hover:border-cyan-400/60 transition-all duration-300">
          <h2 class="text-3xl md:text-4xl font-light text-white mb-6">
            Explorez les Données
            <span class="block font-medium bg-gradient-to-r from-cyan-300 to-blue-300 bg-clip-text text-transparent">
              en Temps Réel
            </span>
          </h2>
          <p class="text-xl text-white/70 mb-8 leading-relaxed">
            Découvrez comment la désoxygénation affecte nos océans à travers des visualisations interactives et des données scientifiques actualisées.
          </p>
          <router-link
            to="/analyse"
            class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold rounded-xl hover:from-cyan-600 hover:to-blue-700 transition-all duration-300 hover:shadow-lg hover:shadow-cyan-500/50"
          >
            Démarrer l'analyse
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
          </router-link>
        </div>
      </div>
    </main>
  </div>
</template>

<style scoped>
</style>
