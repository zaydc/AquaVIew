<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>En Savoir Plus - AquaView</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* On garde tes animations d'origine qui étaient très bien */
        .fade-in { animation: fadeIn 0.7s ease-out forwards; }
        .slide-up { animation: slideUp 0.7s ease-out forwards; opacity: 0; }
        .zoom-in { animation: zoomIn 2s ease-out forwards; }
        
        /* Délais en cascade pour la grille */
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(2rem); } to { opacity: 1; transform: translateY(0); } }
        @keyframes zoomIn { from { opacity: 0; } to { opacity: 1; } }
        
        /* Petite amélioration pour les barres de défilement dans les cartes si besoin */
        .glass-panel::-webkit-scrollbar { width: 6px; }
        .glass-panel::-webkit-scrollbar-track { background: transparent; }
        .glass-panel::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.2); border-radius: 3px; }
    </style>
</head>
<body class="bg-slate-900 text-slate-200 antialiased selection:bg-cyan-500/30 selection:text-cyan-200">
    
    <?php include __DIR__ . '/../components/navbar.php'; ?>
    
    <div class="relative min-h-screen pt-24 pb-12">
        
        <div class="fixed inset-0 zoom-in z-0">
            <img src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=1920&q=80" alt="Océan" class="absolute inset-0 w-full h-full object-cover" />
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900/95 via-slate-900/90 to-blue-900/80"></div>
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 200 200%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noiseFilter%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.65%22 numOctaves=%223%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noiseFilter)%22/%3E%3C/svg%3E');"></div>
        </div>

        <main class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6">
            
            <div class="text-center mb-16 slide-up">
                <h1 class="text-4xl md:text-6xl font-light tracking-tight text-white mb-6">
                    La Désoxygénation
                    <span class="block mt-1 font-semibold bg-gradient-to-r from-cyan-300 via-blue-300 to-indigo-300 bg-clip-text text-transparent">
                        des Océans
                    </span>
                </h1>
                <p class="text-slate-400 text-lg md:text-xl max-w-3xl mx-auto leading-relaxed">
                    L'océan suffoque en silence. Comprendre ce phénomène invisible est la première étape pour préserver l'équilibre vital de notre planète.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-16">

                <div class="md:col-span-8 group bg-slate-800/40 backdrop-blur-xl border border-white/10 rounded-2xl p-8 hover:bg-slate-800/50 hover:border-cyan-400/30 transition-all duration-300 slide-up delay-100">
                    <div class="flex items-start justify-between mb-4">
                        <h2 class="text-2xl font-semibold text-white group-hover:text-cyan-300 transition-colors">C'est quoi ?</h2>
                        <div class="p-2 bg-white/5 rounded-lg border border-white/10">
                            <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                    </div>
                    <p class="text-slate-300 leading-relaxed text-lg">
                        C'est la diminution progressive de l'oxygène dissous dans l'eau de mer. Ce n'est pas juste un détail technique : c'est l'équivalent marin de la raréfaction de l'air. Elle crée des zones où la vie marine ne peut plus respirer, du littoral jusqu'aux abysses.
                    </p>
                </div>

                <div class="md:col-span-4 group bg-gradient-to-br from-slate-800/40 to-blue-900/20 backdrop-blur-xl border border-white/10 rounded-2xl p-8 flex flex-col justify-center items-center text-center hover:border-cyan-400/30 transition-all duration-300 slide-up delay-100">
                    <span class="text-5xl md:text-6xl font-bold bg-gradient-to-r from-cyan-300 to-blue-300 bg-clip-text text-transparent mb-2">2%</span>
                    <span class="text-slate-400 text-sm uppercase tracking-wider font-medium">Oxygène perdu depuis 1960</span>
                </div>

                <div class="md:col-span-6 group bg-slate-800/40 backdrop-blur-xl border border-white/10 rounded-2xl p-8 hover:bg-slate-800/50 hover:border-cyan-400/30 transition-all duration-300 slide-up delay-200">
                    <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full bg-red-400 shadow-[0_0_10px_rgba(248,113,113,0.5)]"></span>
                        Les Causes
                    </h2>
                    <ul class="space-y-4">
                        <li class="flex gap-4 items-start">
                            <div class="mt-1 p-1.5 bg-red-500/10 rounded text-red-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" /></svg>
                            </div>
                            <div>
                                <strong class="text-slate-200 block text-sm">Réchauffement climatique</strong>
                                <span class="text-slate-400 text-sm">L'eau chaude retient physiquement moins d'oxygène.</span>
                            </div>
                        </li>
                        <li class="flex gap-4 items-start">
                            <div class="mt-1 p-1.5 bg-red-500/10 rounded text-red-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                            </div>
                            <div>
                                <strong class="text-slate-200 block text-sm">Eutrophisation</strong>
                                <span class="text-slate-400 text-sm">Excès de nutriments = prolifération d'algues qui étouffent l'eau.</span>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="md:col-span-6 group bg-slate-800/40 backdrop-blur-xl border border-white/10 rounded-2xl p-8 hover:bg-slate-800/50 hover:border-cyan-400/30 transition-all duration-300 slide-up delay-200">
                    <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full bg-purple-400 shadow-[0_0_10px_rgba(192,132,252,0.5)]"></span>
                        Les Conséquences
                    </h2>
                    <ul class="space-y-4">
                        <li class="flex gap-4 items-start">
                            <div class="mt-1 p-1.5 bg-purple-500/10 rounded text-purple-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            </div>
                            <div>
                                <strong class="text-slate-200 block text-sm">Zones Mortes</strong>
                                <span class="text-slate-400 text-sm">Mortalité massive et migration forcée des espèces.</span>
                            </div>
                        </li>
                        <li class="flex gap-4 items-start">
                            <div class="mt-1 p-1.5 bg-purple-500/10 rounded text-purple-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                            </div>
                            <div>
                                <strong class="text-slate-200 block text-sm">Économie locale</strong>
                                <span class="text-slate-400 text-sm">Impacts directs sur la pêche et le tourisme côtier.</span>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="md:col-span-12 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-slate-800/30 backdrop-blur-sm border border-white/5 rounded-xl p-6 text-center hover:bg-slate-800/40 transition slide-up delay-300">
                        <div class="text-3xl font-bold text-white mb-1">500+</div>
                        <div class="text-cyan-400 text-xs uppercase tracking-wider">Zones mortes</div>
                    </div>
                    <div class="bg-slate-800/30 backdrop-blur-sm border border-white/5 rounded-xl p-6 text-center hover:bg-slate-800/40 transition slide-up delay-300">
                        <div class="text-3xl font-bold text-white mb-1">4.5M</div>
                        <div class="text-cyan-400 text-xs uppercase tracking-wider">Km² affectés</div>
                    </div>
                    <div class="bg-slate-800/30 backdrop-blur-sm border border-white/5 rounded-xl p-6 text-center hover:bg-slate-800/40 transition slide-up delay-300">
                        <div class="text-3xl font-bold text-white mb-1">X10</div>
                        <div class="text-cyan-400 text-xs uppercase tracking-wider">Augmentation zones mortes</div>
                    </div>
                </div>

                <div class="md:col-span-12 bg-gradient-to-r from-slate-800/60 to-slate-900/60 backdrop-blur-xl border border-white/10 rounded-2xl p-8 hover:border-cyan-400/30 transition-all duration-300 slide-up delay-400">
                    <div class="md:flex justify-between items-center gap-8">
                        <div class="md:w-1/3 mb-6 md:mb-0">
                            <h2 class="text-2xl font-semibold text-white mb-2">Les Solutions</h2>
                            <p class="text-slate-400 mb-4">L'espoir réside dans l'action immédiate. Voici les leviers principaux.</p>
                            <a href="#" class="text-cyan-400 text-sm hover:text-cyan-300 font-medium inline-flex items-center gap-1 transition-colors">
                                Lire le rapport complet
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </a>
                        </div>
                        <div class="md:w-2/3 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex items-center gap-3 p-3 rounded-lg bg-white/5 border border-white/5">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span class="text-slate-300 text-sm">Réduire les émissions de CO2</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-lg bg-white/5 border border-white/5">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                                <span class="text-slate-300 text-sm">Gérer les rejets agricoles</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-lg bg-white/5 border border-white/5">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span class="text-slate-300 text-sm">Aires marines protégées</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-lg bg-white/5 border border-white/5">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                                <span class="text-slate-300 text-sm">Surveillance technologique</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="slide-up delay-500 max-w-2xl mx-auto">
                <div class="bg-gradient-to-r from-cyan-500/10 to-blue-600/10 backdrop-blur-xl border border-cyan-500/30 rounded-2xl p-8 text-center group hover:border-cyan-400/50 hover:shadow-[0_0_30px_rgba(6,182,212,0.15)] transition-all duration-300">
                    <h2 class="text-2xl text-white font-light mb-4">
                        Explorez les Données
                        <span class="font-semibold text-cyan-400">en Temps Réel</span>
                    </h2>
                    <a href="?action=analyse" class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-cyan-600 to-blue-600 text-white font-semibold rounded-lg hover:from-cyan-500 hover:to-blue-500 transition-all duration-300 shadow-lg shadow-cyan-900/50">
                        Lancer l'analyse
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </a>
                </div>
            </div>

        </main>
    </div>
</body>
</html>