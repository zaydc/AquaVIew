<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import Navbar from "../components/Navbar.vue";

const email = ref("");
const password = ref("");
const error = ref("");
const isLoaded = ref(false);
const showContent = ref(false);
const router = useRouter();

async function handleLogin() {
  error.value = "";

  try {
    const response = await fetch(
      "http://aquaview/backend/api/login.php",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          email: email.value,
          password: password.value
        })
      }
    );

    const data = await response.json();

    if (!data.success) {
      error.value = data.message;
      return;
    }

    localStorage.setItem("user", JSON.stringify(data.user));
    router.push("/");

  } catch (e) {
    error.value = "Erreur serveur.";
  }
}

onMounted(() => {
  setTimeout(() => {
    isLoaded.value = true;
  }, 100);

  setTimeout(() => {
    showContent.value = true;
  }, 300);
});
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
            <h1 class="text-4xl font-light text-white mb-2">Connexion</h1>
            <p class="text-white/60 text-sm">Accédez à votre compte AquaView</p>
          </div>

          <!-- FORM -->
          <form @submit.prevent="handleLogin" class="space-y-5">
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
              <label class="block text-sm font-medium text-white/70 mb-2">Mot de passe</label>
              <input 
                v-model="password" 
                type="password" 
                required
                placeholder="••••••••"
                class="w-full px-4 py-3 rounded-lg bg-slate-800/50 border border-white/10 text-white placeholder-white/40 focus:border-cyan-400 focus:outline-none transition-colors duration-300"
              />
            </div>

            <!-- ERREUR -->
            <div v-if="error" class="p-3 rounded-lg bg-red-500/20 text-red-300 text-sm border border-red-500/30">
              {{ error }}
            </div>

            <!-- BOUTON -->
            <button 
              type="submit"
              class="w-full py-3 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold shadow-lg hover:shadow-cyan-500/50 hover:scale-[1.02] transition-all duration-300"
            >
              Se connecter
            </button>
          </form>

          <!-- LIEN INSCRIPTION -->
          <div class="mt-6 text-center">
            <p class="text-white/60 text-sm">
              Pas encore de compte ?
              <router-link to="/register" class="text-cyan-400 hover:text-cyan-300 font-semibold transition-colors">
                S'inscrire
              </router-link>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
