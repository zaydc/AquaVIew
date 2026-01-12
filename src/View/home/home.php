<!-- 
    Page d'accueil principale d'AquaView
    BUT2 - S3 - AquaView Project
    Page d'atterrissage avec presentation du projet et acces a l'analyse
-->
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AquaView - Accueil & Analyse</title>
    <!-- TailwindCSS pour le design moderne et responsive -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Outfit pour le design moderne -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles personnalises pour les animations et le design -->
    <style>
        body { font-family: 'Outfit', sans-serif; }

        /* Animation de revelation au scroll */
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.5, 0, 0, 1);
        }
        
        .reveal-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Delais pour les animations en cascade */
        .delay-100 { transition-delay: 0.1s; }
        .delay-200 { transition-delay: 0.2s; }
        .delay-300 { transition-delay: 0.3s; }
    </style>
</head>
<!-- Corps de la page avec theme sombre et design moderne -->
<body class="bg-slate-900 text-slate-200 overflow-x-hidden selection:bg-cyan-500/30 selection:text-cyan-200">

    <!-- Inclusion de la barre de navigation -->
    <?php include __DIR__ . '/../components/navbar.php'; ?>
    
    <!-- Arriere-plan avec image oceanique et overlay -->
    <div class="fixed inset-0 z-0">
        <div id="global-bg" class="absolute inset-0 transition-all duration-[2500ms] ease-out opacity-0 scale-110">
            <!-- Image d'ocean depuis Unsplash -->
            <img src="https://images.unsplash.com/photo-1518837695005-2083093ee35b?w=1920&q=80" alt="Ocean" class="w-full h-full object-cover" />
        </div>
        <!-- Overlay sombre pour la lisibilite du texte -->
        <div id="global-overlay" class="absolute inset-0 bg-slate-900/40 transition-opacity duration-[1500ms] opacity-0"></div>
    </div>

    <!-- Contenu principal au-dessus de l'arriere-plan -->
    <main class="relative z-10">

        <!-- Section hero avec presentation du projet -->
        <div class="relative min-h-screen flex flex-col items-center justify-center pt-32 pb-40">
            
            <!-- Degradé pour ameliorer la lisibilite -->
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/80 via-transparent to-slate-900/90 pointer-events-none"></div>

            <!-- Conteneur centre avec grille responsive -->
            <section class="container mx-auto px-6 w-full relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    
                    <!-- Colonne de gauche : texte et presentation -->
                    <div class="space-y-8">
                        <!-- Titre principal avec animation -->
                        <h1 id="hero-title" class="text-5xl md:text-7xl font-bold tracking-tight leading-tight transition-all duration-700 ease-out opacity-0 translate-y-8 text-white drop-shadow-lg">
                            <span class="block font-light text-slate-200">Comprendre la</span>
                            <span class="block bg-gradient-to-r from-cyan-300 via-blue-300 to-teal-300 bg-clip-text text-transparent filter drop-shadow-lg leading-normal">
                                désoxygénation
                            </span>
                            <span class="block font-light text-slate-200">des océans</span>
                        </h1>

                        <p id="hero-desc" class="text-lg md:text-xl text-slate-100 leading-relaxed max-w-xl transition-all duration-700 ease-out delay-200 opacity-0 translate-y-8 drop-shadow-md">
                            Un phénomène invisible qui menace la vie marine et l'équilibre de notre planète. Explorez les données en temps réel et comprenez les enjeux.
                        </p>

                        <div id="hero-btn-more" class="transition-all duration-700 ease-out delay-300 opacity-0 translate-y-8 flex gap-4">
                            <a href="#infos"
                               class="inline-flex items-center gap-2 px-8 py-3 rounded-xl bg-white/10 border border-white/20 font-medium text-white hover:bg-white/20 hover:border-white/40 transition-all duration-300 backdrop-blur-md group shadow-lg shadow-black/20">
                                En savoir plus
                                <svg class="w-4 h-4 group-hover:translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                            </a>
                        </div>
                    </div>

                    <div id="hero-card" class="relative transition-all duration-700 ease-out delay-400 opacity-0 translate-y-8 hidden lg:block">
                        <div class="relative p-8 rounded-3xl backdrop-blur-xl bg-slate-800/30 border border-white/20 shadow-2xl shadow-black/40">
                            <div class="mb-8 space-y-4">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-xl font-light text-white">Éxaminez en détail l'évolution des différents paramètres</h3>
                                    <div class="flex items-center gap-2 px-3 py-1 ">
                                        
                                    </div>
                                </div>
                                <div class="relative h-32 rounded-xl bg-slate-900/40 border border-white/10 p-4 flex items-end justify-between gap-2">
                                    <div class="w-full bg-cyan-500/20 rounded-t h-[40%] animate-pulse"></div>
                                    <div class="w-full bg-cyan-500/40 rounded-t h-[70%]"></div>
                                    <div class="w-full bg-cyan-500/30 rounded-t h-[55%]"></div>
                                    <div class="w-full bg-cyan-500/60 rounded-t h-[85%]"></div>
                                    <div class="w-full bg-cyan-500/50 rounded-t h-[60%]"></div>
                                </div>
                        <div class="grid grid-cols-3 gap-4 mt-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white">≈ 3.0</div>
                            <div class="text-xs text-slate-300">mg/L O₂</div>
                        </div>
                        <div class="text-center border-l border-white/10">
                            <div class="text-2xl font-bold text-white">≈ 19.6</div>
                            <div class="text-xs text-slate-300">Temp °C</div>
                        </div>
                        <div class="text-center border-l border-white/10">
                            <div class="text-2xl font-bold text-white">~ 690</div>
                            <div class="text-xs text-slate-300">Stations</div>
                        </div>
                    </div>

                            </div>
                            <a href="?action=analyse" class="group w-full px-8 py-4 rounded-xl bg-gradient-to-r from-cyan-600 to-blue-600 text-white font-semibold shadow-lg shadow-cyan-900/20 hover:shadow-cyan-500/40 hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-3">
                                <span>Lancer l'analyse</span>
                                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            
            <div class="absolute bottom-0 left-0 right-0 h-40 bg-gradient-to-t from-slate-900 via-slate-900/50 to-transparent pointer-events-none"></div>

            <a href="#infos" class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce cursor-pointer group z-20 p-2">
                <div class="flex flex-col items-center gap-2">
                    <span class="text-xs uppercase tracking-widest text-white/50 group-hover:text-white transition-colors">Découvrir</span>
                    <svg class="w-6 h-6 text-white/70 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </div>
            </a>
        </div>

        <div id="infos" class="relative pt-48 pb-24 bg-slate-900/80 backdrop-blur-md shadow-[0_-20px_60px_-15px_rgba(15,23,42,1)]">
            
            <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-cyan-500/30 to-transparent"></div>

            <div class="max-w-7xl mx-auto px-6 relative z-10">
                
                <div class="mb-20 text-center reveal-on-scroll">
                    <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">Explorer et comprendre</h2>
                    <p class="text-slate-300 max-w-2xl mx-auto text-lg leading-relaxed">AquaView analyse des données environnementales réelles pour mettre en lumière les tendances spatio-temporelles de la désoxygénation des eaux.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-16">

                    <div class="md:col-span-8 bg-slate-800/50 backdrop-blur-xl border border-white/10 rounded-3xl p-8 hover:bg-slate-800/70 hover:border-cyan-500/30 transition-all duration-300 reveal-on-scroll shadow-lg">
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-2xl font-semibold text-white">Notre approche</h3>
                            <div class="p-2 bg-white/5 rounded-lg text-cyan-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            </div>
                        </div>
                        <p class="text-slate-300 leading-relaxed text-lg">
                            AquaView exploite des données géolocalisées (latitude, longitude) et historiques couvrant plusieurs décennies. L'objectif est pédagogique et analytique : comprendre où, quand et dans quelles conditions la désoxygénation est observée, tout en assumant les limites des données disponibles.
                        </p>
                    </div>

                    <div class="md:col-span-4 bg-gradient-to-br from-cyan-950/50 to-blue-950/30 backdrop-blur-xl border border-white/10 rounded-3xl p-8 flex flex-col justify-center items-center text-center reveal-on-scroll delay-100 shadow-lg hover:border-cyan-500/30 transition-all">
                        <div class="text-6xl font-bold bg-gradient-to-r from-cyan-300 to-blue-300 bg-clip-text text-transparent mb-2">20+</div>
                        <p class="text-slate-200 uppercase tracking-widest text-sm font-semibold">Années de données</p>
                        <p class="text-cyan-200/60 text-xs mt-2">Analyses historiques</p>
                    </div>

                    <div class="md:col-span-6 bg-slate-800/50 backdrop-blur-xl border border-white/10 rounded-3xl p-8 hover:bg-slate-800/70 hover:border-cyan-400/30 transition-all duration-300 reveal-on-scroll delay-200 shadow-lg">
                        <h3 class="text-xl font-semibold text-white mb-6 flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full bg-cyan-400 shadow-[0_0_10px_rgba(34,211,238,0.5)]"></span>
                            Paramètres analysés
                        </h3>
                        <ul class="space-y-4">
                            <li class="flex gap-4">
                                <span class="p-1.5 bg-cyan-500/10 rounded-lg text-cyan-400 h-fit"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg></span>
                                <span class="text-slate-300 text-sm leading-relaxed"><strong>Oxygène dissous :</strong> Concentration en O₂ dans l'eau (mg/L).</span>
                            </li>
                            <li class="flex gap-4">
                                <span class="p-1.5 bg-cyan-500/10 rounded-lg text-cyan-400 h-fit"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg></span>
                                <span class="text-slate-300 text-sm leading-relaxed"><strong>Température :</strong> Évolution thermique des masses d'eau.</span>
                            </li>
                            <li class="flex gap-4">
                                <span class="p-1.5 bg-cyan-500/10 rounded-lg text-cyan-400 h-fit"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></span>
                                <span class="text-slate-300 text-sm leading-relaxed"><strong>Salinité & Géolocalisation :</strong> Contexte spatial des mesures.</span>
                            </li>
                        </ul>
                    </div>

                  <div class="md:col-span-6 bg-slate-800/50 backdrop-blur-xl border border-white/10 rounded-3xl p-8 hover:bg-slate-800/70 hover:border-teal-400/30 transition-all duration-300 reveal-on-scroll delay-200 shadow-lg">
    <h3 class="text-xl font-semibold text-white mb-6 flex items-center gap-3">
        <span class="w-2 h-2 rounded-full bg-teal-400 shadow-[0_0_10px_rgba(45,212,191,0.5)]"></span>
        Objectifs
    </h3>
    <ul class="space-y-4">
        <li class="flex gap-4">
            <span class="p-1.5 bg-teal-500/10 rounded-lg text-teal-400 h-fit">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </span>
            <span class="text-slate-300 text-sm leading-relaxed">
                Mettre en évidence des <strong>tendances temporelles</strong> de la désoxygénation sur plusieurs décennies.
            </span>
        </li>

        <li class="flex gap-4">
            <span class="p-1.5 bg-teal-500/10 rounded-lg text-teal-400 h-fit">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </span>
            <span class="text-slate-300 text-sm leading-relaxed">
                Comparer les <strong>différences spatiales</strong> des niveaux d’oxygène dissous entre différentes zones géographiques.
            </span>
        </li>

        <li class="flex gap-4">
            <span class="p-1.5 bg-teal-500/10 rounded-lg text-teal-400 h-fit">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </span>
            <span class="text-slate-300 text-sm leading-relaxed">
                Analyser les <strong>relations entre désoxygénation et paramètres environnementaux</strong> (température, salinité).
            </span>
        </li>

        <li class="flex gap-4">
            <span class="p-1.5 bg-teal-500/10 rounded-lg text-teal-400 h-fit">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 13l4 4L19 7"></path>
                </svg>
            </span>
            <span class="text-slate-300 text-sm leading-relaxed">
                Identifier des <strong>zones potentiellement à risque</strong> pour les écosystèmes marins.
            </span>
        </li>
    </ul>
</div>

                <div class="md:col-span-12 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-slate-800/40 backdrop-blur-md rounded-2xl p-6 text-center border border-white/10 reveal-on-scroll hover:bg-slate-800/60 transition-colors">
                        <div class="text-3xl font-bold text-white">Spatio</div>
                        <div class="text-cyan-400 text-xs uppercase tracking-wider mt-1">Analyse géographique</div>
                    </div>
                    <div class="bg-slate-800/40 backdrop-blur-md rounded-2xl p-6 text-center border border-white/10 reveal-on-scroll delay-100 hover:bg-slate-800/60 transition-colors">
                        <div class="text-3xl font-bold text-white">Temporel</div>
                        <div class="text-cyan-400 text-xs uppercase tracking-wider mt-1">Tendances historiques</div>
                    </div>
                    <div class="bg-slate-800/40 backdrop-blur-md rounded-2xl p-6 text-center border border-white/10 reveal-on-scroll delay-200 hover:bg-slate-800/60 transition-colors">
                        <div class="text-3xl font-bold text-white">Multi-zones</div>
                        <div class="text-cyan-400 text-xs uppercase tracking-wider mt-1">Océans & côtes</div>
                    </div>
                </div>

                </div>
                
                <div class="text-center mt-20 reveal-on-scroll pb-20">
                    <h3 class="text-2xl text-white mb-6">Prêt à analyser les données ?</h3>
                    <a href="?action=analyse" class="inline-flex items-center gap-2 px-8 py-3 bg-white text-slate-900 rounded-full font-bold hover:bg-cyan-50 hover:scale-105 transition-all duration-300 shadow-[0_0_20px_rgba(255,255,255,0.3)]">
                        Accéder au tableau de bord
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

            </div>
        </div>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            // 1. Animation du fond
            setTimeout(() => {
                const bg = document.getElementById('global-bg');
                const overlay = document.getElementById('global-overlay');
                bg.classList.remove('opacity-0', 'scale-110');
                bg.classList.add('opacity-100', 'scale-100');
                overlay.classList.remove('opacity-0');
                overlay.classList.add('opacity-100');
            }, 100);

            // 2. Animations Hero
            setTimeout(() => {
                const title = document.getElementById('hero-title');
                const desc = document.getElementById('hero-desc');
                [title, desc].forEach(el => {
                    el.classList.remove('opacity-0', 'translate-y-8');
                    el.classList.add('opacity-100', 'translate-y-0');
                });
            }, 800);

            setTimeout(() => {
                const btnMore = document.getElementById('hero-btn-more');
                const card = document.getElementById('hero-card');
                [btnMore, card].forEach(el => {
                    el.classList.remove('opacity-0', 'translate-y-8');
                    el.classList.add('opacity-100', 'translate-y-0');
                });
            }, 1400);

            // 3. Observer pour le scroll
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('reveal-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.reveal-on-scroll').forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>
