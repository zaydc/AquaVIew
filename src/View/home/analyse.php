<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analyse - AquaView</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .fade-in { animation: fadeIn 0.7s ease-out forwards; }
        .slide-up { animation: slideUp 0.7s ease-out forwards; opacity: 0; }
        .slide-up-1 { animation-delay: 0.1s; }
        .slide-up-2 { animation-delay: 0.2s; }
        .slide-up-3 { animation-delay: 0.3s; }
        .slide-up-4 { animation-delay: 0.4s; }
        .slide-up-5 { animation-delay: 0.5s; }
        .zoom-in { animation: zoomIn 2s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(2rem); } to { opacity: 1; transform: translateY(0); } }
        @keyframes zoomIn { from { opacity: 0; } to { opacity: 1; } }
        select option { background-color: #0f172a; color: white; }
    </style>
</head>
<body class="bg-slate-900">
    <?php include __DIR__ . '/../components/navbar.php'; ?>
    
    <div class="relative min-h-screen text-white bg-slate-900 pt-20">
        <!-- IMAGE DE FOND -->
        <div class="absolute inset-0 zoom-in">
            <img
                src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=1920&q=80"
                alt="Analyse océanique"
                class="absolute inset-0 w-full h-full object-cover"
            />
        </div>

        <!-- OVERLAY DÉGRADÉ -->
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900/95 via-blue-900/85 to-cyan-800/75"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-slate-900/60"></div>

        <!-- CONTENU PRINCIPAL -->
        <main class="relative z-10 max-w-7xl mx-auto px-6 py-12">
            
            <!-- En-tête de la page -->
            <div class="mb-12 slide-up slide-up-1">
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
            <div class="mb-8 p-6 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 slide-up slide-up-2">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <!-- Sélection de région -->
                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-2">
                            Région océanique
                        </label>
                        <select
                            id="selectedRegion"
                            class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/20 text-white focus:outline-none focus:border-cyan-400/50 focus:bg-white/10 transition-all duration-300 cursor-pointer"
                        >
                            <option value="atlantique-nord">Atlantique Nord</option>
                            <option value="pacifique">Pacifique</option>
                            <option value="indien">Océan Indien</option>
                            <option value="mediterranee">Méditerranée</option>
                        </select>
                    </div>

                    <!-- Sélection de période -->
                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-2">
                            Période d'analyse
                        </label>
                        <select
                            id="selectedPeriod"
                            class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/20 text-white focus:outline-none focus:border-cyan-400/50 focus:bg-white/10 transition-all duration-300 cursor-pointer"
                        >
                            <option value="7-jours">7 derniers jours</option>
                            <option value="30-jours" selected>30 derniers jours</option>
                            <option value="1-an">1 an</option>
                            <option value="5-ans">5 ans</option>
                        </select>
                    </div>

                    <!-- Sélection de métrique -->
                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-2">
                            Métrique principale
                        </label>
                        <select
                            id="selectedMetric"
                            class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/20 text-white focus:outline-none focus:border-cyan-400/50 focus:bg-white/10 transition-all duration-300 cursor-pointer"
                        >
                            <option value="oxygene">Niveau d'oxygène</option>
                            <option value="temperature">Température</option>
                            <option value="salinite">Salinité</option>
                            <option value="ph">pH</option>
                        </select>
                    </div>
                </div>

                <!-- Bouton d'analyse -->
                <div class="mt-6 flex justify-end">
                    <button
                        class="group px-8 py-3 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-500 text-slate-900 font-semibold shadow-lg shadow-cyan-500/30 hover:shadow-xl hover:shadow-cyan-500/40 hover:scale-105 transition-all duration-300"
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
                <!-- Card 1 -->
                <div class="p-6 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-300 slide-up slide-up-3">
                    <div class="flex items-start justify-between mb-4">
                        <h3 class="text-sm font-medium text-white/70">Zone Critique Détectée</h3>
                        <div class="w-2 h-2 rounded-full bg-red-400"></div>
                    </div>
                    <div class="mb-2">
                        <div class="text-3xl font-semibold text-white">3.2 mg/L</div>
                        <div class="text-sm font-medium mt-1 text-red-400">-12%</div>
                    </div>
                    <p class="text-xs text-white/50 leading-relaxed">Niveau d'oxygène critique dans la zone sélectionnée</p>
                </div>

                <!-- Card 2 -->
                <div class="p-6 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-300 slide-up slide-up-3" style="animation-delay: 0.4s;">
                    <div class="flex items-start justify-between mb-4">
                        <h3 class="text-sm font-medium text-white/70">Température Moyenne</h3>
                        <div class="w-2 h-2 rounded-full bg-orange-400"></div>
                    </div>
                    <div class="mb-2">
                        <div class="text-3xl font-semibold text-white">18.5°C</div>
                        <div class="text-sm font-medium mt-1 text-red-400">+2.1°C</div>
                    </div>
                    <p class="text-xs text-white/50 leading-relaxed">Augmentation notable par rapport à la moyenne historique</p>
                </div>

                <!-- Card 3 -->
                <div class="p-6 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-300 slide-up slide-up-3" style="animation-delay: 0.5s;">
                    <div class="flex items-start justify-between mb-4">
                        <h3 class="text-sm font-medium text-white/70">Zone Surveillée</h3>
                        <div class="w-2 h-2 rounded-full bg-blue-400"></div>
                    </div>
                    <div class="mb-2">
                        <div class="text-3xl font-semibold text-white">2,450 km²</div>
                        <div class="text-sm font-medium mt-1 text-cyan-400">+15%</div>
                    </div>
                    <p class="text-xs text-white/50 leading-relaxed">Surface totale de la zone d'analyse</p>
                </div>

                <!-- Card 4 -->
                <div class="p-6 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-300 slide-up slide-up-3" style="animation-delay: 0.6s;">
                    <div class="flex items-start justify-between mb-4">
                        <h3 class="text-sm font-medium text-white/70">Stations Actives</h3>
                        <div class="w-2 h-2 rounded-full bg-green-400"></div>
                    </div>
                    <div class="mb-2">
                        <div class="text-3xl font-semibold text-white">24</div>
                        <div class="text-sm font-medium mt-1 text-green-400">+3</div>
                    </div>
                    <p class="text-xs text-white/50 leading-relaxed">Stations de mesure opérationnelles</p>
                </div>
            </div>

            <!-- Zone de visualisation -->
            <div class="p-8 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 slide-up slide-up-5">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-medium">Visualisation des données</h2>
                    <div class="flex gap-2">
                        <button class="px-4 py-2 rounded-lg text-sm bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-300">
                            Carte
                        </button>
                        <button class="px-4 py-2 rounded-lg text-sm bg-white/10 border border-white/20 hover:bg-white/10 hover:border-white/20 transition-all duration-300">
                            Graphique
                        </button>
                        <button class="px-4 py-2 rounded-lg text-sm bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-300">
                            Tableau
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
</body>
</html>
