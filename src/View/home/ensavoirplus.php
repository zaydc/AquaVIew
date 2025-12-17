<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>En Savoir Plus - AquaView</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .fade-in { animation: fadeIn 0.7s ease-out forwards; }
        .slide-up { animation: slideUp 0.7s ease-out forwards; opacity: 0; }
        .slide-up-1 { animation-delay: 0.1s; }
        .slide-up-2 { animation-delay: 0.2s; }
        .slide-up-3 { animation-delay: 0.3s; }
        .slide-up-4 { animation-delay: 0.4s; }
        .zoom-in { animation: zoomIn 2s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(2rem); } to { opacity: 1; transform: translateY(0); } }
        @keyframes zoomIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body class="bg-slate-900">
    <?php include __DIR__ . '/../components/navbar.php'; ?>
    
    <div class="relative min-h-screen text-white bg-slate-900 pt-20">
        <!-- IMAGE DE FOND -->
        <div class="absolute inset-0 zoom-in">
            <img
                src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=1920&q=80"
                alt="Océan"
                class="absolute inset-0 w-full h-full object-cover"
            />
        </div>

        <!-- OVERLAY DÉGRADÉ -->
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900/95 via-blue-900/85 to-cyan-800/75"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-slate-900/60"></div>

        <!-- CONTENU PRINCIPAL -->
        <main class="relative z-10 max-w-7xl mx-auto px-6 py-12">
            
            <!-- En-tête de la page -->
            <div class="mb-16 slide-up slide-up-1">
                <h1 class="text-4xl md:text-5xl font-light mb-4">
                    La Désoxygénation
                    <span class="block mt-2 font-medium bg-gradient-to-r from-cyan-300 to-blue-300 bg-clip-text text-transparent">
                        des Océans
                    </span>
                </h1>
                <p class="text-white/60 text-lg max-w-2xl leading-relaxed">
                    Un phénomène invisible qui menace la vie marine et l'équilibre de notre planète. Découvrez les causes, les conséquences et les solutions pour protéger nos océans.
                </p>
            </div>

            <!-- Sections d'information -->
            <div class="space-y-8 mb-16">
                
                <!-- Section 1 -->
                <div class="group bg-slate-800/40 backdrop-blur-xl border border-white/20 rounded-2xl p-8 hover:bg-slate-800/60 hover:border-cyan-400/50 transition-all duration-300 slide-up" style="animation-delay: 0.1s;">
                    <h2 class="text-2xl font-semibold text-white mb-4 group-hover:text-cyan-300 transition-colors">Qu'est-ce que la désoxygénation ?</h2>
                    <p class="text-white/70 leading-relaxed">La désoxygénation des océans est la diminution progressive de la concentration en oxygène dissous dans l'eau de mer. Ce phénomène touche aussi bien les eaux de surface que les profondeurs marines, créant des zones hypoxiques (pauvres en oxygène) et anoxiques (dépourvues d'oxygène).</p>
                </div>

                <!-- Section 2 -->
                <div class="group bg-slate-800/40 backdrop-blur-xl border border-white/20 rounded-2xl p-8 hover:bg-slate-800/60 hover:border-cyan-400/50 transition-all duration-300 slide-up" style="animation-delay: 0.2s;">
                    <h2 class="text-2xl font-semibold text-white mb-4 group-hover:text-cyan-300 transition-colors">Les Causes Principales</h2>
                    <p class="text-white/70 leading-relaxed mb-4">La désoxygénation océanique résulte de plusieurs facteurs interconnectés :</p>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3 text-white/60">
                            <svg class="w-5 h-5 text-cyan-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Réchauffement climatique : L'augmentation de la température réduit la capacité de l'eau à retenir l'oxygène</span>
                        </li>
                        <li class="flex items-start gap-3 text-white/60">
                            <svg class="w-5 h-5 text-cyan-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Eutrophisation : Les nutriments agricoles favorisent la prolifération d'algues qui consomment l'oxygène</span>
                        </li>
                        <li class="flex items-start gap-3 text-white/60">
                            <svg class="w-5 h-5 text-cyan-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Pollution industrielle : Les rejets chimiques perturbent l'équilibre écologique</span>
                        </li>
                        <li class="flex items-start gap-3 text-white/60">
                            <svg class="w-5 h-5 text-cyan-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Stratification océanique : Les couches d'eau se mélangent moins, limitant l'oxygénation des profondeurs</span>
                        </li>
                    </ul>
                </div>

                <!-- Section 3 -->
                <div class="group bg-slate-800/40 backdrop-blur-xl border border-white/20 rounded-2xl p-8 hover:bg-slate-800/60 hover:border-cyan-400/50 transition-all duration-300 slide-up" style="animation-delay: 0.3s;">
                    <h2 class="text-2xl font-semibold text-white mb-4 group-hover:text-cyan-300 transition-colors">Impact sur la Vie Marine</h2>
                    <p class="text-white/70 leading-relaxed mb-4">Les conséquences de la désoxygénation sont dramatiques pour les écosystèmes marins :</p>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3 text-white/60">
                            <svg class="w-5 h-5 text-cyan-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Mortalité massive de poissons et d'organismes marins</span>
                        </li>
                        <li class="flex items-start gap-3 text-white/60">
                            <svg class="w-5 h-5 text-cyan-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Migration forcée des espèces vers des eaux plus riches en oxygène</span>
                        </li>
                        <li class="flex items-start gap-3 text-white/60">
                            <svg class="w-5 h-5 text-cyan-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Perturbation des chaînes alimentaires marines</span>
                        </li>
                        <li class="flex items-start gap-3 text-white/60">
                            <svg class="w-5 h-5 text-cyan-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Réduction de la biodiversité dans les zones affectées</span>
                        </li>
                        <li class="flex items-start gap-3 text-white/60">
                            <svg class="w-5 h-5 text-cyan-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Impacts sur l'industrie de la pêche et les économies locales</span>
                        </li>
                    </ul>
                </div>

                <!-- Section 4 -->
                <div class="group bg-slate-800/40 backdrop-blur-xl border border-white/20 rounded-2xl p-8 hover:bg-slate-800/60 hover:border-cyan-400/50 transition-all duration-300 slide-up" style="animation-delay: 0.4s;">
                    <h2 class="text-2xl font-semibold text-white mb-4 group-hover:text-cyan-300 transition-colors">Les Zones les Plus Touchées</h2>
                    <p class="text-white/70 leading-relaxed">Certaines régions océaniques sont particulièrement vulnérables à la désoxygénation. Les zones mortes (zones hypoxiques sévères) se sont multipliées au cours des dernières décennies, notamment dans le Golfe du Mexique, la Mer Baltique, et certaines zones côtières d'Asie et d'Amérique du Sud.</p>
                </div>

                <!-- Section 5 -->
                <div class="group bg-slate-800/40 backdrop-blur-xl border border-white/20 rounded-2xl p-8 hover:bg-slate-800/60 hover:border-cyan-400/50 transition-all duration-300 slide-up" style="animation-delay: 0.5s;">
                    <h2 class="text-2xl font-semibold text-white mb-4 group-hover:text-cyan-300 transition-colors">Pourquoi Surveiller ?</h2>
                    <p class="text-white/70 leading-relaxed">La surveillance continue des niveaux d'oxygène océanique est essentielle pour comprendre l'évolution du phénomène et anticiper ses impacts futurs. Les données en temps réel permettent aux scientifiques, décideurs politiques et communautés côtières de prendre des mesures préventives et correctives.</p>
                </div>

                <!-- Section 6 -->
                <div class="group bg-slate-800/40 backdrop-blur-xl border border-white/20 rounded-2xl p-8 hover:bg-slate-800/60 hover:border-cyan-400/50 transition-all duration-300 slide-up" style="animation-delay: 0.6s;">
                    <h2 class="text-2xl font-semibold text-white mb-4 group-hover:text-cyan-300 transition-colors">Solutions et Actions</h2>
                    <p class="text-white/70 leading-relaxed mb-4">Plusieurs approches peuvent contribuer à atténuer la désoxygénation :</p>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3 text-white/60">
                            <svg class="w-5 h-5 text-cyan-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Réduction des émissions de gaz à effet de serre</span>
                        </li>
                        <li class="flex items-start gap-3 text-white/60">
                            <svg class="w-5 h-5 text-cyan-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Limitation des rejets de nutriments agricoles</span>
                        </li>
                        <li class="flex items-start gap-3 text-white/60">
                            <svg class="w-5 h-5 text-cyan-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Protection et restauration des écosystèmes côtiers</span>
                        </li>
                        <li class="flex items-start gap-3 text-white/60">
                            <svg class="w-5 h-5 text-cyan-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Création de zones marines protégées</span>
                        </li>
                        <li class="flex items-start gap-3 text-white/60">
                            <svg class="w-5 h-5 text-cyan-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Développement de technologies de surveillance avancées</span>
                        </li>
                        <li class="flex items-start gap-3 text-white/60">
                            <svg class="w-5 h-5 text-cyan-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Sensibilisation et éducation du public</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Section Statistiques -->
            <div class="mb-16 slide-up slide-up-3">
                <h2 class="text-3xl font-light mb-4">
                    Chiffres Clés
                    <span class="block font-medium bg-gradient-to-r from-cyan-300 to-blue-300 bg-clip-text text-transparent">
                        alarmants
                    </span>
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-gradient-to-br from-slate-800/40 to-slate-900/40 backdrop-blur-xl border border-white/20 rounded-2xl p-8 text-center hover:scale-105 hover:border-cyan-400/50 transition-all duration-300">
                        <div class="text-5xl font-bold bg-gradient-to-r from-cyan-300 to-blue-300 bg-clip-text text-transparent mb-3">2%</div>
                        <div class="text-white/70">de l'oxygène océanique perdu depuis 1960</div>
                    </div>
                    <div class="bg-gradient-to-br from-slate-800/40 to-slate-900/40 backdrop-blur-xl border border-white/20 rounded-2xl p-8 text-center hover:scale-105 hover:border-cyan-400/50 transition-all duration-300">
                        <div class="text-5xl font-bold bg-gradient-to-r from-cyan-300 to-blue-300 bg-clip-text text-transparent mb-3">500+</div>
                        <div class="text-white/70">zones mortes identifiées dans le monde</div>
                    </div>
                    <div class="bg-gradient-to-br from-slate-800/40 to-slate-900/40 backdrop-blur-xl border border-white/20 rounded-2xl p-8 text-center hover:scale-105 hover:border-cyan-400/50 transition-all duration-300">
                        <div class="text-5xl font-bold bg-gradient-to-r from-cyan-300 to-blue-300 bg-clip-text text-transparent mb-3">4,5M</div>
                        <div class="text-white/70">km² d'océans affectés par l'hypoxie</div>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="slide-up slide-up-4">
                <div class="bg-gradient-to-r from-cyan-500/20 to-blue-600/20 backdrop-blur-xl border border-cyan-500/40 rounded-2xl p-12 text-center group hover:border-cyan-400/60 transition-all duration-300">
                    <h2 class="text-3xl md:text-4xl font-light text-white mb-6">
                        Explorez les Données
                        <span class="block font-medium bg-gradient-to-r from-cyan-300 to-blue-300 bg-clip-text text-transparent">
                            en Temps Réel
                        </span>
                    </h2>
                    <p class="text-xl text-white/70 mb-8 leading-relaxed">
                        Découvrez comment la désoxygénation affecte nos océans à travers des visualisations interactives et des données scientifiques actualisées.
                    </p>
                    <a
                        href="?action=analyse"
                        class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold rounded-xl hover:from-cyan-600 hover:to-blue-700 transition-all duration-300 hover:shadow-lg hover:shadow-cyan-500/50"
                    >
                        Démarrer l'analyse
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
