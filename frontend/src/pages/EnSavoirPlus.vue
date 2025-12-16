<template>
 <Navbar />
  <div class="min-h-screen relative overflow-hidden">
    <!-- Background océanique -->
    <div class="fixed inset-0 -z-10">
      <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800" />
      <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iZ3JpZCIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIj48cGF0aCBkPSJNIDQwIDAgTCAwIDAgMCA0MCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSJ3aGl0ZSIgc3Ryb2tlLW9wYWNpdHk9IjAuMDUiIHN0cm9rZS13aWR0aD0iMSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNncmlkKSIvPjwvc3ZnPg==')] opacity-30" />
      <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-blue-900/50" />
    </div>

 

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-4">
      <div class="max-w-4xl mx-auto text-center" :class="{ 'animate-fade-in': isVisible }">
        <h1 class="text-5xl md:text-6xl font-bold mb-6">
          <span class="bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 bg-clip-text text-transparent">
            La Désoxygénation
          </span>
          <br />
          <span class="text-white">des Océans</span>
        </h1>
        <p class="text-xl text-slate-300 leading-relaxed">
          Un phénomène invisible qui menace la vie marine et l'équilibre de notre planète. 
          Découvrez les causes, les conséquences et les solutions pour protéger nos océans.
        </p>
      </div>
    </section>

    <!-- Sections d'information -->
    <section class="py-12 px-4">
      <div class="max-w-6xl mx-auto space-y-8">
        <div
          v-for="(section, index) in sections"
          :key="index"
          class="bg-slate-800/40 backdrop-blur-lg border border-white/10 rounded-2xl p-8 hover:bg-slate-800/60 transition-all duration-300"
          :class="{ 'animate-slide-up': isVisible }"
          :style="{ animationDelay: `${index * 100}ms` }"
        >
          <div class="flex items-start gap-4 mb-4">
            <div class="p-3 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-xl">
              <component :is="section.icon" class="w-6 h-6 text-white" />
            </div>
            <div class="flex-1">
              <h2 class="text-2xl font-bold text-white mb-3">{{ section.title }}</h2>
              <p class="text-slate-300 leading-relaxed">{{ section.description }}</p>
              <ul v-if="section.points" class="mt-4 space-y-2">
                <li
                  v-for="(point, idx) in section.points"
                  :key="idx"
                  class="flex items-start gap-2 text-slate-300"
                >
                  <svg class="w-5 h-5 text-cyan-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span>{{ point }}</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Section Statistiques -->
    <section class="py-20 px-4">
      <div class="max-w-6xl mx-auto">
        <h2 class="text-4xl font-bold text-center mb-12">
          <span class="bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
            Chiffres Clés
          </span>
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div
            v-for="(stat, index) in statistics"
            :key="index"
            class="bg-gradient-to-br from-slate-800/60 to-slate-900/60 backdrop-blur-lg border border-white/10 rounded-2xl p-8 text-center hover:scale-105 transition-transform duration-300"
            :class="{ 'animate-fade-in': isVisible }"
            :style="{ animationDelay: `${index * 150}ms` }"
          >
            <div class="text-5xl font-bold bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent mb-3">
              {{ stat.value }}
            </div>
            <div class="text-slate-300 text-lg">{{ stat.label }}</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Call to Action -->
    <section class="py-20 px-4">
      <div class="max-w-4xl mx-auto">
        <div class="bg-gradient-to-br from-cyan-500/20 to-blue-600/20 backdrop-blur-lg border border-cyan-500/30 rounded-3xl p-12 text-center">
          <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
            Explorez les Données en Temps Réel
          </h2>
          <p class="text-xl text-slate-300 mb-8 leading-relaxed">
            Découvrez comment la désoxygénation affecte nos océans à travers des visualisations interactives 
            et des données scientifiques actualisées.
          </p>
          <a
            href="/analyse"
            class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-lg font-semibold rounded-xl hover:from-cyan-600 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-cyan-500/50"
          >
            Démarrer l'analyse
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
          </a>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900/60 backdrop-blur-lg border-t border-white/10 py-8">
      <div class="max-w-7xl mx-auto px-4 text-center text-slate-400">
        <p>&copy; 2025 AquaView. Tous droits réservés.</p>
      </div>
    </footer>
  </div>
</template>

<script setup lang="ts">
import Navbar from '../components/Navbar.vue'
import { ref, onMounted } from 'vue'

const isVisible = ref(false)

const sections = [
  {
    title: "Qu'est-ce que la désoxygénation ?",
    description: "La désoxygénation des océans est la diminution progressive de la concentration en oxygène dissous dans l'eau de mer. Ce phénomène touche aussi bien les eaux de surface que les profondeurs marines, créant des zones hypoxiques (pauvres en oxygène) et anoxiques (dépourvues d'oxygène).",
    icon: 'svg',
    points: null
  },
  {
    title: "Les Causes Principales",
    description: "La désoxygénation océanique résulte de plusieurs facteurs interconnectés :",
    icon: 'svg',
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
    icon: 'svg',
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
    icon: 'svg',
    points: null
  },
  {
    title: "Pourquoi Surveiller ?",
    description: "La surveillance continue des niveaux d'oxygène océanique est essentielle pour comprendre l'évolution du phénomène et anticiper ses impacts futurs. Les données en temps réel permettent aux scientifiques, décideurs politiques et communautés côtières de prendre des mesures préventives et correctives.",
    icon: 'svg',
    points: null
  },
  {
    title: "Solutions et Actions",
    description: "Plusieurs approches peuvent contribuer à atténuer la désoxygénation :",
    icon: 'svg',
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
    isVisible.value = true
  }, 100)
})
</script>

<style scoped>
@keyframes fade-in {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes slide-up {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fade-in 0.8s ease-out forwards;
}

.animate-slide-up {
  animation: slide-up 0.6s ease-out forwards;
  opacity: 0;
}
</style>
