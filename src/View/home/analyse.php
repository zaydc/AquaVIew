<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analyse - AquaView</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
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
        /* Style pour les inputs date */
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
            cursor: pointer;
        }
        
        /* Leaflet Map Styling */
        .leaflet-container {
            background: #0f172a !important;
            border-radius: 0.5rem;
        }
        
        .leaflet-control-container .leaflet-control {
            background: rgba(15, 23, 42, 0.9) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            border-radius: 0.5rem !important;
        }
        
        .leaflet-control-container .leaflet-control a {
            color: white !important;
            background: transparent !important;
        }
        
        .leaflet-control-container .leaflet-control a:hover {
            background: rgba(34, 211, 238, 0.2) !important;
        }
        
        .leaflet-popup-content-wrapper {
            background: rgba(15, 23, 42, 0.95) !important;
            border: 1px solid rgba(34, 211, 238, 0.3) !important;
            border-radius: 0.5rem !important;
            color: white !important;
        }
        
        .leaflet-popup-tip {
            background: rgba(15, 23, 42, 0.95) !important;
        }
        
        .leaflet-popup-content {
            color: white !important;
            margin: 0.5rem !important;
        }
        
        /* Custom marker styling */
        .custom-marker {
            background: linear-gradient(135deg, #06b6d4, #3b82f6);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            width: 12px;
            height: 12px;
            box-shadow: 0 0 20px rgba(34, 211, 238, 0.6);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 20px rgba(34, 211, 238, 0.6);
            }
            50% {
                box-shadow: 0 0 30px rgba(34, 211, 238, 0.8);
            }
            100% {
                box-shadow: 0 0 20px rgba(34, 211, 238, 0.6);
            }
        }
        
        /* Table styling */
        .table-container::-webkit-scrollbar {
            width: 6px;
        }
        
        .table-container::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 3px;
        }
        
        .table-container::-webkit-scrollbar-thumb {
            background: rgba(34, 211, 238, 0.3);
            border-radius: 3px;
        }
        
        .table-container::-webkit-scrollbar-thumb:hover {
            background: rgba(34, 211, 238, 0.5);
        }
        
        /* Tooltip styling */
        .custom-tooltip {
            background: rgba(15, 23, 42, 0.95) !important;
            border: 1px solid rgba(34, 211, 238, 0.3) !important;
            border-radius: 0.5rem !important;
            color: white !important;
            font-size: 12px !important;
            padding: 6px 10px !important;
        }
        
        .custom-tooltip::before {
            border-top-color: rgba(34, 211, 238, 0.3) !important;
        }
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
                <!-- Grille adaptée pour inclure les filtres de date -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    <!-- Sélection de métrique -->
                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-2">
                            Métrique principale
                        </label>
                        <select
                            id="metric"
                            class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/20 text-white focus:outline-none focus:border-cyan-400/50 focus:bg-white/10 transition-all duration-300 cursor-pointer"
                        >
                            <option value="dissoxygen">Niveau d'oxygène</option>
                            <option value="water_temp">Température</option>
                            <option value="salinity">Salinité</option>
                            <option value="ph">pH</option>
                        </select>
                    </div>

                    <!-- Date de début -->
                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-2">
                            Date de début
                        </label>
                        <input
                            type="date"
                            id="startDate"
                            class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/20 text-white focus:outline-none focus:border-cyan-400/50 focus:bg-white/10 transition-all duration-300 cursor-pointer"
                        />
                        <p id="minDateInfo" class="text-xs text-white/40 mt-1"></p>
                    </div>

                    <!-- Date de fin -->
                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-2">
                            Date de fin
                        </label>
                        <input
                            type="date"
                            id="endDate"
                            class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/20 text-white focus:outline-none focus:border-cyan-400/50 focus:bg-white/10 transition-all duration-300 cursor-pointer"
                        />
                        <p id="maxDateInfo" class="text-xs text-white/40 mt-1"></p>
                    </div>
                </div>

                <!-- Message d'information sur les dates -->
                <div id="dateRangeInfo" class="mt-4 p-3 rounded-lg bg-cyan-500/10 border border-cyan-500/20 text-sm text-cyan-300 hidden">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span id="dateRangeText">Chargement des dates disponibles...</span>
                    </div>
                </div>

                <!-- Bouton d'analyse -->
                <div class="mt-6 flex justify-end">
                    <button
                        id="btnAnalyse"
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
                <!-- Card 1 - Valeur moyenne -->
                <div class="p-6 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-300 slide-up slide-up-3">
                    <div class="flex items-start justify-between mb-4">
                        <h3 class="text-sm font-medium text-white/70">Valeur moyenne</h3>
                        <div class="w-2 h-2 rounded-full bg-cyan-400"></div>
                    </div>
                    <div class="mb-2">
                        <div id="avgValue" class="text-3xl font-semibold text-white">–</div>
                    </div>
                    <p class="text-xs text-white/50 leading-relaxed">Moyenne de la métrique sélectionnée</p>
                </div>

                <!-- Card 2 - Minimum -->
                <div class="p-6 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-300 slide-up slide-up-3" style="animation-delay: 0.4s;">
                    <div class="flex items-start justify-between mb-4">
                        <h3 class="text-sm font-medium text-white/70">Minimum</h3>
                        <div class="w-2 h-2 rounded-full bg-blue-400"></div>
                    </div>
                    <div class="mb-2">
                        <div id="minValue" class="text-3xl font-semibold text-white">–</div>
                    </div>
                    <p class="text-xs text-white/50 leading-relaxed">Valeur minimale enregistrée</p>
                </div>

                <!-- Card 3 - Maximum -->
                <div class="p-6 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-300 slide-up slide-up-3" style="animation-delay: 0.5s;">
                    <div class="flex items-start justify-between mb-4">
                        <h3 class="text-sm font-medium text-white/70">Maximum</h3>
                        <div class="w-2 h-2 rounded-full bg-orange-400"></div>
                    </div>
                    <div class="mb-2">
                        <div id="maxValue" class="text-3xl font-semibold text-white">–</div>
                    </div>
                    <p class="text-xs text-white/50 leading-relaxed">Valeur maximale enregistrée</p>
                </div>

                <!-- Card 4 - Mesures -->
                <div class="p-6 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-300 slide-up slide-up-3" style="animation-delay: 0.6s;">
                    <div class="flex items-start justify-between mb-4">
                        <h3 class="text-sm font-medium text-white/70">Nombre de mesures</h3>
                        <div class="w-2 h-2 rounded-full bg-green-400"></div>
                    </div>
                    <div class="mb-2">
                        <div id="nbStations" class="text-3xl font-semibold text-white">–</div>
                    </div>
                    <p class="text-xs text-white/50 leading-relaxed">Mesures sur la période</p>
                </div>
            </div>

            <!-- Zone de visualisation principale -->
            <div class="p-8 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 slide-up slide-up-5">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-medium">Visualisation principale</h2>
                        <p id="chartSubtitle" class="text-white/50 text-sm mt-1">Évolution temporelle des données</p>
                    </div>
                    <div class="flex gap-2">
                        <button id="btnMapView" class="px-4 py-2 rounded-lg text-sm bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-300">
                            Carte
                        </button>
                        <button id="btnChartView" class="px-4 py-2 rounded-lg text-sm bg-white/10 border border-white/20 hover:bg-white/10 hover:border-white/20 transition-all duration-300">
                            Graphique
                        </button>
                        <button id="btnTableView" class="px-4 py-2 rounded-lg text-sm bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-300">
                            Tableau
                        </button>
                    </div>
                </div>

                <!-- Placeholder for the main graph -->
                <div id="chartView" class="h-96 rounded-xl bg-slate-900/50 border border-white/10 p-4 relative">
                    <!-- Loading state -->
                    <div id="chartLoading" class="absolute inset-0 flex items-center justify-center hidden">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-10 h-10 border-2 border-cyan-400/30 border-t-cyan-400 rounded-full animate-spin"></div>
                            <p class="text-white/50 text-sm">Chargement des données...</p>
                        </div>
                    </div>
                    
                    <!-- Empty state -->
                    <div id="chartEmpty" class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-16 h-16 mx-auto mb-4 text-cyan-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <p class="text-white/50 text-lg">Graphique d'évolution</p>
                            <p class="text-white/30 text-sm mt-2">Les données se chargeront automatiquement</p>
                        </div>
                    </div>
                    
                    <!-- Chart canvas -->
                    <canvas id="evolutionChart" class="w-full h-full"></canvas>
                </div>

                <!-- Map container -->
                <div id="mapView" class="h-96 rounded-xl bg-slate-900/50 border border-white/10 p-4 relative hidden">
                    <!-- Loading state -->
                    <div id="mapLoading" class="absolute inset-0 flex items-center justify-center hidden">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-10 h-10 border-2 border-cyan-400/30 border-t-cyan-400 rounded-full animate-spin"></div>
                            <p class="text-white/50 text-sm">Chargement de la carte...</p>
                        </div>
                    </div>
                    
                    <!-- Empty state -->
                    <div id="mapEmpty" class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-16 h-16 mx-auto mb-4 text-cyan-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                            <p class="text-white/50 text-lg">Carte interactive</p>
                            <p class="text-white/30 text-sm mt-2">Points de prélèvement sur la carte</p>
                        </div>
                    </div>
                    
                    <!-- Map container -->
                    <div id="mapContainer" class="w-full h-full rounded-lg overflow-hidden"></div>
                </div>

                <!-- Table container -->
                <div id="tableView" class="h-96 rounded-xl bg-slate-900/50 border border-white/10 p-4 relative hidden">
                    <!-- Loading state -->
                    <div id="tableLoading" class="absolute inset-0 flex items-center justify-center hidden">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-10 h-10 border-2 border-cyan-400/30 border-t-cyan-400 rounded-full animate-spin"></div>
                            <p class="text-white/50 text-sm">Chargement des données...</p>
                        </div>
                    </div>
                    
                    <!-- Empty state -->
                    <div id="tableEmpty" class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-16 h-16 mx-auto mb-4 text-cyan-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-white/50 text-lg">Tableau de données</p>
                            <p class="text-white/30 text-sm mt-2">Données détaillées des mesures</p>
                        </div>
                    </div>
                    
                    <!-- Table container -->
                    <div id="tableContainer" class="w-full h-full overflow-auto">
                        <table class="w-full text-sm text-white">
                            <thead class="text-white/70 border-b border-white/10">
                                <tr>
                                    <th class="px-4 py-2 text-left">Date</th>
                                    <th class="px-4 py-2 text-left">Latitude</th>
                                    <th class="px-4 py-2 text-left">Longitude</th>
                                    <th class="px-4 py-2 text-left">Valeur</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody" class="text-white/50">
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Map Legend - Outside the map -->
                <div id="mapLegendContainer" class="mt-4 flex items-center justify-center hidden">
                    <div class="bg-slate-900/90 backdrop-blur-sm border border-white/20 rounded-lg p-4">
                        <div class="text-sm font-medium text-white/80 mb-3">Qualité de l'eau</div>
                        <div class="flex items-center gap-6">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded-full bg-green-500"></div>
                                <span class="text-sm text-white/70" id="legendGood">Bon</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded-full bg-amber-500"></div>
                                <span class="text-sm text-white/70" id="legendModerate">Modéré</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded-full bg-red-500"></div>
                                <span class="text-sm text-white-70" id="legendPoor">Mauvais</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="chartLegend" class="mt-4 flex items-center justify-center gap-6 text-sm text-white/60 hidden">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-cyan-400"></span>
                        <span id="legendMetric">Valeur mesurée</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-cyan-400/30"></span>
                        <span>Moyenne journalière</span>
                    </div>
                </div>
            </div>

            <!-- Dashboard additionnel -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
                <!-- Graphique camembert - Répartition qualité -->
                <div class="p-6 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 slide-up slide-up-3">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium">Répartition de la qualité</h3>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-white/50">Trié par:</span>
                            <select id="pieChartSort" class="bg-white/5 border border-white/10 text-white text-sm rounded-lg px-3 py-1 focus:outline-none focus:border-cyan-400">
                                <option value="default">Par défaut</option>
                                <option value="count">Par nombre</option>
                                <option value="name">Par nom</option>
                            </select>
                        </div>
                    </div>
                    <div class="h-64 relative">
                        <canvas id="qualityPieChart"></canvas>
                        <div id="pieChartEmpty" class="absolute inset-0 flex items-center justify-center">
                            <p class="text-white/30">En attente de données...</p>
                        </div>
                    </div>
                </div>

                <!-- Histogramme mensuel -->
                <div class="p-6 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 slide-up slide-up-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium">Moyennes mensuelles</h3>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-white/50">Trié par:</span>
                            <select id="barChartSort" class="bg-white/5 border border-white/10 text-white text-sm rounded-lg px-3 py-1 focus:outline-none focus:border-cyan-400">
                                <option value="chronological">Chronologique</option>
                                <option value="value_asc">Valeur croissante</option>
                                <option value="value_desc">Valeur décroissante</option>
                            </select>
                        </div>
                    </div>
                    <div class="h-64 relative">
                        <canvas id="monthlyBarChart"></canvas>
                        <div id="barChartEmpty" class="absolute inset-0 flex items-center justify-center">
                            <p class="text-white/30">En attente de données...</p>
                        </div>
                    </div>
                </div>

                <!-- Jauge de valeur actuelle -->
                <div class="p-6 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 slide-up slide-up-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium">Valeur actuelle</h3>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-white/50">Afficher:</span>
                            <select id="gaugeType" class="bg-white/5 border border-white/10 text-white text-sm rounded-lg px-3 py-1 focus:outline-none focus:border-cyan-400">
                                <option value="average">Moyenne</option>
                                <option value="latest">Dernière valeur</option>
                                <option value="median">Médiane</option>
                            </select>
                        </div>
                    </div>
                    <div class="h-64 relative flex items-center justify-center">
                        <canvas id="gaugeChart"></canvas>
                        <div id="gaugeEmpty" class="absolute inset-0 flex items-center justify-center">
                            <p class="text-white/30">En attente de données...</p>
                        </div>
                    </div>
                </div>

                <!-- Graphique de dispersion -->
                <div class="p-6 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 slide-up slide-up-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium">Corrélation température/oxygène</h3>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-white/50">Afficher:</span>
                            <select id="scatterType" class="bg-white/5 border border-white/10 text-white text-sm rounded-lg px-3 py-1 focus:outline-none focus:border-cyan-400">
                                <option value="all">Toutes les données</option>
                                <option value="good">Qualité bonne uniquement</option>
                                <option value="recent">30 derniers jours</option>
                            </select>
                        </div>
                    </div>
                    <div class="h-64 relative">
                        <canvas id="scatterChart"></canvas>
                        <div id="scatterEmpty" class="absolute inset-0 flex items-center justify-center">
                            <p class="text-white/30">En attente de données...</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    let evolutionChart = null;
    let qualityPieChart = null;
    let monthlyBarChart = null;
    let gaugeChart = null;
    let scatterChart = null;
    let map = null;
    let markers = [];
    let currentView = 'chart';
    let availableDateRange = { min_date: null, max_date: null };
    let autoRefreshInterval = null;
    
    // Metric labels, units, and quality thresholds
    const metricConfig = {
        'dissoxygen': { 
            label: "Niveau d'oxygène", 
            unit: 'mg/L', 
            color: 'rgb(34, 211, 238)',
            thresholds: {
                good: { min: 6, max: Infinity, color: '#10b981', label: 'Bon' },
                moderate: { min: 4, max: 6, color: '#f59e0b', label: 'Modéré' },
                poor: { min: 0, max: 4, color: '#ef4444', label: 'Mauvais' }
            }
        },
        'water_temp': { 
            label: 'Température', 
            unit: '°C', 
            color: 'rgb(251, 146, 60)',
            thresholds: {
                good: { min: 15, max: 25, color: '#10b981', label: 'Normal' },
                moderate: { min: 10, max: 30, color: '#f59e0b', label: 'Élevé/Bas' },
                poor: { min: 0, max: 10, color: '#ef4444', label: 'Extrême' }
            }
        },
        'salinity': { 
            label: 'Salinité', 
            unit: 'PSU', 
            color: 'rgb(96, 165, 250)',
            thresholds: {
                good: { min: 33, max: 37, color: '#10b981', label: 'Normal' },
                moderate: { min: 30, max: 40, color: '#f59e0b', label: 'Varié' },
                poor: { min: 0, max: 30, color: '#ef4444', label: 'Anormal' }
            }
        },
        'ph': { 
            label: 'pH', 
            unit: '', 
            color: 'rgb(167, 139, 250)',
            thresholds: {
                good: { min: 7.5, max: 8.5, color: '#10b981', label: 'Optimal' },
                moderate: { min: 7.0, max: 9.0, color: '#f59e0b', label: 'Acceptable' },
                poor: { min: 0, max: 7.0, color: '#ef4444', label: 'Acide' }
            }
        }
    };

    // Function to determine quality based on metric value
    function getQualityLevel(metric, value) {
        const config = metricConfig[metric];
        if (!config || !config.thresholds || value === null) return null;
        
        const thresholds = config.thresholds;
        
        if (value >= thresholds.good.min && value <= thresholds.good.max) {
            return { ...thresholds.good, level: 'good' };
        } else if (value >= thresholds.moderate.min && value <= thresholds.moderate.max) {
            return { ...thresholds.moderate, level: 'moderate' };
        } else {
            return { ...thresholds.poor, level: 'poor' };
        }
    }

    async function loadDateRange() {
        try {
            const response = await fetch('/web/api/date-range.php');
            const data = await response.json();
            
            if (data.min_date && data.max_date) {
                availableDateRange = data;
                
                // Configurer les inputs de date
                const startDateInput = document.getElementById('startDate');
                const endDateInput = document.getElementById('endDate');
                
                startDateInput.min = data.min_date;
                startDateInput.max = data.max_date;
                endDateInput.min = data.min_date;
                endDateInput.max = data.max_date;
                
                // Définir les valeurs par défaut (dernière année)
                const maxDate = new Date(data.max_date);
                const defaultStartDate = new Date(maxDate);
                defaultStartDate.setFullYear(defaultStartDate.getFullYear() - 1);
                
                // S'assurer que la date de début n'est pas avant la date minimale
                const minDate = new Date(data.min_date);
                if (defaultStartDate < minDate) {
                    defaultStartDate.setTime(minDate.getTime());
                }
                
                startDateInput.value = defaultStartDate.toISOString().split('T')[0];
                endDateInput.value = data.max_date;
                
                // Afficher les informations sur les dates
                const minFormatted = new Date(data.min_date).toLocaleDateString('fr-FR');
                const maxFormatted = new Date(data.max_date).toLocaleDateString('fr-FR');
                
                document.getElementById('minDateInfo').textContent = `Min: ${minFormatted}`;
                document.getElementById('maxDateInfo').textContent = `Max: ${maxFormatted}`;
                
                document.getElementById('dateRangeInfo').classList.remove('hidden');
                document.getElementById('dateRangeText').textContent = 
                    `Données disponibles du ${minFormatted} au ${maxFormatted}`;
            }
        } catch (error) {
            console.error('Erreur lors du chargement des dates:', error);
        }
    }

    function validateDates() {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        
        if (startDate && endDate && startDate > endDate) {
            alert('La date de début doit être antérieure à la date de fin');
            return false;
        }
        return true;
    }

    function createChart(data, metric) {
        const ctx = document.getElementById('evolutionChart').getContext('2d');
        const config = metricConfig[metric] || metricConfig['dissoxygen'];
        
        // Destroy existing chart
        if (evolutionChart) {
            evolutionChart.destroy();
        }
        
        // Hide empty state, show chart
        document.getElementById('chartEmpty').classList.add('hidden');
        document.getElementById('chartLegend').classList.remove('hidden');
        document.getElementById('legendMetric').textContent = config.label;
        document.getElementById('chartSubtitle').textContent = `Évolution de ${config.label.toLowerCase()} sur la période sélectionnée`;
        
        // Create gradient
        const gradient = ctx.createLinearGradient(0, 0, 0, 350);
        gradient.addColorStop(0, config.color.replace('rgb', 'rgba').replace(')', ', 0.3)'));
        gradient.addColorStop(1, config.color.replace('rgb', 'rgba').replace(')', ', 0.0)'));
        
        evolutionChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: config.label,
                    data: data.values,
                    borderColor: config.color,
                    backgroundColor: gradient,
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: data.values.length > 50 ? 0 : 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: config.color,
                    pointBorderColor: 'rgba(15, 23, 42, 0.8)',
                    pointBorderWidth: 2,
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: config.color,
                    pointHoverBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleColor: 'rgba(255, 255, 255, 0.9)',
                        bodyColor: 'rgba(255, 255, 255, 0.7)',
                        borderColor: 'rgba(34, 211, 238, 0.3)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            title: function(context) {
                                return context[0].label;
                            },
                            label: function(context) {
                                return `${config.label}: ${context.parsed.y.toFixed(2)} ${config.unit}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.5)',
                            font: {
                                size: 11
                            },
                            maxRotation: 45,
                            minRotation: 45,
                            maxTicksLimit: 12
                        }
                    },
                    y: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.5)',
                            font: {
                                size: 11
                            },
                            callback: function(value) {
                                return value.toFixed(1) + (config.unit ? ' ' + config.unit : '');
                            }
                        }
                    }
                }
            }
        });
    }

    function processEvolutionData(evolution) {
        const labels = [];
        const values = [];
        
        if (!evolution || evolution.length === 0) {
            return { labels: [], values: [] };
        }
        
        // Trier par date
        evolution.sort((a, b) => new Date(a.date) - new Date(b.date));
        
        // Formater les données
        evolution.forEach(item => {
            const date = new Date(item.date);
            const label = date.toLocaleDateString('fr-FR', { 
                day: '2-digit',
                month: 'short', 
                year: evolution.length > 365 ? 'numeric' : '2-digit'
            });
            labels.push(label);
            values.push(parseFloat(item.value));
        });
        
        return { labels, values };
    }

    document.getElementById('btnAnalyse').addEventListener('click', () => {
        if (!validateDates()) return;
        
        const metric = document.getElementById('metric').value;
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;

        let url = `/web/api/analyse.php`
            + `?metric=${encodeURIComponent(metric)}`;
        
        if (startDate) {
            url += `&start_date=${encodeURIComponent(startDate)}`;
        }
        if (endDate) {
            url += `&end_date=${encodeURIComponent(endDate)}`;
        }

        // Show loading state
        document.getElementById('chartLoading').classList.remove('hidden');
        document.getElementById('chartEmpty').classList.add('hidden');

        fetch(url)
            .then(response => response.json())
            .then(data => {
                console.log('Réponse API:', data);

                // Update stats cards
                if (data.stats) {
                    document.getElementById('avgValue').textContent =
                        data.stats.avg_value !== null
                            ? Number(data.stats.avg_value).toFixed(2)
                            : '–';

                    document.getElementById('minValue').textContent =
                        data.stats.min_value !== null
                            ? Number(data.stats.min_value).toFixed(2)
                            : '–';

                    document.getElementById('maxValue').textContent =
                        data.stats.max_value !== null
                            ? Number(data.stats.max_value).toFixed(2)
                            : '–';
                }

                document.getElementById('nbStations').textContent =
                    data.nb_mesures ?? '–';
                
                // Enregistrer l'analyse si l'utilisateur est connecté et des données sont disponibles
                if (data.stats && data.nb_mesures > 0) {
                    saveAnalysis(metric, startDate, endDate, data.stats, data.nb_mesures);
                }
                
                // Handle chart view
                if (data.evolution && data.evolution.length > 0) {
                    const chartData = processEvolutionData(data.evolution);
                    createChart(chartData, metric);
                    document.getElementById('chartEmpty').classList.add('hidden');
                    document.getElementById('chartLegend').classList.remove('hidden');
                } else {
                    // Aucune donnée d'évolution
                    document.getElementById('chartEmpty').classList.remove('hidden');
                    document.getElementById('chartLegend').classList.add('hidden');
                }
                
                // Handle map view - add markers for measurement points
                if (currentView === 'map' && map) {
                    document.getElementById('mapEmpty').classList.add('hidden');
                    addMarkers(data.evolution || [], metric);
                }
                
                // Handle table view - populate with data
                if (currentView === 'table') {
                    document.getElementById('tableEmpty').classList.add('hidden');
                    populateTable(data.evolution || []);
                }
                
                // Hide loading state for all views
                document.getElementById('chartLoading').classList.add('hidden');
                document.getElementById('mapLoading').classList.add('hidden');
                document.getElementById('tableLoading').classList.add('hidden');
            })
            .catch(error => {
                console.error('Erreur API:', error);
                document.getElementById('chartLoading').classList.add('hidden');
                document.getElementById('chartEmpty').classList.remove('hidden');
                alert('Erreur lors de l\'analyse');
            });
    });

    // Fonction pour enregistrer une analyse utilisateur
    async function saveAnalysis(metric, startDate, endDate, stats, countMeasures) {
        try {
            const analysisData = {
                metric: metric,
                start_date: startDate,
                end_date: endDate,
                avg_value: stats.avg_value,
                min_value: stats.min_value,
                max_value: stats.max_value,
                count_measures: countMeasures,
                analysis_data: {
                    regions: [],
                    quality: 'good'
                }
            };

            const response = await fetch('/web/api/save-analysis.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(analysisData)
            });

            const result = await response.json();
            
            if (result.success) {
                console.log('Analyse enregistrée avec succès');
                // Optionnel: afficher une notification discrète
                showNotification('Analyse enregistrée dans votre profil');
            } else {
                console.error('Erreur lors de l\'enregistrement:', result.error);
            }
        } catch (error) {
            console.error('Erreur lors de l\'enregistrement de l\'analyse:', error);
        }
    }

    // Fonction pour afficher une notification
    function showNotification(message, type = 'success') {
        // Créer un élément de notification
        const notification = document.createElement('div');
        const bgColor = type === 'error' ? 'bg-red-500' : type === 'warning' ? 'bg-amber-500' : 'bg-green-500';
        notification.className = `fixed bottom-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in-up`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // Supprimer après 3 secondes
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    // View switching functions
    function switchView(view) {
        currentView = view;
        
        // Hide all views
        document.getElementById('chartView').classList.add('hidden');
        document.getElementById('mapView').classList.add('hidden');
        document.getElementById('tableView').classList.add('hidden');
        
        // Reset button styles
        document.getElementById('btnMapView').className = 'px-4 py-2 rounded-lg text-sm bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-300';
        document.getElementById('btnChartView').className = 'px-4 py-2 rounded-lg text-sm bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-300';
        document.getElementById('btnTableView').className = 'px-4 py-2 rounded-lg text-sm bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-300';
        
        // Show selected view and highlight button
        switch(view) {
            case 'map':
                document.getElementById('mapView').classList.remove('hidden');
                document.getElementById('btnMapView').className = 'px-4 py-2 rounded-lg text-sm bg-white/10 border border-white/20 hover:bg-white/10 hover:border-white/20 transition-all duration-300';
                initializeMap();
                break;
            case 'chart':
                document.getElementById('chartView').classList.remove('hidden');
                document.getElementById('btnChartView').className = 'px-4 py-2 rounded-lg text-sm bg-white/10 border border-white/20 hover:bg-white/10 hover:border-white/20 transition-all duration-300';
                break;
            case 'table':
                document.getElementById('tableView').classList.remove('hidden');
                document.getElementById('btnTableView').className = 'px-4 py-2 rounded-lg text-sm bg-white/10 border border-white/20 hover:bg-white/10 hover:border-white/20 transition-all duration-300';
                break;
        }
    }
    
    function initializeMap() {
        if (!map) {
            // Initialize the map
            map = L.map('mapContainer').setView([20, 0], 2);
            
            // Add beautiful dark tile layer
            L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                attribution: '© OpenStreetMap contributors © CARTO',
                subdomains: 'abcd',
                maxZoom: 19
            }).addTo(map);
        }
    }
    
    function addMarkers(data, metric) {
        // Clear existing markers
        markers.forEach(marker => map.removeLayer(marker));
        markers = [];
        
        // Update legend with metric-specific labels
        const config = metricConfig[metric];
        if (config && config.thresholds) {
            document.getElementById('legendGood').textContent = config.thresholds.good.label;
            document.getElementById('legendModerate').textContent = config.thresholds.moderate.label;
            document.getElementById('legendPoor').textContent = config.thresholds.poor.label;
            document.getElementById('mapLegendContainer').classList.remove('hidden');
        }
        
        if (data && data.length > 0) {
            const bounds = [];
            
            data.forEach(item => {
                if (item.latitude && item.longitude && item.value !== null) {
                    // Determine quality level and color
                    const quality = getQualityLevel(metric, parseFloat(item.value));
                    const color = quality ? quality.color : '#6b7280';
                    const qualityLabel = quality ? quality.label : 'Inconnu';
                    
                    const marker = L.circleMarker([item.latitude, item.longitude], {
                        radius: 10,
                        fillColor: color,
                        color: '#ffffff',
                        weight: 2,
                        opacity: 1,
                        fillOpacity: 0.8
                    }).addTo(map);
                    
                    // Add popup with measurement info and quality
                    const popupContent = `
                        <div style="color: white; min-width: 200px;">
                            <div style="margin-bottom: 8px;">
                                <strong style="color: ${color};">● ${qualityLabel}</strong>
                            </div>
                            <div><strong>Date:</strong> ${new Date(item.date).toLocaleDateString('fr-FR')}</div>
                            <div><strong>Latitude:</strong> ${item.latitude.toFixed(4)}</div>
                            <div><strong>Longitude:</strong> ${item.longitude.toFixed(4)}</div>
                            <div><strong>Valeur:</strong> ${parseFloat(item.value).toFixed(2)} ${metricConfig[metric]?.unit || ''}</div>
                        </div>
                    `;
                    marker.bindPopup(popupContent);
                    
                    // Add tooltip on hover
                    marker.bindTooltip(`${qualityLabel}: ${parseFloat(item.value).toFixed(2)} ${metricConfig[metric]?.unit || ''}`, {
                        permanent: false,
                        direction: 'top',
                        offset: [0, -10],
                        className: 'custom-tooltip'
                    });
                    
                    markers.push(marker);
                    bounds.push([item.latitude, item.longitude]);
                }
            });
            
            // Fit map to show all markers
            if (bounds.length > 0) {
                map.fitBounds(bounds, { padding: [20, 20] });
            }
        } else {
            // Hide legend if no data
            document.getElementById('mapLegendContainer').classList.add('hidden');
        }
    }
    
    function populateTable(data) {
        const tableBody = document.getElementById('tableBody');
        tableBody.innerHTML = '';
        
        if (data && data.length > 0) {
            data.forEach(item => {
                const row = document.createElement('tr');
                row.className = 'border-b border-white/5 hover:bg-white/5 transition-colors';
                row.innerHTML = `
                    <td class="px-4 py-2">${new Date(item.date).toLocaleDateString('fr-FR')}</td>
                    <td class="px-4 py-2">${item.latitude ? item.latitude.toFixed(4) : 'N/A'}</td>
                    <td class="px-4 py-2">${item.longitude ? item.longitude.toFixed(4) : 'N/A'}</td>
                    <td class="px-4 py-2">${item.value ? item.value.toFixed(2) : 'N/A'}</td>
                `;
                tableBody.appendChild(row);
            });
        }
    }
    
    // Event listeners for view buttons
    document.getElementById('btnMapView').addEventListener('click', () => switchView('map'));
    document.getElementById('btnChartView').addEventListener('click', () => switchView('chart'));
    document.getElementById('btnTableView').addEventListener('click', () => switchView('table'));

    // Event listeners for dynamic filters
    document.getElementById('metric').addEventListener('change', () => {
        // Plus de lancement automatique - uniquement avec le bouton
    });

    document.getElementById('startDate').addEventListener('change', () => {
        // Plus de lancement automatique - uniquement avec le bouton
    });

    document.getElementById('endDate').addEventListener('change', () => {
        // Plus de lancement automatique - uniquement avec le bouton
    });

    // Event listeners for chart filters
    document.getElementById('pieChartSort').addEventListener('change', () => {
        if (window.currentData) {
            updateQualityPieChart(window.currentData, window.currentMetric);
        }
    });

    document.getElementById('barChartSort').addEventListener('change', () => {
        if (window.currentData) {
            updateMonthlyBarChart(window.currentData, window.currentMetric);
        }
    });

    document.getElementById('gaugeType').addEventListener('change', () => {
        if (window.currentData) {
            updateGaugeChart(window.currentData, window.currentMetric);
        }
    });

    document.getElementById('scatterType').addEventListener('change', () => {
        if (window.currentData) {
            updateScatterChart(window.currentData, window.currentMetric);
        }
    });

    // Manual analysis button
    document.getElementById('btnAnalyse').addEventListener('click', () => {
        launchAnalysis();
        showNotification('Analyse lancée manuellement', 'success');
    });

    document.addEventListener('DOMContentLoaded', () => {
        loadDateRange();
        // Plus de chargement automatique - uniquement avec le bouton
    });

    // Fonction pour lancer l'analyse automatiquement
    function launchAnalysis() {
        if (!validateDates()) return;
        
        const metric = document.getElementById('metric').value;
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;

        let url = `/web/api/analyse.php`
            + `?metric=${encodeURIComponent(metric)}`;
        
        if (startDate) {
            url += `&start_date=${encodeURIComponent(startDate)}`;
        }
        if (endDate) {
            url += `&end_date=${encodeURIComponent(endDate)}`;
        }

        // Show loading states
        showAllLoadingStates();

        fetch(url)
            .then(response => response.json())
            .then(data => {
                console.log('Réponse API:', data);
                // Stocker les données pour les filtres
                window.currentData = data;
                window.currentMetric = metric;
                updateDashboard(data, metric);
                // Démarrer le rafraîchissement automatique uniquement après le premier lancement manuel
                if (!autoRefreshInterval) {
                    startAutoRefresh();
                }
            })
            .catch(error => {
                console.error('Erreur API:', error);
                hideAllLoadingStates();
                showNotification('Erreur lors du chargement des données', 'error');
            });
    }

    // Fonction pour démarrer le rafraîchissement automatique
    function startAutoRefresh() {
        if (autoRefreshInterval) {
            clearInterval(autoRefreshInterval);
        }
        autoRefreshInterval = setInterval(() => {
            console.log('Rafraîchissement automatique...');
            launchAnalysis();
        }, 30000); // Toutes les 30 secondes
    }

    // Fonction pour afficher tous les états de chargement
    function showAllLoadingStates() {
        document.getElementById('chartLoading').classList.remove('hidden');
        document.getElementById('chartEmpty').classList.add('hidden');
        document.getElementById('pieChartEmpty').classList.add('hidden');
        document.getElementById('barChartEmpty').classList.add('hidden');
        document.getElementById('gaugeEmpty').classList.add('hidden');
        document.getElementById('scatterEmpty').classList.add('hidden');
    }

    // Fonction pour cacher tous les états de chargement
    function hideAllLoadingStates() {
        document.getElementById('chartLoading').classList.add('hidden');
    }

    // Fonction principale pour mettre à jour tout le dashboard
    function updateDashboard(data, metric) {
        // Update stats cards
        updateStatsCards(data);
        
        // Update main chart
        updateMainChart(data, metric);
        
        // Update pie chart
        updateQualityPieChart(data, metric);
        
        // Update monthly bar chart
        updateMonthlyBarChart(data, metric);
        
        // Update gauge chart
        updateGaugeChart(data, metric);
        
        // Update scatter chart
        updateScatterChart(data, metric);
        
        // Update map and table if visible
        if (currentView === 'map' && map) {
            addMarkers(data.evolution || [], metric);
        }
        if (currentView === 'table') {
            populateTable(data.evolution || []);
        }
        
        // Hide loading states
        hideAllLoadingStates();
        
        // Save analysis if user is logged in
        if (data.stats && data.nb_mesures > 0) {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            saveAnalysis(metric, startDate, endDate, data.stats, data.nb_mesures);
        }
    }

    // Fonction pour mettre à jour les cartes de statistiques
    function updateStatsCards(data) {
        if (data.stats) {
            document.getElementById('avgValue').textContent =
                data.stats.avg_value !== null
                    ? Number(data.stats.avg_value).toFixed(2)
                    : '–';

            document.getElementById('minValue').textContent =
                data.stats.min_value !== null
                    ? Number(data.stats.min_value).toFixed(2)
                    : '–';

            document.getElementById('maxValue').textContent =
                data.stats.max_value !== null
                    ? Number(data.stats.max_value).toFixed(2)
                    : '–';
        }

        document.getElementById('nbStations').textContent =
            data.nb_mesures ?? '–';
    }

    // Fonction pour mettre à jour le graphique principal
    function updateMainChart(data, metric) {
        if (data.evolution && data.evolution.length > 0) {
            const chartData = processEvolutionData(data.evolution);
            createChart(chartData, metric);
            document.getElementById('chartEmpty').classList.add('hidden');
            document.getElementById('chartLegend').classList.remove('hidden');
        } else {
            document.getElementById('chartEmpty').classList.remove('hidden');
            document.getElementById('chartLegend').classList.add('hidden');
        }
    }

    // Fonction pour créer le graphique camembert de qualité
    function updateQualityPieChart(data, metric) {
        const ctx = document.getElementById('qualityPieChart').getContext('2d');
        
        if (qualityPieChart) {
            qualityPieChart.destroy();
        }

        if (!data.evolution || data.evolution.length === 0) {
            document.getElementById('pieChartEmpty').classList.remove('hidden');
            return;
        }

        document.getElementById('pieChartEmpty').classList.add('hidden');

        // Calculer la répartition des qualités
        const qualityCounts = { good: 0, moderate: 0, poor: 0 };
        data.evolution.forEach(item => {
            if (item.value !== null) {
                const quality = getQualityLevel(metric, parseFloat(item.value));
                if (quality) {
                    qualityCounts[quality.level]++;
                }
            }
        });

        const config = metricConfig[metric];
        const sortType = document.getElementById('pieChartSort').value;
        
        let labels = [
            config.thresholds.good.label,
            config.thresholds.moderate.label,
            config.thresholds.poor.label
        ];
        let values = [qualityCounts.good, qualityCounts.moderate, qualityCounts.poor];
        let colors = [
            config.thresholds.good.color,
            config.thresholds.moderate.color,
            config.thresholds.poor.color
        ];

        // Appliquer le tri
        if (sortType === 'count') {
            // Trier par nombre décroissant
            const indices = [0, 1, 2].sort((a, b) => values[b] - values[a]);
            labels = indices.map(i => labels[i]);
            values = indices.map(i => values[i]);
            colors = indices.map(i => colors[i]);
        } else if (sortType === 'name') {
            // Trier par nom alphabétique
            const indices = [0, 1, 2].sort((a, b) => labels[a].localeCompare(labels[b]));
            labels = indices.map(i => labels[i]);
            values = indices.map(i => values[i]);
            colors = indices.map(i => colors[i]);
        }

        qualityPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: colors,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: 'rgba(255, 255, 255, 0.7)',
                            padding: 15,
                            font: {
                                size: 11
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleColor: 'rgba(255, 255, 255, 0.9)',
                        bodyColor: 'rgba(255, 255, 255, 0.7)',
                        borderColor: 'rgba(34, 211, 238, 0.3)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 12
                    }
                }
            }
        });
    }

    // Fonction pour créer l'histogramme mensuel
    function updateMonthlyBarChart(data, metric) {
        const ctx = document.getElementById('monthlyBarChart').getContext('2d');
        
        if (monthlyBarChart) {
            monthlyBarChart.destroy();
        }

        if (!data.evolution || data.evolution.length === 0) {
            document.getElementById('barChartEmpty').classList.remove('hidden');
            return;
        }

        document.getElementById('barChartEmpty').classList.add('hidden');

        // Grouper par mois
        const monthlyData = {};
        const monthNames = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];
        
        data.evolution.forEach(item => {
            if (item.value !== null) {
                const date = new Date(item.date);
                const monthKey = `${date.getFullYear()}-${date.getMonth()}`;
                const monthLabel = monthNames[date.getMonth()];
                
                if (!monthlyData[monthKey]) {
                    monthlyData[monthKey] = { label: monthLabel, values: [], count: 0, fullDate: date };
                }
                monthlyData[monthKey].values.push(parseFloat(item.value));
                monthlyData[monthKey].count++;
            }
        });

        // Calculer les moyennes mensuelles
        let monthlyArray = Object.entries(monthlyData).map(([key, month]) => ({
            key,
            label: month.label,
            average: month.values.reduce((a, b) => a + b, 0) / month.values.length,
            fullDate: month.fullDate
        }));

        // Appliquer le tri
        const sortType = document.getElementById('barChartSort').value;
        if (sortType === 'value_asc') {
            monthlyArray.sort((a, b) => a.average - b.average);
        } else if (sortType === 'value_desc') {
            monthlyArray.sort((a, b) => b.average - a.average);
        } else {
            // Chronologique (par défaut)
            monthlyArray.sort((a, b) => a.fullDate - b.fullDate);
        }

        const labels = monthlyArray.map(item => item.label);
        const averages = monthlyArray.map(item => item.average);

        const config = metricConfig[metric];
        monthlyBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: `Moyenne ${config.label}`,
                    data: averages,
                    backgroundColor: config.color.replace('rgb', 'rgba').replace(')', ', 0.6)'),
                    borderColor: config.color,
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleColor: 'rgba(255, 255, 255, 0.9)',
                        bodyColor: 'rgba(255, 255, 255, 0.7)',
                        borderColor: 'rgba(34, 211, 238, 0.3)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                return `${config.label}: ${context.parsed.y.toFixed(2)} ${config.unit}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.5)',
                            font: {
                                size: 10
                            }
                        }
                    },
                    y: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.5)',
                            font: {
                                size: 10
                            },
                            callback: function(value) {
                                return value.toFixed(1) + (config.unit ? ' ' + config.unit : '');
                            }
                        }
                    }
                }
            }
        });
    }

    // Fonction pour créer la jauge
    function updateGaugeChart(data, metric) {
        const ctx = document.getElementById('gaugeChart').getContext('2d');
        
        if (gaugeChart) {
            gaugeChart.destroy();
        }

        if (!data.evolution || data.evolution.length === 0) {
            document.getElementById('gaugeEmpty').classList.remove('hidden');
            return;
        }

        document.getElementById('gaugeEmpty').classList.add('hidden');

        const config = metricConfig[metric];
        const gaugeType = document.getElementById('gaugeType').value;
        let currentValue;
        let displayValue;
        
        // Calculer la valeur selon le type
        const validValues = data.evolution
            .filter(item => item.value !== null)
            .map(item => parseFloat(item.value));
            
        if (validValues.length === 0) {
            document.getElementById('gaugeEmpty').classList.remove('hidden');
            return;
        }
        
        switch (gaugeType) {
            case 'latest':
                // Dernière valeur
                const sortedByDate = data.evolution
                    .filter(item => item.value !== null)
                    .sort((a, b) => new Date(b.date) - new Date(a.date));
                currentValue = parseFloat(sortedByDate[0].value);
                displayValue = currentValue;
                break;
            case 'median':
                // Médiane
                validValues.sort((a, b) => a - b);
                const mid = Math.floor(validValues.length / 2);
                currentValue = validValues.length % 2 !== 0 
                    ? validValues[mid] 
                    : (validValues[mid - 1] + validValues[mid]) / 2;
                displayValue = currentValue;
                break;
            default: // average
                // Moyenne
                currentValue = validValues.reduce((a, b) => a + b, 0) / validValues.length;
                displayValue = currentValue;
        }
        
        const thresholds = config.thresholds;
        
        // Créer une jauge simple avec un graphique de type 'doughnut' partiel
        const maxValue = Math.max(thresholds.good.max || 10, thresholds.moderate.max || 8, currentValue * 1.2);
        const gaugeData = {
            datasets: [{
                data: [currentValue, maxValue - currentValue],
                backgroundColor: [
                    currentValue >= thresholds.good.min ? '#10b981' :
                    currentValue >= thresholds.moderate.min ? '#f59e0b' : '#ef4444',
                    'rgba(255, 255, 255, 0.1)'
                ],
                borderWidth: 0
            }]
        };

        gaugeChart = new Chart(ctx, {
            type: 'doughnut',
            data: gaugeData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                rotation: -90,
                circumference: 180,
                cutout: '75%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const typeLabel = gaugeType === 'latest' ? 'Dernière valeur' : 
                                                 gaugeType === 'median' ? 'Médiane' : 'Moyenne';
                                return `${typeLabel}: ${displayValue.toFixed(2)} ${config.unit}`;
                            }
                        }
                    }
                }
            }
        });

        // Ajouter le texte au centre de la jauge
        setTimeout(() => {
            ctx.font = 'bold 20px sans-serif';
            ctx.fillStyle = 'white';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            const typeLabel = gaugeType === 'latest' ? 'Dernière' : 
                             gaugeType === 'median' ? 'Médiane' : 'Moyenne';
            ctx.fillText(`${displayValue.toFixed(1)}${config.unit}`, ctx.canvas.width / 2, ctx.canvas.height / 2 - 10);
            ctx.font = '12px sans-serif';
            ctx.fillStyle = 'rgba(255, 255, 255, 0.7)';
            ctx.fillText(typeLabel, ctx.canvas.width / 2, ctx.canvas.height / 2 + 15);
        }, 100);
    }

    // Fonction pour créer le graphique de dispersion
    function updateScatterChart(data, metric) {
        const ctx = document.getElementById('scatterChart').getContext('2d');
        
        if (scatterChart) {
            scatterChart.destroy();
        }

        if (!data.evolution || data.evolution.length === 0) {
            document.getElementById('scatterEmpty').classList.remove('hidden');
            return;
        }

        document.getElementById('scatterEmpty').classList.add('hidden');

        const scatterType = document.getElementById('scatterType').value;
        let filteredData = data.evolution.filter(item => item.value !== null);
        
        // Appliquer les filtres
        if (scatterType === 'good') {
            // Qualité bonne uniquement
            filteredData = filteredData.filter(item => {
                const quality = getQualityLevel(metric, parseFloat(item.value));
                return quality && quality.level === 'good';
            });
        } else if (scatterType === 'recent') {
            // 30 derniers jours
            const thirtyDaysAgo = new Date();
            thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);
            filteredData = filteredData.filter(item => {
                return new Date(item.date) >= thirtyDaysAgo;
            });
        }
        
        // Pour cet exemple, nous allons simuler des données de température
        // En réalité, vous devriez récupérer ces données depuis l'API
        const scatterData = filteredData.map(item => ({
            x: parseFloat(item.value), // Oxygène
            y: 15 + Math.random() * 20 // Température simulée
        }));

        scatterChart = new Chart(ctx, {
            type: 'scatter',
            data: {
                datasets: [{
                    label: 'O2 vs Température',
                    data: scatterData,
                    backgroundColor: 'rgba(167, 139, 250, 0.6)',
                    borderColor: 'rgba(167, 139, 250, 1)',
                    borderWidth: 1,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleColor: 'rgba(255, 255, 255, 0.9)',
                        bodyColor: 'rgba(255, 255, 255, 0.7)',
                        borderColor: 'rgba(34, 211, 238, 0.3)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                return [`O2: ${context.parsed.x.toFixed(2)} mg/L`, `Temp: ${context.parsed.y.toFixed(1)}°C`];
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Oxygène (mg/L)',
                            color: 'rgba(255, 255, 255, 0.7)'
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.5)',
                            font: {
                                size: 10
                            }
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Température (°C)',
                            color: 'rgba(255, 255, 255, 0.7)'
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.5)',
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            }
        });
    }
    </script>
</body>
</html>
