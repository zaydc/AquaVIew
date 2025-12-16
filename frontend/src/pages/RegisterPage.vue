<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import Navbar from '../components/Navbar.vue'

const router = useRouter()
const nom = ref('')
const prenom = ref('')
const email = ref('')
const numero = ref('')
const password = ref('')
const error = ref('')
const success = ref('')
const isLoaded = ref(false)
const showContent = ref(false)

// URL correcte avec le virtual host
const API_URL = 'http://aquaview/backend/api'

const handleRegister = async () => {
  error.value = ''
  success.value = ''
  
  try {
    console.log("[v0] Envoi requête fetch vers:", `${API_URL}/register.php`)
    
    const response = await fetch(`${API_URL}/register.php`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        nom: nom.value,
        prenom: prenom.value,
        email: email.value,
        numero: numero.value,
        password: password.value
      })
    })

    console.log("[v0] Status réponse:", response.status)
    console.log("[v0] Headers réponse:", response.headers)

    if (!response.ok) {
      throw new Error(`Erreur HTTP ${response.status}`)
    }

    const text = await response.text()
    console.log("[v0] Réponse brute:", text)

    let data
    try {
      data = JSON.parse(text)
    } catch (e) {
      console.error("[v0] Erreur parsing JSON:", e)
      error.value = "Réponse serveur invalide (pas du JSON)"
      return
    }

    console.log("[v0] Données reçues:", data)

    if (data.success) {
      success.value = data.message
      setTimeout(() => router.push('/login'), 2000)
    } else {
      error.value = data.message || "Erreur inconnue"
    }
  } catch (e) {
    console.error("[v0] Erreur complète:", e.message)
    console.error("[v0] Stack trace:", e)
    error.value = `Erreur: ${e.message}`
  }
}

onMounted(() => {
  setTimeout(() => {
    isLoaded.value = true
  }, 100)

  setTimeout(() => {
    showContent.value = true
  }, 300)
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

    <!-- CONTENU -->
    <div class="relative z-10 flex items-center justify-center min-h-[calc(100vh-64px)]">
      <div
        class="w-full max-w-md mx-4 transition-all duration-700 ease-out"
        :class="showContent
          ? 'opacity-100 translate-y-0'
          : 'opacity-0 translate-y-8'"
      >
        <div class="p-8 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 shadow-2xl shadow-black/20">
          <!-- HEADER -->
          <div class="text-center mb-8">
            <h1 class="text-4xl font-light text-white mb-2">Inscription</h1>
            <p class="text-white/60 text-sm">Créez votre compte AquaView</p>
          </div>

          <!-- FORM -->
          <form @submit.prevent="handleRegister" class="space-y-5">
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-white/70 mb-2">Nom</label>
                <input 
                  v-model="nom" 
                  type="text" 
                  required
                  placeholder="Votre nom"
                  class="w-full px-4 py-3 rounded-lg bg-slate-800/50 border border-white/10 text-white placeholder-white/40 focus:border-cyan-400 focus:outline-none transition-colors duration-300"
                />
              </div>
              <div>
                <label class="block text-sm font-medium text-white/70 mb-2">Prénom</label>
                <input 
                  v-model="prenom" 
                  type="text" 
                  required
                  placeholder="Votre prénom"
                  class="w-full px-4 py-3 rounded-lg bg-slate-800/50 border border-white/10 text-white placeholder-white/40 focus:border-cyan-400 focus:outline-none transition-colors duration-300"
                />
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-white/70 mb-2">Email</label>
              <input 
                v-model="email" 
                type="email" 
                required
                placeholder="votre.email@exemple.com"
                class="w-full px-4 py-3 rounded-lg bg-slate-800/50 border border-white/10 text-white placeholder-white/40 focus:border-cyan-400 focus:outline-none transition-colors duration-300"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-white/70 mb-2">Numéro de téléphone</label>
              <input 
                v-model="numero" 
                type="tel" 
                required
                placeholder="+33 1 23 45 67 89"
                class="w-full px-4 py-3 rounded-lg bg-slate-800/50 border border-white/10 text-white placeholder-white/40 focus:border-cyan-400 focus:outline-none transition-colors duration-300"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-white/70 mb-2">Mot de passe</label>
              <input 
                v-model="password" 
                type="password" 
                required
                placeholder="Min 8 car., 1 Maj, 1 Chiffre"
                class="w-full px-4 py-3 rounded-lg bg-slate-800/50 border border-white/10 text-white placeholder-white/40 focus:border-cyan-400 focus:outline-none transition-colors duration-300"
              />
            </div>

            <!-- MESSAGES D'ERREUR/SUCCÈS -->
            <div v-if="error" class="p-3 rounded-lg bg-red-500/20 text-red-300 text-sm border border-red-500/30">
              {{ error }}
            </div>
            <div v-if="success" class="p-3 rounded-lg bg-green-500/20 text-green-300 text-sm border border-green-500/30">
              {{ success }}
            </div>

            <!-- BOUTON -->
            <button 
              type="submit"
              class="w-full py-3 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold shadow-lg hover:shadow-cyan-500/50 hover:scale-[1.02] transition-all duration-300"
            >
              Créer mon compte
            </button>
          </form>

          <!-- LIEN CONNEXION -->
          <div class="mt-6 text-center">
            <p class="text-white/60 text-sm">
              Déjà un compte ?
              <router-link to="/login" class="text-cyan-400 hover:text-cyan-300 font-semibold transition-colors">
                Se connecter
              </router-link>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>