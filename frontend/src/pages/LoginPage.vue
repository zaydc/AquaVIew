<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";

const email = ref("");
const password = ref("");
const error = ref("");
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

    // Stockage local (simple)
    localStorage.setItem("user", JSON.stringify(data.user));

    // Redirection
    router.push("/");

  } catch (e) {
    error.value = "Erreur serveur.";
  }
}
</script>

<template>
  <div class="login">
    <h1>Connexion</h1>

    <input v-model="email" type="email" placeholder="Email" />
    <input v-model="password" type="password" placeholder="Mot de passe" />

    <p v-if="error" class="error">{{ error }}</p>

    <button @click="handleLogin">Se connecter</button>
  </div>
</template>
