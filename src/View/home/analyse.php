<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analyse - AquaView</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>
    <style>
        .fade-in { animation: fadeIn 0.3s ease-out forwards; }
        .slide-up { animation: slideUp 0.3s ease-out forwards; opacity: 0; }
        .slide-up-1 { animation-delay: 0.1s; }
        .slide-up-2 { animation-delay: 0.2s; }
        .slide-up-3 { animation-delay: 0.3s; }
        .slide-up-4 { animation-delay: 0.4s; }
        .slide-up-5 { animation-delay: 0.5s; }
        .zoom-in { animation: zoomIn 1s ease-out forwards; }
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
        
        /* Optimisations de performance */
        .animate-pulse {
            animation: pulse 1.5s infinite;
        }
        
        .slide-up {
            will-change: transform, opacity;
            backface-visibility: hidden;
            transform: translateZ(0);
        }
        
        /* Réduire les repaints */
        .chart-container,
        .map-container {
            contain: layout;
            content-visibility: visible;
        }
        
        /* Optimiser les transitions */
        * {
            transition: opacity 0.2s ease-out, transform 0.2s ease-out;
        }
        
        /* Correction du débordement des graphiques météo */
        #weatherAnalysisContainer {
            max-width: 100%;
            overflow: hidden;
        }
        
        #weatherBarChart, #weatherPieChart {
            max-width: 100% !important;
            height: auto !important;
            max-height: 300px !important;
        }
        
        .weather-chart-container {
            position: relative;
            height: 300px;
            width: 100%;
            overflow: hidden;
        }
        
        /* Conteneur principal pour éviter le débordement */
        .weather-results-grid {
            max-width: 100%;
            overflow-x: hidden;
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
                <div class="max-w-3xl">
                    <p class="text-white/60 text-lg leading-relaxed mb-6">
                        Explorez les données de désoxygénation en temps réel et identifiez les zones critiques.
                    </p>
                    
                    <!-- Section explicative approfondie sur la désoxygénation -->
                    <div class="p-6 rounded-2xl backdrop-blur-xl bg-gradient-to-r from-red-500/10 to-orange-500/10 border border-red-500/20 w-full">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-red-500 to-orange-500 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77 1.333-1.732 3z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-semibold text-white mb-4">Qu'est-ce que la désoxygénation océanique ?</h3>
                                <div class="space-y-4 text-white/80 text-base leading-relaxed">
                                    <p>
                                        La <strong class="text-white">désoxygénation océanique</strong> est un phénomène environnemental majeur qui affecte la santé de nos océans. 
                                        Elle se caractérise par une <strong class="text-orange-300">baisse progressive du taux d'oxygène dissous</strong> dans les masses d'eau, 
                                        menaçant directement la vie marine et les écosystèmes.
                                    </p>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                        <div class="p-4 rounded-lg bg-white/5 border border-white/10">
                                            <h4 class="text-lg font-medium text-orange-300 mb-2">Causes principales</h4>
                                            <ul class="space-y-2 text-sm text-white/70">
                                                <li class="flex items-start gap-2">
                                                    <span class="text-red-400 font-bold">•</span>
                                                    <span><strong>Réchauffement climatique</strong> : L'eau chaude retient moins d'oxygène</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-red-400 font-bold">•</span>
                                                    <span><strong>Eutrophisation</strong> : Excès de nutriments qui consomment l'oxygène</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-red-400 font-bold">•</span>
                                                    <span><strong>Pollution</strong> : Produits chimiques qui réduisent l'oxygénation</span>
                                                </li>
                                            </ul>
                                        </div>
                                        
                                        <div class="p-4 rounded-lg bg-white/5 border border-white/10">
                                            <h4 class="text-lg font-medium text-green-300 mb-2">Conséquences</h4>
                                            <ul class="space-y-2 text-sm text-white/70">
                                                <li class="flex items-start gap-2">
                                                    <span class="text-green-400 font-bold">•</span>
                                                    <span><strong>Zones mortes</strong> : Zones sans vie marine</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-green-400 font-bold">•</span>
                                                    <span><strong>Migrations d'espèces</strong> : Animaux fuient les zones pauvres en oxygène</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="text-green-400 font-bold">•</span>
                                                    <span><strong>Pertes économiques</strong> : Impact sur la pêche et le tourisme</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-6 p-4 rounded-lg bg-blue-500/10 border border-blue-500/20">
                                        <h4 class="text-lg font-medium text-blue-300 mb-2">Pour en savoir plus</h4>
                                        <div class="space-y-2 text-sm">
                                            <p class="text-white/80">
                                                <strong class="text-blue-200">Ressources scientifiques :</strong>
                                            </p>
                                            <ul class="space-y-2 text-white/70 ml-4">

                                                <li>
                                                    <a href="https://www.ocean-climate.org/wp-content/uploads/2017/02/océan-bout-souffle_FichesScientifiques_04-6.pdf" 
                                                       target="_blank" 
                                                       class="text-cyan-300 hover:text-cyan-200 underline transition-colors">
                                                        Ocean Climate : L'océan est à bout de souffle
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-white mb-6">Indicateurs clés de la désoxygénation</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Card 1 - Valeur moyenne -->
                    <div class="p-6 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-300 slide-up slide-up-3">
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-sm font-medium text-white/70">Niveau moyen</h3>
                            <div class="w-2 h-2 rounded-full bg-cyan-400"></div>
                        </div>
                        <div class="mb-2">
                            <div id="avgValue" class="text-3xl font-semibold text-white">–</div>
                        </div>
                        <p class="text-xs text-white/50 leading-relaxed">État général de l'écosystème</p>
                    </div>

                    <!-- Card 2 - Minimum (critique) -->
                    <div class="p-6 rounded-2xl backdrop-blur-xl bg-gradient-to-br from-red-500/10 to-red-600/10 border border-red-500/20 hover:from-red-500/20 hover:to-red-600/20 transition-all duration-300 slide-up slide-up-3" style="animation-delay: 0.4s;">
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-sm font-medium text-white/70">Niveau critique</h3>
                            <div class="w-2 h-2 rounded-full bg-red-400 animate-pulse"></div>
                        </div>
                        <div class="mb-2">
                            <div id="minValue" class="text-3xl font-semibold text-white">–</div>
                        </div>
                        <p class="text-xs text-white/50 leading-relaxed">Point le plus à risque - Zone morte potentielle</p>
                    </div>

                    <!-- Card 3 - Maximum -->
                    <div class="p-6 rounded-2xl backdrop-blur-xl bg-gradient-to-br from-green-500/10 to-green-600/10 border border-green-500/20 hover:from-green-500/20 hover:to-green-600/20 transition-all duration-300 slide-up slide-up-3" style="animation-delay: 0.5s;">
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-sm font-medium text-white/70">Niveau optimal</h3>
                            <div class="w-2 h-2 rounded-full bg-green-400"></div>
                        </div>
                        <div class="mb-2">
                            <div id="maxValue" class="text-3xl font-semibold text-white">–</div>
                        </div>
                        <p class="text-xs text-white/50 leading-relaxed">Meilleure zone - Refuge pour la vie marine</p>
                    </div>

                    <!-- Card 4 - Mesures -->
                    <div class="p-6 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-300 slide-up slide-up-3" style="animation-delay: 0.6s;">
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-sm font-medium text-white/70">Points de mesure</h3>
                            <div class="w-2 h-2 rounded-full bg-purple-400"></div>
                        </div>
                        <div class="mb-2">
                            <div id="nbStations" class="text-3xl font-semibold text-white">–</div>
                        </div>
                        <p class="text-xs text-white/50 leading-relaxed">Couverture du territoire analysé</p>
                    </div>
                </div>
            </div>

            <!-- Section Analyse Météo (INDÉPENDANTE) -->
            <div class="mb-8 p-6 rounded-2xl backdrop-blur-xl bg-gradient-to-r from-blue-500/5 to-purple-500/5 border border-blue-500/20 slide-up slide-up-4">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-medium flex items-center gap-3">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                            </svg>
                            Analyse par conditions météo
                        </h2>
                        <p class="text-white/50 text-sm mt-1">Impact des conditions météorologiques sur les niveaux d'oxygène</p>
                    </div>
                    
             
                    <button id="btnWeatherAnalysis" class="px-4 py-2 rounded-lg text-sm bg-blue-500/10 border border-blue-500/30 hover:bg-blue-500/20 transition-all duration-300 text-blue-300">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Actualiser
                        </span>
                    </button>
                </div>

                <!-- Conteneur pour l'analyse météo -->
                <div id="weatherAnalysisContainer">
                    <!-- État de chargement -->
                    <div id="weatherLoading" class="hidden">
                        <div class="flex items-center justify-center py-12">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-10 h-10 border-2 border-blue-400/30 border-t-blue-400 rounded-full animate-spin"></div>
                                <p class="text-white/50 text-sm">Analyse des conditions météo...</p>
                            </div>
                        </div>
                    </div>

                    <!-- État vide -->
                    <div id="weatherEmpty" class="">
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto mb-4 text-blue-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                            </svg>
                            <p class="text-white/50 text-lg">Analyse météo</p>
                            <p class="text-white/30 text-sm mt-2">Cliquez sur "Actualiser" pour lancer l'analyse</p>
                        </div>
                    </div>

                    <!-- Résultats de l'analyse -->
                    <div id="weatherResults" class="hidden">
                        <!-- Cartes de résumé météo -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm text-white/60">Météo dominante</span>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 7c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zM2 13h2c.55 0 1-.45 1-1s-.45-1-1-1H2c-.55 0-1 .45-1 1s.45 1 1 1zm18 0h2c.55 0 1-.45 1-1s-.45-1-1-1h-2c-.55 0-1 .45-1 1s.45 1 1 1zM11 2v2c0 .55.45 1 1 1s1-.45 1-1V2c0-.55-.45-1-1-1s-1 .45-1 1zm0 18v2c0 .55.45 1 1 1s1-.45 1-1v-2c0-.55-.45-1-1-1s-1 .45-1 1z"/>
                                    </svg>
                                </div>
                                <div id="dominantWeather" class="text-xl font-semibold text-white">–</div>
                            </div>
                            
                            <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm text-white/60">Types de météo</span>
                                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                                <div id="weatherTypesCount" class="text-xl font-semibold text-white">–</div>
                            </div>
                            
                            <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm text-white/60">Impact météo</span>
                                    <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </div>
                                <div id="weatherImpact" class="text-xl font-semibold text-white">–</div>
                            </div>
                        </div>

                        <!-- Graphique des données météo -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 weather-results-grid">
                            <!-- Graphique barres : moyennes par météo -->
                            <div class="p-4 rounded-xl bg-slate-900/50 border border-white/10">
                                <h3 class="text-lg font-medium text-white mb-4">Valeurs moyennes par condition météo</h3>
                                <div class="weather-chart-container">
                                    <canvas id="weatherBarChart"></canvas>
                                </div>
                            </div>
                            
                            <!-- Graphique camembert : distribution météo -->
                            <div class="p-4 rounded-xl bg-slate-900/50 border border-white/10">
                                <h3 class="text-lg font-medium text-white mb-4">Distribution des mesures par météo</h3>
                                <div class="weather-chart-container">
                                    <canvas id="weatherPieChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Tableau détaillé -->
                        <div class="mt-6 p-4 rounded-xl bg-slate-900/50 border border-white/10">
                            <h3 class="text-lg font-medium text-white mb-4">Détails par condition météo</h3>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-white">
                                    <thead class="text-white/70 border-b border-white/10">
                                        <tr>
                                            <th class="px-4 py-2 text-left">Condition météo</th>
                                            <th class="px-4 py-2 text-left">Nombre de mesures</th>
                                            <th class="px-4 py-2 text-left">Valeur moyenne</th>
                                            <th class="px-4 py-2 text-left">Min</th>
                                            <th class="px-4 py-2 text-left">Max</th>
                                            <th class="px-4 py-2 text-left">Écart-type</th>
                                        </tr>
                                    </thead>
                                    <tbody id="weatherTableBody" class="text-white/50">
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-white/30">
                                                Sélectionnez une métrique pour voir les détails
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                               <!-- Texte explicatif sur l'influence des indicateurs météo -->
                    <div class="mt-4 p-4 rounded-xl bg-blue-500/10 border border-blue-500/20">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="text-sm text-white/80 leading-relaxed">
                                <p class="font-medium text-blue-300 mb-2">Pourquoi la météo influence-t-elle les indicateurs ?</p>
                                <p class="mb-2">
                                    Les conditions météorologiques affectent directement les paramètres océaniques mesurés :
                                </p>
                                <ul class="space-y-1 text-white/70 ml-4">
                                    <li><span class="text-cyan-300">•</span> <strong>Niveau d'oxygène</strong> : Le soleil et la température influencent la photosynthèse et la dissolution de l'oxygène</li>
                                    <li><span class="text-cyan-300">•</span> <strong>Température</strong> : Directement liée à l'ensoleillement et à la couverture nuageuse</li>
                                    <li><span class="text-cyan-300">•</span> <strong>Salinité</strong> : Les précipitations diluent l'eau de mer, modifiant sa salinité</li>
                                    <li><span class="text-cyan-300">•</span> <strong>pH</strong> : Le CO2 atmosphérique et les conditions météo affectent l'acidité de l'océan</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            

            <!-- Zone de visualisation principale -->
            <div class="mb-8 p-6 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 slide-up slide-up-5">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-medium">Analyse spatiale et temporelle</h2>
                        <p id="chartSubtitle" class="text-white/50 text-sm mt-1">Visualisez l'évolution et la répartition des niveaux d'oxygène pour identifier les zones critiques</p>
                    </div>
                    <div class="flex items-center gap-3">
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
                        <!-- Sélecteur de type d'affichage de carte -->
                        <div id="mapDisplayOptions" class="hidden items-center gap-2 pl-3 border-l border-white/20">
                            <span class="text-sm text-white/50">Affichage:</span>
                            <select id="mapDisplayType" class="bg-white/5 border border-white/10 text-white text-sm rounded-lg px-3 py-1 focus:outline-none focus:border-cyan-400">
                                <option value="markers">Pastilles</option>
                                <option value="heatmap">Zones de chaleur</option>
                            </select>
                        </div>
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
                            <p class="text-white/30 text-sm mt-2">Données détaillées avec état de santé</p>
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
                                    <th class="px-4 py-2 text-left">État</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody" class="text-white/50">
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Section d'exportation -->
                <div class="mt-6 p-6 rounded-xl bg-gradient-to-r from-blue-500/10 to-cyan-500/10 border border-white/10">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-medium text-white">Exporter les données</h3>
                            <p class="text-white/50 text-sm mt-1">Téléchargez les résultats d'analyse dans différents formats</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-white/40">Format actuel:</span>
                            <span id="currentMetric" class="text-sm font-medium text-cyan-400">Oxygène dissous</span>
                        </div>
                    </div>
                    
                    <!-- Exportation des données brutes -->
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-white/70 mb-3">Données brutes</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <!-- Bouton JSON -->
                            <button onclick="exportData('json')" class="group relative px-4 py-3 rounded-lg bg-white/5 border border-white/10 hover:bg-white/10 hover:border-cyan-400/30 transition-all duration-300">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-6 h-6 text-cyan-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-sm font-medium text-white">JSON</span>
                                    <span class="text-xs text-white/50">Données structurées</span>
                                </div>
                            </button>
                            
                            <!-- Bouton CSV -->
                            <button onclick="exportData('csv')" class="group relative px-4 py-3 rounded-lg bg-white/5 border border-white/10 hover:bg-white/10 hover:border-green-400/30 transition-all duration-300">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-6 h-6 text-green-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v1a1 1 0 001 1h4a1 1 0 001-1v-1m3-2V8a2 2 0 00-2-2H8a2 2 0 00-2 2v8m5-4h4"/>
                                    </svg>
                                    <span class="text-sm font-medium text-white">CSV</span>
                                    <span class="text-xs text-white/50">Tableur Excel</span>
                                </div>
                            </button>
                            
                            <!-- Bouton NetCDF -->
                            <button onclick="exportData('netcdf')" class="group relative px-4 py-3 rounded-lg bg-white/5 border border-white/10 hover:bg-white/10 hover:border-purple-400/30 transition-all duration-300">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-6 h-6 text-purple-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                    <span class="text-sm font-medium text-white">NetCDF</span>
                                    <span class="text-xs text-white/50">Format scientifique</span>
                                </div>
                            </button>
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
            </div>
            
            <!-- Section de comparaison entre indicateurs -->
            <div class="mt-8">
                <!-- Introduction explicative -->
                <div class="mb-6 p-6 rounded-2xl backdrop-blur-xl bg-gradient-to-r from-blue-500/10 to-purple-500/10 border border-blue-500/20">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-white mb-3">Analyse comparative des indicateurs</h3>
                            <div class="space-y-3 text-white/70 text-base">
                                <p>
                                    Cette section vous permet d'explorer les <strong class="text-white">relations entre différents paramètres océaniques</strong> pour mieux comprendre les interactions complexes qui gouvernent la désoxygénation.
                                </p>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                    <div class="p-3 rounded-lg bg-white/5 border border-white/10">
                                        <h4 class="text-sm font-medium text-cyan-300 mb-2">Corrélation temporelle</h4>
                                        <p class="text-sm text-white/60">Observez comment deux indicateurs évoluent simultanément dans le temps pour identifier des tendances communes ou opposées.</p>
                                    </div>
                                    <div class="p-3 rounded-lg bg-white/5 border border-white/10">
                                        <h4 class="text-sm font-medium text-purple-300 mb-2">Analyse de corrélation</h4>
                                        <p class="text-sm text-white/60">Visualisez la relation directe entre deux variables avec leur coefficient de corrélation pour mesurer leur interdépendance.</p>
                                    </div>
                                    <div class="p-3 rounded-lg bg-white/5 border border-white/10">
                                        <h4 class="text-sm font-medium text-green-300 mb-2">Matrice de corrélation</h4>
                                        <p class="text-sm text-white/60">Obtenez une vue d'ensemble de toutes les relations entre les indicateurs pour identifier les patterns globaux.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-white">Comparaison entre indicateurs</h2>
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-white/50">Comparer:</span>
                        <select id="metric1" class="bg-white/5 border border-white/10 text-white text-sm rounded-lg px-3 py-1 focus:outline-none focus:border-cyan-400">
                            <option value="dissoxygen">Oxygène dissous</option>
                            <option value="water_temp">Température</option>
                            <option value="salinity">Salinité</option>
                            <option value="ph">pH</option>
                        </select>
                        <span class="text-sm text-white/50">vs</span>
                        <select id="metric2" class="bg-white/5 border border-white/10 text-white text-sm rounded-lg px-3 py-1 focus:outline-none focus:border-cyan-400">
                            <option value="water_temp">Température</option>
                            <option value="dissoxygen">Oxygène dissous</option>
                            <option value="salinity">Salinité</option>
                            <option value="ph">pH</option>
                        </select>
                    </div>
                </div>
                
                <!-- Section explicative pour la comparaison -->
                <div class="mb-6 p-6 rounded-2xl backdrop-blur-xl bg-gradient-to-r from-blue-500/10 to-purple-500/10 border border-blue-500/20">
                    <div id="comparisonExplanation">
                        <!-- L'explication sera ajoutée dynamiquement ici -->
                    </div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Graphique de corrélation double axe -->
                    <div class="p-6 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 slide-up slide-up-3">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium">Corrélation temporelle</h3>
                        </div>
                        
                        <!-- Paragraphe explicatif -->
                        <div class="mb-4 p-3 rounded-lg bg-cyan-500/10 border border-cyan-500/20">
                            <p class="text-sm text-cyan-200">
                                <strong class="text-cyan-100">Analyse temporelle :</strong> Ce graphique montre l'évolution de deux indicateurs sur la même période temporelle. 
                                Les axes doubles permettent de visualiser des échelles différentes. Une corrélation positive (les courbes évoluent dans le même sens) 
                                peut indiquer une influence directe, tandis qu'une corrélation négative (sens opposé) suggère une relation inverse.
                            </p>
                        </div>
                        
                        <div class="h-64 relative">
                            <canvas id="correlationChart"></canvas>
                            <div id="correlationEmpty" class="absolute inset-0 flex items-center justify-center">
                                <p class="text-white/30">En attente de données...</p>
                            </div>
                        </div>
                        <div class="mt-3 p-3 rounded-lg bg-white/5 border border-white/10">
                            <p class="text-xs text-white/60" id="correlationDescription">
                                Ce graphique montre l'évolution simultanée de deux indicateurs pour identifier leurs relations temporelles.
                            </p>
                        </div>
                    </div>

                    <!-- Graphique de dispersion amélioré -->
                    <div class="p-6 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 slide-up slide-up-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium">Analyse de corrélation</h3>
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-white/50">Tendance:</span>
                                <select id="trendType" class="bg-white/5 border border-white/10 text-white text-sm rounded-lg px-3 py-1 focus:outline-none focus:border-cyan-400">
                                    <option value="none">Aucune</option>
                                    <option value="linear">Linéaire</option>
                                    <option value="polynomial">Polynomiale</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Paragraphe explicatif -->
                        <div class="mb-4 p-3 rounded-lg bg-purple-500/10 border border-purple-500/20">
                            <p class="text-sm text-purple-200">
                                <strong class="text-purple-100">Analyse de corrélation directe :</strong> Ce nuage de points montre la relation entre deux indicateurs sans la dimension temporelle. 
                                Chaque point représente une mesure simultanée. Une dispersion linéaire suggère une forte corrélation, tandis qu'une dispersion alérale 
                                indique une faible relation. Le coefficient de corrélation (r) quantifie cette relation : proche de 1 ou -1 = forte, proche de 0 = faible.
                            </p>
                        </div>
                        
                        <div class="h-64 relative">
                            <canvas id="comparisonScatterChart"></canvas>
                            <div id="comparisonScatterEmpty" class="absolute inset-0 flex items-center justify-center">
                                <p class="text-white/30">En attente de données...</p>
                            </div>
                        </div>
                        <div class="mt-3 p-3 rounded-lg bg-white/5 border border-white/10">
                            <p class="text-xs text-white/60" id="comparisonScatterDescription">
                                Visualisez la relation directe entre deux indicateurs avec leur coefficient de corrélation.
                            </p>
                        </div>
                    </div>

                    <!-- Tableau de corrélation -->
                    <div class="p-6 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 slide-up slide-up-5 lg:col-span-2">
                        <h3 class="text-lg font-medium mb-4">Matrice de corrélation</h3>
                        
                        <!-- Paragraphe explicatif -->
                        <div class="mb-4 p-3 rounded-lg bg-green-500/10 border border-green-500/20">
                            <p class="text-sm text-green-200">
                                <strong class="text-green-100">Vue d'ensemble des relations :</strong> Cette matrice présente tous les coefficients de corrélation entre les indicateurs. 
                                Chaque valeur (entre -1 et 1) indique la force et la direction de la relation. Les valeurs proches de 1 (rouge) montrent une forte corrélation positive, 
                                proches de -1 (rouge) une forte corrélation négative, et proches de 0 (vert) une faible corrélation. C'est l'outil idéal pour identifier rapidement 
                                les interactions les plus significatives dans l'écosystème.
                            </p>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-white">
                                <thead>
                                    <tr class="border-b border-white/10">
                                        <th class="px-4 py-2 text-left">Indicateur</th>
                                        <th class="px-4 py-2 text-center">Oxygène</th>
                                        <th class="px-4 py-2 text-center">Température</th>
                                        <th class="px-4 py-2 text-center">Salinité</th>
                                        <th class="px-4 py-2 text-center">pH</th>
                                    </tr>
                                </thead>
                                <tbody id="correlationMatrix" class="text-white/70">
                                    <tr>
                                        <td class="px-4 py-2 font-medium">Oxygène</td>
                                        <td class="px-4 py-2 text-center">1.00</td>
                                        <td class="px-4 py-2 text-center">-</td>
                                        <td class="px-4 py-2 text-center">-</td>
                                        <td class="px-4 py-2 text-center">-</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 font-medium">Température</td>
                                        <td class="px-4 py-2 text-center">-</td>
                                        <td class="px-4 py-2 text-center">1.00</td>
                                        <td class="px-4 py-2 text-center">-</td>
                                        <td class="px-4 py-2 text-center">-</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 font-medium">Salinité</td>
                                        <td class="px-4 py-2 text-center">-</td>
                                        <td class="px-4 py-2 text-center">-</td>
                                        <td class="px-4 py-2 text-center">1.00</td>
                                        <td class="px-4 py-2 text-center">-</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 font-medium">pH</td>
                                        <td class="px-4 py-2 text-center">-</td>
                                        <td class="px-4 py-2 text-center">-</td>
                                        <td class="px-4 py-2 text-center">-</td>
                                        <td class="px-4 py-2 text-center">1.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 p-3 rounded-lg bg-white/5 border border-white/10">
                            <p class="text-xs text-white/60">
                                <strong>Légende:</strong> Corrélation forte (|r| > 0.7) = Modérée (0.3 < |r| ≤ 0.7) = Faible (|r| ≤ 0.3) = Bon
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Section d'interprétation et d'action -->
            <div class="mt-12 p-8 rounded-2xl backdrop-blur-xl bg-gradient-to-r from-cyan-500/10 to-blue-500/10 border border-cyan-500/20">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-cyan-500 to-blue-500 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-white mb-4">Comment interpréter ces données ?</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="text-lg font-medium text-cyan-300 mb-3"> Signes de désoxygénation critique</h4>
                                <ul class="space-y-2 text-white/70 text-sm">
                                    <li class="flex items-start gap-2">
                                        <span class="text-red-400">•</span>
                                        <span>Zones rouges sur la carte = Niveau d'oxygène critique (&lt; 4 mg/L)</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="text-amber-400">•</span>
                                        <span>Tendance à la baisse sur le graphique = Dégradation progressive</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="text-orange-400">•</span>
                                        <span>Fortes concentrations de points orange = Zones à surveiller</span>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="text-lg font-medium text-green-300 mb-3"> Signes d'écosystème sain</h4>
                                <ul class="space-y-2 text-white/70 text-sm">
                                    <li class="flex items-start gap-2">
                                        <span class="text-green-400">•</span>
                                        <span>Zones vertes/bleues = Niveau d'oxygène optimal (&gt; 6 mg/L)</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="text-cyan-400">•</span>
                                        <span>Tendance stable ou à la hausse = Résilience de l'écosystème</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="text-blue-400">•</span>
                                        <span>Distribution homogène = Bonne circulation des eaux</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="mt-6 p-4 rounded-lg bg-white/5 border border-white/10">
                            <p class="text-sm text-white/60">
                                <strong class="text-cyan-300"> Objectif :</strong> Identifier les zones critiques pour orienter les efforts de préservation et prendre des mesures ciblées contre la désoxygénation.
                            </p>
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
    let correlationChart = null;
    let comparisonScatterChart = null;
    let weatherBarChart = null;
    let weatherPieChart = null;
    let map = null;
    let markers = [];
    let heatmapLayer = null;
    let currentView = 'table';
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
                document.getElementById('mapDisplayOptions').classList.remove('hidden');
                document.getElementById('mapDisplayOptions').classList.add('flex');
                initializeMap();
                // Mettre à jour la carte si des données sont disponibles
                if (window.currentData && window.currentMetric) {
                    document.getElementById('mapEmpty').classList.add('hidden');
                    addMarkers(window.currentData.evolution || [], window.currentMetric);
                }
                break;
            case 'chart':
                document.getElementById('chartView').classList.remove('hidden');
                document.getElementById('btnChartView').className = 'px-4 py-2 rounded-lg text-sm bg-white/10 border border-white/20 hover:bg-white/10 hover:border-white/20 transition-all duration-300';
                document.getElementById('mapDisplayOptions').classList.add('hidden');
                document.getElementById('mapDisplayOptions').classList.remove('flex');
                break;
            case 'table':
                document.getElementById('tableView').classList.remove('hidden');
                document.getElementById('btnTableView').className = 'px-4 py-2 rounded-lg text-sm bg-white/10 border border-white/20 hover:bg-white/10 hover:border-white/20 transition-all duration-300';
                document.getElementById('mapDisplayOptions').classList.add('hidden');
                document.getElementById('mapDisplayOptions').classList.remove('flex');
                // Mettre à jour le tableau si des données sont disponibles
                if (window.currentData) {
                    document.getElementById('tableEmpty').classList.add('hidden');
                    populateTable(window.currentData.evolution || []);
                }
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
        // Clear existing markers and heatmap
        markers.forEach(marker => map.removeLayer(marker));
        markers = [];
        if (heatmapLayer) {
            map.removeLayer(heatmapLayer);
            heatmapLayer = null;
        }
        
        // Get display type
        const displayType = document.getElementById('mapDisplayType')?.value || 'markers';
        
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
            
            if (displayType === 'heatmap') {
                // Create heatmap data
                const heatData = [];
                data.forEach(item => {
                    if (item.latitude && item.longitude && item.value !== null) {
                        const quality = getQualityLevel(metric, parseFloat(item.value));
                        // Use intensity based on quality: good = 1.0, moderate = 0.6, poor = 0.3
                        let intensity = 0.3;
                        if (quality) {
                            if (quality.level === 'good') intensity = 1.0;
                            else if (quality.level === 'moderate') intensity = 0.6;
                            else intensity = 0.3;
                        }
                        
                        heatData.push([item.latitude, item.longitude, intensity]);
                        bounds.push([item.latitude, item.longitude]);
                    }
                });
                
                // Create and add heatmap layer
                if (heatData.length > 0) {
                    heatmapLayer = L.heatLayer(heatData, {
                        radius: 25,
                        blur: 15,
                        maxZoom: 17,
                        max: 1.0,
                        gradient: {
                            0.0: '#3b82f6',    // Blue for low intensity
                            0.3: '#f59e0b',    // Amber for moderate
                            0.6: '#ef4444',    // Red for high intensity
                            1.0: '#dc2626'     // Dark red for very high
                        }
                    }).addTo(map);
                }
            } else {
                // Display as markers (original behavior)
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
            }
            
            // Fit map to show all data points
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
                const value = parseFloat(item.value);
                const quality = getQualityLevel(window.currentMetric || 'dissoxygen', value);
                
                let statusIcon, statusText, statusColor, statusBg;
                
                if (quality.level === 'good') {
                    statusIcon = '✓';
                    statusText = 'SAIN';
                    statusColor = 'text-green-400';
                    statusBg = 'bg-green-500/20';
                } else if (quality.level === 'moderate') {
                    statusIcon = '!';
                    statusText = 'ATTENTION';
                    statusColor = 'text-yellow-400';
                    statusBg = 'bg-yellow-500/20';
                } else {
                    statusIcon = '✗';
                    statusText = 'DANGER';
                    statusColor = 'text-red-400';
                    statusBg = 'bg-red-500/20';
                }
                
                const row = document.createElement('tr');
                row.className = 'border-b border-white/5 hover:bg-white/5 transition-colors';
                row.innerHTML = `
                    <td class="px-4 py-2">${new Date(item.date).toLocaleDateString('fr-FR')} ${new Date(item.date).toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'})}</td>
                    <td class="px-4 py-2">${item.latitude ? item.latitude.toFixed(4) : 'N/A'}</td>
                    <td class="px-4 py-2">${item.longitude ? item.longitude.toFixed(4) : 'N/A'}</td>
                    <td class="px-4 py-2 font-medium">${value.toFixed(2)} ${(window.currentMetric && metricConfig[window.currentMetric] ? metricConfig[window.currentMetric].unit : '')}</td>
                    <td class="px-4 py-2">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full ${statusBg} ${statusColor} border border-currentColor/30">
                            <span class="text-sm font-bold">${statusIcon}</span>
                            <span class="text-xs font-medium">${statusText}</span>
                        </div>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }
    }
    
    // Fonction d'exportation des données
    function exportData(format) {
        // Récupérer les paramètres actuels
        const metric = document.getElementById('metric').value;
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        
        // Construire l'URL d'exportation
        const params = new URLSearchParams();
        params.append('format', format);
        params.append('metric', metric);
        
        // Ajouter les paramètres de période (comme dans launchAnalysis)
        if (startDate) {
            params.append('start_date', startDate);
        }
        if (endDate) {
            params.append('end_date', endDate);
        }
        
        // Si aucune date n'est spécifiée, utiliser une période par défaut de 1 an
        if (!startDate && !endDate) {
            params.append('periode', '1');
        }
        
        // Afficher une notification
        showNotification(`Préparation de l'exportation ${format.toUpperCase()}...`, 'info');
        
        // Créer et télécharger le fichier
        const exportUrl = `/web/api/export.php?${params.toString()}`;
        const link = document.createElement('a');
        link.href = exportUrl;
        link.style.display = 'none';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        // Notification de succès
        setTimeout(() => {
            showNotification(`Exportation ${format.toUpperCase()} terminée avec succès!`, 'success');
        }, 1000);
    }
    
    // Mettre à jour l'affichage de la métrique actuelle
    function updateCurrentMetricDisplay() {
        const metricSelect = document.getElementById('metric');
        const currentMetricSpan = document.getElementById('currentMetric');
        
        const metricNames = {
            'dissoxygen': 'Oxygène dissous',
            'temperature': 'Température',
            'salinity': 'Salinité',
            'ph': 'pH'
        };
        
        currentMetricSpan.textContent = metricNames[metricSelect.value] || metricSelect.value;
    }
    
    // Event listeners for view buttons
    document.getElementById('btnMapView').addEventListener('click', () => switchView('map'));
    document.getElementById('btnChartView').addEventListener('click', () => switchView('chart'));
    document.getElementById('btnTableView').addEventListener('click', () => switchView('table'));

    // Event listener for map display type
    document.getElementById('mapDisplayType')?.addEventListener('change', () => {
        if (window.currentData && window.currentMetric && currentView === 'map') {
            addMarkers(window.currentData.evolution || [], window.currentMetric);
        }
    });

    // Event listeners for comparison charts
    document.getElementById('metric1')?.addEventListener('change', () => {
        updateMetric2Options();
        updateComparisonExplanation();
        if (window.currentData) {
            updateComparisonCharts();
        }
    });

    document.getElementById('metric2')?.addEventListener('change', () => {
        updateMetric1Options();
        updateComparisonExplanation();
        if (window.currentData) {
            updateComparisonCharts();
        }
    });

    document.getElementById('trendType')?.addEventListener('change', () => {
        if (window.currentData) {
            updateComparisonScatterChart();
        }
    });

    // Event listeners for dynamic filters
    document.getElementById('metric').addEventListener('change', () => {
        updateCurrentMetricDisplay();
        // Plus de lancement automatique - uniquement avec le bouton
    });

    // Event listeners for chart filters
    document.getElementById('pieChartSort')?.addEventListener('change', () => {
        if (window.currentData) {
            updateQualityPieChart(window.currentData, window.currentMetric);
        }
    });

    document.getElementById('barChartSort')?.addEventListener('change', () => {
        if (window.currentData) {
            updateMonthlyBarChart(window.currentData, window.currentMetric);
        }
    });

    // Manual analysis button
    document.getElementById('btnAnalyse').addEventListener('click', () => {
        launchAnalysis();
        showNotification('Analyse lancée manuellement', 'success');
    });

    document.addEventListener('DOMContentLoaded', () => {
        loadDateRange();
        updateCurrentMetricDisplay();
        
        // Initialiser les sélecteurs de comparaison
        updateMetric2Options();
        updateComparisonExplanation();
        
        switchView('table'); // Afficher le tableau par défaut
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
    }

    // Fonction pour cacher tous les états de chargement
    function hideAllLoadingStates() {
        document.getElementById('chartLoading').classList.add('hidden');
    }

    // Fonction pour mettre à jour les options du deuxième sélecteur
    function updateMetric2Options() {
        const metric1 = document.getElementById('metric1').value;
        const metric2Select = document.getElementById('metric2');
        const currentValue = metric2Select.value;
        
        // Toutes les options possibles
        const allMetrics = [
            { value: 'dissoxygen', label: 'Oxygène dissous' },
            { value: 'water_temp', label: 'Température' },
            { value: 'salinity', label: 'Salinité' },
            { value: 'ph', label: 'pH' }
        ];
        
        // Filtrer pour exclure la valeur sélectionnée dans metric1
        const availableMetrics = allMetrics.filter(metric => metric.value !== metric1);
        
        // Mettre à jour les options
        metric2Select.innerHTML = availableMetrics.map(metric => 
            `<option value="${metric.value}" ${metric.value === currentValue ? 'selected' : ''}>${metric.label}</option>`
        ).join('');
    }

    // Fonction pour mettre à jour les options du premier sélecteur
    function updateMetric1Options() {
        const metric2 = document.getElementById('metric2').value;
        const metric1Select = document.getElementById('metric1');
        const currentValue = metric1Select.value;
        
        // Toutes les options possibles
        const allMetrics = [
            { value: 'dissoxygen', label: 'Oxygène dissous' },
            { value: 'water_temp', label: 'Température' },
            { value: 'salinity', label: 'Salinité' },
            { value: 'ph', label: 'pH' }
        ];
        
        // Filtrer pour exclure la valeur sélectionnée dans metric2
        const availableMetrics = allMetrics.filter(metric => metric.value !== metric2);
        
        // Mettre à jour les options
        metric1Select.innerHTML = availableMetrics.map(metric => 
            `<option value="${metric.value}" ${metric.value === currentValue ? 'selected' : ''}>${metric.label}</option>`
        ).join('');
    }

    // Fonction pour mettre à jour l'explication de la comparaison
    function updateComparisonExplanation() {
        const metric1 = document.getElementById('metric1').value;
        const metric2 = document.getElementById('metric2').value;
        const explanationDiv = document.getElementById('comparisonExplanation');
        
        if (!explanationDiv) return;
        
        const metricNames = {
            'dissoxygen': 'Oxygène dissous',
            'water_temp': 'Température',
            'salinity': 'Salinité',
            'ph': 'pH'
        };
        
        const explanations = {
            'dissoxygen-water_temp': 'La température de l\'eau influence directement la quantité d\'oxygène dissous. Quand l\'eau se réchauffe, elle retient moins d\'oxygène, ce qui peut créer des zones hypoxiques dangereuses pour la vie marine.',
            'dissoxygen-salinity': 'La salinité affecte la capacité de l\'eau à contenir de l\'oxygène. Les eaux plus salines ont généralement moins d\'oxygène dissous, ce qui impacte directement les écosystèmes marins.',
            'dissoxygen-ph': 'Le pH et l\'oxygène sont liés : quand le pH devient trop acide ou basique, cela peut indiquer une dégradation de la qualité de l\'eau et une baisse d\'oxygène disponible.',
            'water_temp-dissoxygen': 'L\'analyse inverse montre comment les variations d\'oxygène peuvent influencer la température locale. Des niveaux bas d\'oxygène peuvent indiquer des phénomènes de stratification thermique.',
            'water_temp-salinity': 'La température et la salinité définissent la densité de l\'eau. Leurs variations créent des courants et des mouvements qui influencent la distribution des nutriments et de l\'oxygène.',
            'water_temp-ph': 'La température affecte directement le pH de l\'eau. Plus l\'eau est chaude, plus son pH peut devenir instable, ce qui impacte la chimie globale de l\'écosystème.',
            'salinity-dissoxygen': 'L\'analyse inverse montre comment l\'oxygène influence la salinité. Des zones bien oxygénées favorisent généralement une meilleure stabilité de la salinité.',
            'salinity-water_temp': 'La salinité influence la capacité de l\'eau à absorber la chaleur. Les eaux plus salines peuvent stocker différemment l\'énergie thermique, créant des micro-climats marins.',
            'salinity-ph': 'La salinité et le pH sont chimiquement liés. Les variations de salinité peuvent provoquer des changements de pH qui affectent la survie des espèces marines.',
            'ph-dissoxygen': 'L\'analyse inverse montre comment l\'oxygène influence le pH. Un bon niveau d\'oxygène favorise généralement un pH plus stable et sain pour l\'écosystème.',
            'ph-water_temp': 'Le pH affecte la capacité de l\'eau à absorber la chaleur. Des variations de pH peuvent indiquer des changements dans les propriétés thermiques de l\'eau.',
            'ph-salinity': 'Le pH influence la capacité de l\'eau à maintenir sa salinité. Des pH extrêmes peuvent provoquer des précipitations chimiques qui modifient la composition saline.'
        };
        
        const key = `${metric1}-${metric2}`;
        const explanation = explanations[key] || `Analyse comparative entre ${metricNames[metric1].toLowerCase()} et ${metricNames[metric2].toLowerCase()} pour identifier les corrélations et tendances dans l\'écosystème marin.`;
        
        explanationDiv.innerHTML = `
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h4 class="text-lg font-medium text-white mb-2">Analyse : ${metricNames[metric1]} vs ${metricNames[metric2]}</h4>
                    <p class="text-white/70 text-sm leading-relaxed">${explanation}</p>
                </div>
            </div>
        `;
    }

    // Fonction pour mettre à jour tout le dashboard
    function updateDashboard(data, metric) {
        // Update stats cards
        updateStatsCards(data);
        
        // Update main chart
        updateMainChart(data, metric);
        
        // Update pie chart
        updateQualityPieChart(data, metric);
        
        // Update monthly bar chart
        updateMonthlyBarChart(data, metric);
        
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

    // Fonctions pour les graphiques de comparaison
    function updateComparisonCharts() {
        updateCorrelationChart();
        updateComparisonScatterChart();
        updateCorrelationMatrix();
    }

    function updateCorrelationChart() {
        const metric1 = document.getElementById('metric1').value;
        const metric2 = document.getElementById('metric2').value;
        
        // Récupérer la période globale depuis les filtres principaux
        const globalPeriod = document.getElementById('period')?.value || 'all';
        
        if (!window.currentData || !window.currentData.evolution) return;
        
        const ctx = document.getElementById('correlationChart').getContext('2d');
        
        if (correlationChart) {
            correlationChart.destroy();
        }
        
        // Filtrer les données selon la période globale
        const filteredData = filterDataByPeriod(window.currentData.evolution, globalPeriod);
        
        // Déterminer le format des labels en fonction de la période
        let labelFormat;
        let labelTitle;
        switch(globalPeriod) {
            case '1year':
                labelFormat = { month: 'short', day: 'numeric' };
                labelTitle = 'Mensuel (dernière année)';
                break;
            case '3years':
                labelFormat = { month: 'short', year: '2-digit' };
                labelTitle = 'Mensuel (3 dernières années)';
                break;
            default: // all
                labelFormat = { month: 'short', year: '2-digit' };
                labelTitle = 'Mensuel (toutes les données)';
        }
        
        // Préparer les données pour les deux métriques
        const labels = [];
        const data1 = [];
        const data2 = [];
        
        filteredData.forEach(item => {
            if (item.value !== null) {
                labels.push(new Date(item.date).toLocaleDateString('fr-FR', labelFormat));
                data1.push(parseFloat(item.value));
                // Simuler la deuxième métrique (en réalité, il faudrait la récupérer depuis l'API)
                data2.push(simulateSecondMetric(metric2, parseFloat(item.value)));
            }
        });
        
        document.getElementById('correlationEmpty').classList.add('hidden');
        
        const config1 = metricConfig[metric1] || metricConfig['dissoxygen'];
        const config2 = metricConfig[metric2] || metricConfig['dissoxygen'];
        
        correlationChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: config1.label,
                        data: data1,
                        borderColor: config1.color,
                        backgroundColor: config1.color.replace('rgb', 'rgba').replace(')', ', 0.1)'),
                        borderWidth: 2,
                        yAxisID: 'y',
                        tension: 0.4
                    },
                    {
                        label: config2.label,
                        data: data2,
                        borderColor: config2.color,
                        backgroundColor: config2.color.replace('rgb', 'rgba').replace(')', ', 0.1)'),
                        borderWidth: 2,
                        yAxisID: 'y1',
                        tension: 0.4
                    }
                ]
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
                        display: true,
                        labels: {
                            color: 'rgba(255, 255, 255, 0.8)',
                            padding: 15
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
                },
                scales: {
                    x: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.6)',
                            font: { size: 11 },
                            maxRotation: 45,
                            minRotation: 0
                        },
                        title: {
                            display: true,
                            text: labelTitle,
                            color: 'rgba(255, 255, 255, 0.8)',
                            font: {
                                size: 13,
                                weight: 'bold'
                            },
                            padding: {
                                top: 10,
                                bottom: 10
                            }
                        }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: config1.label,
                            color: config1.color
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.5)',
                            font: { size: 10 }
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: config2.label,
                            color: config2.color
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.5)',
                            font: { size: 10 }
                        }
                    }
                }
            }
        });
        
        // Mettre à jour la description
        const correlation = calculateCorrelation(data1, data2);
        document.getElementById('correlationDescription').textContent = 
            `Corrélation: ${correlation.toFixed(3)} (${getCorrelationStrength(correlation)})`;
    }

    function updateComparisonScatterChart() {
        const metric1 = document.getElementById('metric1').value;
        const metric2 = document.getElementById('metric2').value;
        const trendType = document.getElementById('trendType').value;
        
        if (!window.currentData || !window.currentData.evolution) return;
        
        const ctx = document.getElementById('comparisonScatterChart').getContext('2d');
        
        if (comparisonScatterChart) {
            comparisonScatterChart.destroy();
        }
        
        const config1 = metricConfig[metric1] || metricConfig['dissoxygen'];
        const config2 = metricConfig[metric2] || metricConfig['dissoxygen'];
        
        // Préparer les données
        const scatterData = window.currentData.evolution
            .filter(item => item.value !== null)
            .map(item => ({
                x: parseFloat(item.value),
                y: simulateSecondMetric(metric2, parseFloat(item.value))
            }));
        
        document.getElementById('comparisonScatterEmpty').classList.add('hidden');
        
        const datasets = [{
            label: `${config1.label} vs ${config2.label}`,
            data: scatterData,
            backgroundColor: 'rgba(167, 139, 250, 0.4)',
            borderColor: 'rgba(167, 139, 250, 0.8)',
            borderWidth: 1,
            pointRadius: 3,
            pointHoverRadius: 6
        }];
        
        // Ajouter la ligne de tendance si demandée
        if (trendType !== 'none') {
            const trendLine = calculateTrendLine(scatterData, trendType);
            datasets.push({
                label: 'Tendance',
                data: trendLine,
                borderColor: 'rgba(34, 211, 238, 0.8)',
                borderWidth: 2,
                borderDash: [5, 5],
                pointRadius: 0,
                fill: false,
                tension: 0.4
            });
        }
        
        comparisonScatterChart = new Chart(ctx, {
            type: 'scatter',
            data: { datasets },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: 'rgba(255, 255, 255, 0.8)'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.95)',
                        callbacks: {
                            label: function(context) {
                                return [
                                    `${config1.label}: ${context.parsed.x.toFixed(2)} ${config1.unit}`,
                                    `${config2.label}: ${context.parsed.y.toFixed(2)} ${config2.unit}`
                                ];
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: config1.label,
                            color: 'rgba(255, 255, 255, 0.8)'
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)'
                        },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.5)'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: config2.label,
                            color: 'rgba(255, 255, 255, 0.8)'
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)'
                        },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.5)'
                        }
                    }
                }
            }
        });
        
        // Mettre à jour la description avec le coefficient de corrélation
        const correlation = calculateCorrelation(
            scatterData.map(d => d.x),
            scatterData.map(d => d.y)
        );
        document.getElementById('comparisonScatterDescription').textContent = 
            `Coefficient de corrélation: ${correlation.toFixed(3)} (${getCorrelationStrength(correlation)})`;
    }

    function updateCorrelationMatrix() {
        if (!window.currentData || !window.currentData.evolution) return;
        
        const metrics = ['dissoxygen', 'water_temp', 'salinity', 'ph'];
        const matrix = {};
        
        // Calculer les corrélations entre toutes les paires
        metrics.forEach(metric1 => {
            matrix[metric1] = {};
            metrics.forEach(metric2 => {
                if (metric1 === metric2) {
                    matrix[metric1][metric2] = 1.00;
                } else {
                    const data1 = window.currentData.evolution
                        .filter(item => item.value !== null)
                        .map(item => parseFloat(item.value));
                    const data2 = data1.map(val => simulateSecondMetric(metric2, val));
                    matrix[metric1][metric2] = calculateCorrelation(data1, data2);
                }
            });
        });
        
        // Mettre à jour le tableau HTML
        const tbody = document.getElementById('correlationMatrix');
        const metricNames = {
            'dissoxygen': 'Oxygène',
            'water_temp': 'Température',
            'salinity': 'Salinité',
            'ph': 'pH'
        };
        
        let html = '';
        metrics.forEach(metric1 => {
            html += `<tr>`;
            html += `<td class="px-4 py-2 font-medium">${metricNames[metric1]}</td>`;
            metrics.forEach(metric2 => {
                const value = matrix[metric1][metric2];
                const color = getCorrelationColor(value);
                const display = metric1 === metric2 ? '1.00' : value.toFixed(2);
                html += `<td class="px-4 py-2 text-center"><span style="color: ${color}">${display}</span></td>`;
            });
            html += `</tr>`;
        });
        
        tbody.innerHTML = html;
    }

    // Fonctions utilitaires
    function filterDataByPeriod(data, period) {
        const now = new Date();
        let cutoffDate;
        
        switch(period) {
            case '1year':
                cutoffDate = new Date(now.getTime() - 365 * 24 * 60 * 60 * 1000);
                break;
            case '3years':
                cutoffDate = new Date(now.getTime() - 3 * 365 * 24 * 60 * 60 * 1000);
                break;
            case 'all':
            default:
                return data;
        }
        
        return data.filter(item => new Date(item.date) >= cutoffDate);
    }

    function simulateSecondMetric(metric, baseValue) {
        // Simuler une deuxième métrique basée sur la première
        switch(metric) {
            case 'water_temp':
                return 15 + Math.random() * 20 + (baseValue > 6 ? -2 : 2);
            case 'salinity':
                return 33 + Math.random() * 4 + (baseValue < 4 ? -1 : 0.5);
            case 'ph':
                return 7.5 + Math.random() * 1 + (baseValue > 6 ? 0.2 : -0.3);
            default:
                return baseValue + (Math.random() - 0.5) * 2;
        }
    }

    function calculateCorrelation(x, y) {
        const n = x.length;
        if (n === 0) return 0;
        
        const sumX = x.reduce((a, b) => a + b, 0);
        const sumY = y.reduce((a, b) => a + b, 0);
        const sumXY = x.reduce((sum, xi, i) => sum + xi * y[i], 0);
        const sumX2 = x.reduce((sum, xi) => sum + xi * xi, 0);
        const sumY2 = y.reduce((sum, yi) => sum + yi * yi, 0);
        
        const numerator = n * sumXY - sumX * sumY;
        const denominator = Math.sqrt((n * sumX2 - sumX * sumX) * (n * sumY2 - sumY * sumY));
        
        return denominator === 0 ? 0 : numerator / denominator;
    }

    function getCorrelationStrength(r) {
        const abs = Math.abs(r);
        if (abs > 0.7) return 'Forte corrélation';
        if (abs > 0.3) return 'Corrélation modérée';
        return 'Faible corrélation';
    }

    function getCorrelationColor(r) {
        const abs = Math.abs(r);
        if (abs > 0.7) return '#ef4444';
        if (abs > 0.3) return '#f59e0b';
        return '#10b981';
    }

    function calculateTrendLine(data, type) {
        if (data.length < 2) return [];
        
        const xValues = data.map(d => d.x);
        const yValues = data.map(d => d.y);
        
        if (type === 'linear') {
            // Régression linéaire simple
            const n = data.length;
            const sumX = xValues.reduce((a, b) => a + b, 0);
            const sumY = yValues.reduce((a, b) => a + b, 0);
            const sumXY = xValues.reduce((sum, x, i) => sum + x * yValues[i], 0);
            const sumX2 = xValues.reduce((sum, x) => sum + x * x, 0);
            
            const slope = (n * sumXY - sumX * sumY) / (n * sumX2 - sumX * sumX);
            const intercept = (sumY - slope * sumX) / n;
            
            const xMin = Math.min(...xValues);
            const xMax = Math.max(...xValues);
            
            return [
                { x: xMin, y: slope * xMin + intercept },
                { x: xMax, y: slope * xMax + intercept }
            ];
        }
        
        return [];
    }

    // ==========================
    // FONCTIONS D'ANALYSE MÉTÉO (INDÉPENDANTES)
    // ==========================
    
    function loadWeatherAnalysis() {
        const metric = document.getElementById('metric').value;
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        
        // Afficher le chargement
        document.getElementById('weatherLoading').classList.remove('hidden');
        document.getElementById('weatherEmpty').classList.add('hidden');
        document.getElementById('weatherResults').classList.add('hidden');
        
        // Construire l'URL de l'API
        const params = new URLSearchParams({ metric });
        if (startDate) params.append('start_date', startDate);
        if (endDate) params.append('end_date', endDate);
        
        const url = `/web/api/weather-analysis.php?${params}`;
        console.log('Calling weather API URL:', url);
        
        fetch(url)
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Received data:', data);
                
                if (data.error) {
                    throw new Error(data.error);
                }
                
                // Utiliser la fonction displayWeatherResults pour les données complètes
                displayWeatherResults(data);
            })
            .catch(error => {
                console.error('Erreur lors de l\'analyse météo:', error);
                document.getElementById('weatherLoading').classList.add('hidden');
                document.getElementById('weatherEmpty').classList.remove('hidden');
            });
    }
    
    function displayWeatherResults(data) {
        const weatherData = data.weather_analysis;
        
        if (!weatherData || !weatherData.by_weather_type || weatherData.by_weather_type.length === 0) {
            document.getElementById('weatherLoading').classList.add('hidden');
            document.getElementById('weatherEmpty').classList.remove('hidden');
            return;
        }
        
        // Récupérer la configuration de la métrique actuelle
        const metric = data.metric || 'dissoxygen';
        const metricInfo = metricConfig[metric];
        
        // Mettre à jour les cartes de résumé
        const summary = weatherData.analysis_summary;
        document.getElementById('dominantWeather').textContent = summary.dominant_weather || 'N/A';
        document.getElementById('weatherTypesCount').textContent = summary.total_weather_types || 0;
        
        // Traduire le niveau d'impact
        const impactLabels = {
            'low': 'Faible',
            'medium': 'Modéré', 
            'high': 'Élevé'
        };
        document.getElementById('weatherImpact').textContent = impactLabels[summary.weather_impact_level] || 'Inconnu';
        
        // Créer les graphiques avec les couleurs de la métrique
        createWeatherBarChart(weatherData.by_weather_type, metricInfo);
        createWeatherPieChart(weatherData.distribution, metricInfo);
        
        // Remplir le tableau avec les unités
        populateWeatherTable(weatherData.by_weather_type, metricInfo);
        
        // Afficher les résultats
        document.getElementById('weatherLoading').classList.add('hidden');
        document.getElementById('weatherResults').classList.remove('hidden');
    }
    
    function createWeatherBarChart(weatherData, metricInfo = null) {
        const ctx = document.getElementById('weatherBarChart').getContext('2d');
        
        // Détruire le graphique existant
        if (weatherBarChart) {
            weatherBarChart.destroy();
        }
        
        const labels = weatherData.map(d => d.weather || 'Inconnu');
        const avgValues = weatherData.map(d => parseFloat(d.avg_value || 0));
        const minValues = weatherData.map(d => parseFloat(d.min_value || 0));
        const maxValues = weatherData.map(d => parseFloat(d.max_value || 0));
        
        // Utiliser les couleurs de la métrique ou les couleurs par défaut
        const metricColor = metricInfo ? metricInfo.color : 'rgb(34, 211, 238)';
        
        weatherBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Moyenne',
                        data: avgValues,
                        backgroundColor: metricColor.replace('rgb', 'rgba').replace(')', ', 0.6)'),
                        borderColor: metricColor,
                        borderWidth: 1
                    },
                    {
                        label: 'Minimum',
                        data: minValues,
                        backgroundColor: 'rgba(239, 68, 68, 0.6)',
                        borderColor: 'rgba(239, 68, 68, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Maximum',
                        data: maxValues,
                        backgroundColor: 'rgba(16, 185, 129, 0.6)',
                        borderColor: 'rgba(16, 185, 129, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: 'white'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.dataset.label || '';
                                const value = context.parsed.y || 0;
                                const unit = metricInfo ? metricInfo.unit : '';
                                return `${label}: ${value.toFixed(2)} ${unit}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: 'white',
                            maxRotation: 45,
                            minRotation: 0
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        }
                    },
                    y: {
                        ticks: {
                            color: 'white',
                            callback: function(value) {
                                const unit = metricInfo ? metricInfo.unit : '';
                                return value + ' ' + unit;
                            }
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        }
                    }
                }
            }
        });
    }
    
    function createWeatherPieChart(distribution) {
        const ctx = document.getElementById('weatherPieChart').getContext('2d');
        
        // Détruire le graphique existant
        if (weatherPieChart) {
            weatherPieChart.destroy();
        }
        
        const labels = distribution.map(d => d.weather || 'Inconnu');
        const percentages = distribution.map(d => parseFloat(d.percentage || 0));
        
        // Couleurs différentes pour chaque type de météo
        const colors = [
            'rgba(59, 130, 246, 0.6)',
            'rgba(16, 185, 129, 0.6)', 
            'rgba(251, 146, 60, 0.6)',
            'rgba(239, 68, 68, 0.6)',
            'rgba(147, 51, 234, 0.6)',
            'rgba(34, 211, 238, 0.6)'
        ];
        
        weatherPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: percentages,
                    backgroundColor: colors.slice(0, labels.length),
                    borderColor: colors.slice(0, labels.length).map(c => c.replace('0.6', '1')),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: 'white',
                            boxWidth: 12,
                            padding: 10
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed + '%';
                            }
                        }
                    }
                }
            }
        });
    }
    
    function populateWeatherTable(weatherData, metricInfo = null) {
        const tbody = document.getElementById('weatherTableBody');
        tbody.innerHTML = '';
        
        const unit = metricInfo ? metricInfo.unit : '';
        
        weatherData.forEach(data => {
            const row = document.createElement('tr');
            row.className = 'border-b border-white/5 hover:bg-white/5 transition-colors';
            
            row.innerHTML = `
                <td class="px-4 py-2 font-medium">${data.weather || 'Inconnu'}</td>
                <td class="px-4 py-2">${data.count_measures || 0}</td>
                <td class="px-4 py-2">${parseFloat(data.avg_value || 0).toFixed(2)} ${unit}</td>
                <td class="px-4 py-2">${parseFloat(data.min_value || 0).toFixed(2)} ${unit}</td>
                <td class="px-4 py-2">${parseFloat(data.max_value || 0).toFixed(2)} ${unit}</td>
                <td class="px-4 py-2">${parseFloat(data.std_deviation || 0).toFixed(2)} ${unit}</td>
            `;
            
            tbody.appendChild(row);
        });
    }
    
    // Écouteur d'événement pour le bouton d'analyse météo
    document.addEventListener('DOMContentLoaded', function() {
        const btnWeatherAnalysis = document.getElementById('btnWeatherAnalysis');
        if (btnWeatherAnalysis) {
            btnWeatherAnalysis.addEventListener('click', loadWeatherAnalysis);
        }
        
        // Écouteur pour le changement de métrique principale
        const metricSelect = document.getElementById('metric');
        if (metricSelect) {
            metricSelect.addEventListener('change', function() {
                // Mettre à jour les graphiques météo automatiquement
                loadWeatherAnalysis();
                
                // Mettre à jour l'affichage de la métrique actuelle
                updateMetricDisplay();
            });
        }
        
        // Initialiser l'affichage de la métrique au chargement
        updateMetricDisplay();
    });
    
    // Fonction pour mettre à jour l'affichage de la métrique actuelle
    function updateMetricDisplay() {
        const metric = document.getElementById('metric').value;
        const metricInfo = metricConfig[metric];
        
        // Mettre à jour le titre de la section météo
        const weatherSectionTitle = document.querySelector('#weatherAnalysisContainer h2');
        if (weatherSectionTitle && metricInfo) {
            weatherSectionTitle.innerHTML = `
                Analyse par conditions météo
                <span class="text-sm text-white/60 ml-2">(${metricInfo.label})</span>
            `;
        }
        
        // Mettre à jour les sous-titres des graphiques
        const barChartTitle = document.querySelector('#weatherAnalysisContainer h3');
        if (barChartTitle && metricInfo) {
            barChartTitle.textContent = `${metricInfo.label} - Valeurs moyennes par condition météo`;
        }
    }
    </script>
</body>
</html>
