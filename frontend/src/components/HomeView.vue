<template>
  <main class="home">
    <h1>AquaView – Base Clean</h1>

    <section>
      <h2>🎯 Objectif du projet</h2>
      <p>
        Ce projet sert de base pour développer des fonctionnalités
        en Vue.js (frontend) et PHP (backend).
      </p>
    </section>

    <section>
      <h2>🧱 Architecture</h2>
      <ul>
        <li><strong>frontend/</strong> : Vue.js (interface utilisateur)</li>
        <li><strong>backend/api/</strong> : API PHP (JSON)</li>
        <li><strong>backend/config/</strong> : configuration (BDD)</li>
      </ul>
    </section>

    <section>
      <h2>🚀 Créer une feature (méthode)</h2>
      <ol>
        <li>Créer une branche <code>feature/nom-feature</code></li>
        <li>Créer une API PHP dans <code>backend/api</code></li>
        <li>Créer une vue ou un composant Vue</li>
        <li>Appeler l’API avec <code>fetch()</code></li>
        <li>Afficher les données</li>
      </ol>
    </section>

    <section>
      <h2>📌 Règles importantes</h2>
      <ul>
        <li>Ne jamais modifier la branche <code>base-clean</code></li>
        <li>Une feature = une branche</li>
        <li>API = JSON uniquement</li>
        <li>Pas de logique métier dans Vue</li>
      </ul>
    </section>
  </main>
</template>

<style scoped>
.home {
  max-width: 900px;
  margin: auto;
  padding: 3rem;
  font-family: system-ui, sans-serif;
}
h1 {
  margin-bottom: 2rem;
}
section {
  margin-bottom: 2rem;
}
</style>
