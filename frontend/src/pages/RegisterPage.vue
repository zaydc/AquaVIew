<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const email = ref('')
const password = ref('')
const error = ref('')
const success = ref('')

// <CHANGE> URL correcte avec le virtual host
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
        email: email.value,
        password: password.value
      })
    })

    console.log("[v0] Status réponse:", response.status)
    console.log("[v0] Headers réponse:", response.headers)

    // <CHANGE> Vérifier si la réponse est OK
    if (!response.ok) {
      throw new Error(`Erreur HTTP ${response.status}`)
    }

    const text = await response.text()
    console.log("[v0] Réponse brute:", text)

    // <CHANGE> Parser le JSON avec meilleure gestion d'erreur
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
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-slate-900 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-blue-900/20 to-cyan-900/20"></div>

    <div class="relative z-10 w-full max-w-md p-8 bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl">
      <h1 class="text-3xl font-light text-white text-center mb-6">Inscription</h1>

      <form @submit.prevent="handleRegister" class="space-y-5">
        <div>
          <label class="block text-sm font-medium text-white/70 mb-1">Email</label>
          <input v-model="email" type="email" required
            class="w-full px-4 py-3 rounded-lg bg-slate-800/50 border border-white/10 text-white focus:border-cyan-400 outline-none">
        </div>

        <div>
          <label class="block text-sm font-medium text-white/70 mb-1">Mot de passe</label>
          <input v-model="password" type="password" required
            class="w-full px-4 py-3 rounded-lg bg-slate-800/50 border border-white/10 text-white focus:border-cyan-400 outline-none"
            placeholder="Min 8 car., 1 Maj, 1 Chiffre">
        </div>

        <div v-if="error" class="p-3 rounded bg-red-500/20 text-red-300 text-sm border border-red-500/30">
          {{ error }}
        </div>
        <div v-if="success" class="p-3 rounded bg-green-500/20 text-green-300 text-sm border border-green-500/30">
          {{ success }}
        </div>

        <button type="submit"
          class="w-full py-3 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold shadow-lg hover:scale-[1.02] transition-transform">
          Créer mon compte
        </button>
      </form>
      
      <p class="mt-4 text-center text-sm text-white/50">
        Déjà un compte ? 
        <router-link to="/login" class="text-cyan-400 hover:underline">Se connecter</router-link>
      </p>
    </div>
  </div>
</template>