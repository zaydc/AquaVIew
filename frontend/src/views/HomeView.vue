<template>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">


  <main class="page">
    <h1>AquaView — Base Clean</h1>

    <section>
      <h2>🎯 Objectif du projet</h2>
      <p>
        Cette branche fournit une base propre pour développer et tester
        des fonctionnalités en <strong>Vue.js</strong> et <strong>PHP</strong>,
        en mettant l'accent sur la communication fluide entre le front-end et le back-end.
      </p>
    </section>

    <section>
      <h2>🔧 Configuration & Lancement de l'Application Vue</h2>
      <p>
        Pour démarrer le front-end, vous devez installer les dépendances nécessaires
        et lancer le serveur de développement Vite/Vue.
      </p>

      <h4>1. Installer les dépendances (npm)</h4>
      <p>
        Ce projet nécessite **Chart.js** et le module **chart.js/auto** pour la gestion des graphiques.
        Exécutez cette commande à la racine de votre dossier front-end (où se trouve `package.json`).
      </p>
      <pre><code>npm install</code></pre>

      <h4>2. Dépendances critiques</h4>
      <p>
        Les paquets essentiels installés sont :
      </p>
      <ul>
        <li><code>vue</code> : Le framework principal.</li>
        <li><code>chart.js</code> et <code>chart.js/auto</code> : La librairie de graphiques utilisée pour l'exemple.</li>
        <li><code>vite</code> : Le bundler moderne pour le développement rapide.</li>
      </ul>

      <h4>3. Lancement du serveur de développement</h4>
      <p>
        Cette commande lance le serveur Vite/Vue. Il inclut le **Hot Module Reload** (HMR),
        ce qui met à jour le navigateur automatiquement à chaque modification de code.
      </p>
      <pre><code>npm run dev</code></pre>
      <p class="hint">
        💡 Le serveur tourne généralement sur <code>http://localhost:5173</code>.
        L'API PHP doit être accessible séparément (ex: <code>http://aquaview/</code>).
      </p>
    </section>
    <section>
      <h2>📊 Exemple de feature : graphique depuis la base de données</h2>

      <p>
        Exemple concret : ce graphique affiche le
        <strong>nombre d’analyses par année</strong>
        depuis la base MySQL via une API PHP (JSON).
      </p>

      <div class="chart-box">
        <canvas ref="chartCanvas"></canvas>
      </div>

      <p class="hint">
        👉 API utilisée :
        <code>/backend/api/exemple.php</code>
      </p>
    </section>

    <section class="feature-guide-details">
      <h2>🧩 Étapes détaillées pour créer ta propre feature</h2>
      <ol>
        <li data-step="1">Créer une branche <code>feature/nom-feature</code></li>
        <li data-step="2">Créer une API PHP dans <code>backend/api</code></li>
        <li data-step="3">Tester l’API dans le navigateur</li>
        <li data-step="4">Créer un composant ou une vue Vue</li>
        <li data-step="5">Récupérer les données avec <code>fetch()</code></li>
        <li data-step="6">Afficher les données (graphique, tableau, carte…)</li>
      </ol>

      <hr>

      <h3>Détails par étape</h3>

      <div class="step-details" id="step-1">
        <h4>1. Créer une branche</h4>
        <p>Toujours partir de <code>base-clean</code> pour assurer la stabilité.</p>
        <pre><code>git checkout base-clean
git pull
git checkout -b feature/ma-nouvelle-feature</code></pre>
      </div>

      <div class="step-details" id="step-2">
        <h4>2. Créer une API PHP (Backend)</h4>
        <p>
          C'est le fichier qui va interroger la base de données (MySQL) et encoder le résultat en **JSON**.
          Assurez-vous d'inclure les **headers CORS** (Cross-Origin Resource Sharing) si votre Vue et votre PHP s'exécutent sur des ports/domaines différents (ex: Vue sur `localhost:5173`, PHP sur `aquaview`).
        </p>
        <p class="hint">
          <strong>Fichier:</strong> <code>backend/api/analyses-par-annee.php</code>
        </p>
        <pre><code>&lt;?php
    header('Access-Control-Allow-Origin: *'); // Laissez '*' pour le développement
    header('Content-Type: application/json');

    // 1. Connexion à la base de données (exemple simple)
    // $pdo = new PDO(...)

    // 2. Requête SQL
    // $stmt = $pdo->query("SELECT YEAR(date_analyse) AS year, COUNT(*) AS total FROM analyses GROUP BY year ORDER BY year");

    // 3. Récupération des données (Simulation pour l'exemple)
    $data = [
        ['year' => 2021, 'total' => 120],
        ['year' => 2022, 'total' => 155],
        ['year' => 2023, 'total' => 180],
        ['year' => 2024, 'total' => 195],
    ];

    // 4. Envoi de la réponse JSON
    echo json_encode($data);
?&gt;</code></pre>
      </div>


      <div class="step-details" id="step-3">
        <h4>3. Tester l’API</h4>
        <p>Ouvrez l'URL de votre nouvelle API (ex: <code>http://aquaview/backend/api/analyses-par-annee.php</code>) dans votre navigateur. Vous devez voir un résultat en **JSON brut**.</p>
      </div>

      <div class="step-details" id="step-4-5">
        <h4>4. & 5. Créer la Vue et Récupérer les données (Frontend)</h4>
        <p>Utilisez le hook <code>onMounted</code> pour appeler l'API dès que le composant est monté, et la fonction native <code>fetch()</code> pour la requête HTTP.</p>
        <pre><code>&lt;script setup&gt;
import { onMounted, ref } from "vue";

// La variable (ref) qui contiendra les données chargées
const analyseData = ref(null);
const apiUrl = "http://aquaview/backend/api/analyses-par-annee.php";

onMounted(async () => {
    try {
        const response = await fetch(apiUrl);
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        analyseData.value = await response.json();
        console.log("Données chargées:", analyseData.value);

        // ... Ici, le code pour monter le graphique ou le tableau

    } catch (error) {
        console.error("Erreur lors du chargement des données:", error);
    }
});
&lt;/script&gt;</code></pre>
      </div>

      <div class="step-details" id="step-6">
        <h4>6. Afficher les données</h4>
        <p>
          Utilisez les données chargées (ex: <code>analyseData.value</code>) pour générer des éléments dans votre template Vue (ex: tableau, graphique Chart.js, ou carte Leaflet).
        </p>
      </div>
    </section>

    <section>
      <h2>🔀 Workflow Git (Complet)</h2>
      <p>
        Une fois que votre feature est fonctionnelle, suivez ce workflow pour la soumettre à la branche principale (ex: `main` ou `develop`).
      </p>
      <pre><code>git checkout base-clean # S'assurer d'avoir les dernières mises à jour
git pull

git checkout feature/ma-feature # Revenir à votre branche
git add .
git commit -m "feat: ma nouvelle feature"

git push # Publier les changements sur le dépôt distant

# Demande de Fusion (Pull Request) via l'interface Git (GitHub/GitLab)</code></pre>
      <p class="hint">
        💡 **Bonne Pratique de Commit:** Utilisez des préfixes standards (ex: `feat:` pour une nouvelle fonctionnalité, `fix:` pour une correction de bug) pour des messages clairs.
      </p>
    </section>

    <footer>
      <p>
        Base stable ✅ — À vous de jouer.
      </p>
    </footer>
  </main>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { Chart } from "chart.js/auto";

const chartCanvas = ref(null);

onMounted(async () => {
  // L'URL de l'API exemple (doit être accessible)
  const apiUrl = "http://aquaview/backend/api/exemple.php";

  try {
    const res = await fetch(apiUrl);
    if (!res.ok) {
      throw new Error(`Erreur HTTP! Statut: ${res.status}`);
    }
    const data = await res.json();

    // Initialisation du graphique
    new Chart(chartCanvas.value, {
      type: "line",
      data: {
        labels: data.map(d => d.year),
        datasets: [
          {
            label: "Nombre d’analyses",
            data: data.map(d => d.total),
            borderColor: "#007bff",
            backgroundColor: "rgba(0, 123, 255, 0.1)",
            tension: 0.4,
            fill: true,
            pointRadius: 4
          }
        ]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            ticks: { precision: 0 }
          }
        }
      }
    });

  } catch (error) {
    console.error("Échec du chargement du graphique:", error);
    // Optionnel: Afficher un message d'erreur dans le template
  }
});
</script>

<style scoped>
/*
|--------------------------------------------------------------------------
| Style Professionnel et Propre pour AquaView — Base Clean
|--------------------------------------------------------------------------
*/

/* --- Base et Mise en Page Globale --- */
:root {
  --color-primary: #007bff;
  --color-secondary: #6c757d;
  --color-accent: #00d5ff; /* Cyan plus vif pour l'accentuation */
  --color-text-dark: #212529;
  --color-text-light: #f8f9fa;
  --color-background: #f8f9fa;
  --color-card-bg: #ffffff;
  --color-border: #dee2e6;
  --color-separator: #f1f3f5;
}

/* Application de la police Inter importée */
body {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
  background-color: var(--color-background);
  color: var(--color-text-dark);
  line-height: 1.6;
}

.page {
  max-width: 900px;
  margin: 40px auto;
  padding: 0 20px;
}

/* --- Titres --- */
h1 {
  color: var(--color-primary);
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 30px;
  border-bottom: 3px solid var(--color-accent);
  padding-bottom: 10px;
}

h2 {
  color: var(--color-primary);
  font-size: 1.5rem;
  font-weight: 600;
  margin-top: 30px;
  margin-bottom: 15px;
  display: flex;
  align-items: center;
  gap: 10px;
}

h3 {
  color: var(--color-text-dark);
  font-size: 1.3rem;
  font-weight: 600;
  margin-top: 30px;
  padding-bottom: 5px;
  border-bottom: 1px solid var(--color-separator);
}

h4 {
  color: var(--color-primary);
  font-size: 1.1rem;
  font-weight: 600;
  margin-top: 20px;
  margin-bottom: 10px;
}

/* --- Sections Card --- */
section {
  background-color: var(--color-card-bg);
  border-radius: 12px;
  padding: 30px;
  margin-bottom: 30px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  border: 1px solid var(--color-border);
}

/* Liste des dépendances */
section ul {
  list-style: disc;
  padding-left: 20px;
  margin-bottom: 20px;
}

/* --- Code et Hint --- */
code {
  background-color: #e9ecef;
  color: var(--color-text-dark);
  padding: 3px 6px;
  border-radius: 4px;
  font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, Courier, monospace;
  font-size: 0.9rem;
  font-weight: 500;
}

.hint {
  margin-top: 15px;
  padding: 10px 15px;
  background-color: #e9f5ff; /* Fond bleu très clair */
  border-left: 5px solid var(--color-primary);
  border-radius: 0 4px 4px 0;
  font-size: 0.95rem;
  color: #0056b3;
}

/* --- Graphique --- */
.chart-box {
  background-color: #f8f9fa;
  padding: 20px;
  border-radius: 8px;
  border: 1px solid var(--color-border);
  margin-top: 20px;
  min-height: 300px;
}

/* --- Étapes (Feature Guide - Liste) --- */
ol {
  list-style: none;
  padding-left: 0;
  margin-top: 20px;
  counter-reset: step; /* Assurer que le compteur est réinitialisé ici */
}

ol li {
  display: flex;
  align-items: center;
  gap: 15px;
  padding: 15px 20px;
  margin-bottom: 10px;
  background-color: #f1f3f5;
  border-radius: 8px;
  border-left: 4px solid var(--color-accent);
  transition: background-color 0.2s, transform 0.2s;
  font-size: 1rem;
}

ol li:hover {
  background-color: #e9ecef;
  transform: translateY(-1px);
}

ol li::before {
  content: counter(step);
  counter-increment: step;
  min-width: 30px;
  height: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  background-color: var(--color-primary);
  color: var(--color-text-light);
  font-weight: 700;
  font-size: 14px;
  flex-shrink: 0;
}

/* --- Détails des étapes (Nouvelle structure) --- */
.feature-guide-details hr {
  margin: 30px 0;
  border: 0;
  border-top: 1px solid var(--color-border);
}

.step-details {
  padding: 10px 0;
  border-top: 1px dashed var(--color-separator);
  margin-top: 15px;
}
.step-details:first-of-type {
  border-top: none;
}
.step-details:last-of-type {
  padding-bottom: 0;
}

/* --- Workflow Git et Commandes --- */
pre {
  background-color: #282c34;
  color: #abb2bf;
  padding: 15px;
  border-radius: 8px;
  overflow-x: auto;
  font-size: 0.9rem;
  margin-top: 20px;
}

pre code {
  background-color: transparent;
  color: inherit;
  padding: 0;
  border-radius: 0;
}

/* --- Footer --- */
footer {
  margin-top: 40px;
  text-align: center;
  padding-top: 20px;
  border-top: 1px solid var(--color-border);
  color: var(--color-secondary);
  font-size: 0.9rem;
}
</style>
