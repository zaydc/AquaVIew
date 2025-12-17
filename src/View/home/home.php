<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AquaView - Accueil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white overflow-x-hidden">

    <?php include __DIR__ . '/../components/navbar.php'; ?>
    
    <div class="relative min-h-screen pt-20 overflow-hidden">

        <div id="hero-bg" class="absolute inset-0 transition-all duration-[2500ms] ease-out opacity-0 scale-110">
            <img
                src="https://images.unsplash.com/photo-1518837695005-2083093ee35b?w=1920&q=80"
                alt="Océan"
                class="absolute inset-0 w-full h-full object-cover"
            />
        </div>

        <div id="hero-overlay" class="absolute inset-0 transition-opacity duration-[1500ms] opacity-0">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900/95 via-blue-900/80 to-cyan-800/70"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent"></div>
        </div>

        <section class="relative z-10 container mx-auto px-6 py-12 md:py-20 min-h-[calc(100vh-5rem)] flex items-center">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 w-full items-center">
                
                <div class="space-y-8">
                    <h1 id="hero-title" class="text-4xl md:text-6xl lg:text-7xl font-extralight tracking-tight leading-tight transition-all duration-700 ease-out opacity-0 translate-y-8">
                        <span class="block">Comprendre la</span>
                        
                        <span class="block font-medium bg-gradient-to-r from-cyan-300 via-blue-300 to-teal-300 bg-clip-text text-transparent pb-4 -mb-3 leading-relaxed">
                            désoxygénation
                        </span>
                        
                        <span class="block">des océans</span>
                    </h1>

                    <p id="hero-desc" class="text-lg md:text-xl text-white/70 leading-relaxed max-w-xl transition-all duration-700 ease-out delay-200 opacity-0 translate-y-8">
                        Un phénomène invisible qui menace la vie marine
                        et l'équilibre de notre planète. Explorez les données en temps réel.
                    </p>

                    <div id="hero-btn-more" class="transition-all duration-700 ease-out delay-300 opacity-0 translate-y-8">
                        <a href="?action=ensavoirplus"
                           class="inline-block px-8 py-3 rounded-xl bg-white/5 border border-white/20 font-medium text-white/80 hover:bg-white/10 hover:border-white/30 transition-all duration-300">
                            En savoir plus
                        </a>
                    </div>
                </div>

                <div id="hero-card" class="relative transition-all duration-700 ease-out delay-400 opacity-0 translate-y-8">
                    <div class="relative p-8 rounded-3xl backdrop-blur-xl bg-white/5 border border-white/10 shadow-2xl shadow-black/30">
                        
                        <div class="mb-8 space-y-4">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-semibold text-white">Données en temps réel</h3>
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                                    <span class="text-sm text-white/60">Actif</span>
                                </div>
                            </div>

                            <div class="relative h-32 rounded-xl bg-white/5 border border-white/10 p-4">
                                <div class="flex items-end justify-between gap-2 h-full">
                                    <div class="flex-1 rounded-t bg-gradient-to-t from-white/30 to-white/10 transition-all duration-500 hover:from-white/50 hover:to-white/20" style="height: 60%"></div>
                                    <div class="flex-1 rounded-t bg-gradient-to-t from-white/35 to-white/15 transition-all duration-500 hover:from-white/55 hover:to-white/25" style="height: 80%"></div>
                                    <div class="flex-1 rounded-t bg-gradient-to-t from-white/25 to-white/10 transition-all duration-500 hover:from-white/45 hover:to-white/20" style="height: 45%"></div>
                                    <div class="flex-1 rounded-t bg-gradient-to-t from-white/30 to-white/12 transition-all duration-500 hover:from-white/50 hover:to-white/22" style="height: 70%"></div>
                                    <div class="flex-1 rounded-t bg-gradient-to-t from-white/28 to-white/12 transition-all duration-500 hover:from-white/48 hover:to-white/22" style="height: 55%"></div>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4 mt-6">
                                <div class="text-center p-4 rounded-xl bg-white/5 border border-white/10">
                                    <div class="text-2xl font-bold text-cyan-400">3.2</div>
                                    <div class="text-xs text-white/60 mt-1">mg/L</div>
                                </div>
                                <div class="text-center p-4 rounded-xl bg-white/5 border border-white/10">
                                    <div class="text-2xl font-bold text-blue-400">18.5</div>
                                    <div class="text-xs text-white/60 mt-1">°C</div>
                                </div>
                                <div class="text-center p-4 rounded-xl bg-white/5 border border-white/10">
                                    <div class="text-2xl font-bold text-teal-400">24</div>
                                    <div class="text-xs text-white/60 mt-1">Stations</div>
                                </div>
                            </div>
                        </div>

                        <a href="?action=analyse"
                           class="group w-full px-8 py-5 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-500 text-slate-900 font-semibold text-lg shadow-xl shadow-cyan-500/30 hover:shadow-2xl hover:shadow-cyan-500/40 hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-3">
                            <span>Démarrer l'analyse</span>
                            <svg class="w-6 h-6 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            // 1. Fond et Overlay (100ms)
            setTimeout(() => {
                const bg = document.getElementById('hero-bg');
                const overlay = document.getElementById('hero-overlay');
                
                bg.classList.remove('opacity-0', 'scale-110');
                bg.classList.add('opacity-100', 'scale-100');
                
                overlay.classList.remove('opacity-0');
                overlay.classList.add('opacity-100');
            }, 100);

            // 2. Titre et Description (1000ms)
            setTimeout(() => {
                const title = document.getElementById('hero-title');
                const desc = document.getElementById('hero-desc');
                
                [title, desc].forEach(el => {
                    el.classList.remove('opacity-0', 'translate-y-8');
                    el.classList.add('opacity-100', 'translate-y-0');
                });
            }, 1000);

            // 3. Boutons et Carte (1600ms)
            setTimeout(() => {
                const btnMore = document.getElementById('hero-btn-more');
                const card = document.getElementById('hero-card');
                
                [btnMore, card].forEach(el => {
                    el.classList.remove('opacity-0', 'translate-y-8');
                    el.classList.add('opacity-100', 'translate-y-0');
                });
            }, 1600);
        });
    </script>
</body>
</html>