<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analyse - AquaView</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <!-- Sélection de région -->
                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-2">
                            Région océanique
                        </label>
                        <select
                            id="region"
                            class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/20 text-white focus:outline-none focus:border-cyan-400/50 focus:bg-white/10 transition-all duration-300 cursor-pointer"
                        >
                            <option value="Méditeranée">Méditerranée</option>
                            <option value="Atlantique">Atlantique</option>
                            <option value="Pacifique">Pacifique</option>
                        </select>
                    </div>

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

            <!-- Zone de visualisation -->
            <div class="p-8 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 slide-up slide-up-5">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-medium">Visualisation des données</h2>
                        <p id="chartSubtitle" class="text-white/50 text-sm mt-1">Sélectionnez une métrique et lancez l'analyse</p>
                    </div>
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

                <!-- Placeholder for the graph -->
                <div class="h-96 rounded-xl bg-slate-900/50 border border-white/10 p-4 relative">
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
                            <p class="text-white/30 text-sm mt-2">Cliquez sur "Lancer l'analyse" pour afficher les données</p>
                        </div>
                    </div>
                    
                    <!-- Chart canvas -->
                    <canvas id="evolutionChart" class="w-full h-full"></canvas>
                </div>
                
                <!-- Chart legend -->
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
        </main>
    </div>

    <script>
    let evolutionChart = null;
    let availableDateRange = { min_date: null, max_date: null };
    
    // Metric labels and units
    const metricConfig = {
        'dissoxygen': { label: "Niveau d'oxygène", unit: 'mg/L', color: 'rgb(34, 211, 238)' },
        'water_temp': { label: 'Température', unit: '°C', color: 'rgb(251, 146, 60)' },
        'salinity': { label: 'Salinité', unit: 'PSU', color: 'rgb(96, 165, 250)' },
        'ph': { label: 'pH', unit: '', color: 'rgb(167, 139, 250)' }
    };

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
        
        const region = document.getElementById('region').value;
        const metric = document.getElementById('metric').value;
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;

        let url = `/web/api/analyse.php`
            + `?region=${encodeURIComponent(region)}`
            + `&metric=${encodeURIComponent(metric)}`;
        
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
                
                if (data.evolution && data.evolution.length > 0) {
                    const chartData = processEvolutionData(data.evolution);
                    createChart(chartData, metric);
                } else {
                    // Aucune donnée d'évolution
                    document.getElementById('chartEmpty').classList.remove('hidden');
                    document.getElementById('chartLegend').classList.add('hidden');
                }
                
                // Hide loading state
                document.getElementById('chartLoading').classList.add('hidden');
            })
            .catch(error => {
                console.error('Erreur API:', error);
                document.getElementById('chartLoading').classList.add('hidden');
                document.getElementById('chartEmpty').classList.remove('hidden');
                alert('Erreur lors de l\'analyse');
            });
    });

    document.addEventListener('DOMContentLoaded', loadDateRange);
    </script>
</body>
</html>
