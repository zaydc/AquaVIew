<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notre Équipe - AquaView</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .fade-in { animation: fadeIn 0.7s ease-out forwards; }
        .slide-up { animation: slideUp 0.7s ease-out forwards; opacity: 0; }
        .slide-up-1 { animation-delay: 0.1s; }
        .slide-up-2 { animation-delay: 0.2s; }
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
            <div class="mb-12 slide-up slide-up-1">
                <h1 class="text-4xl md:text-5xl font-light mb-4">Notre Équipe</h1>
                <p class="text-white/60 text-lg max-w-2xl leading-relaxed">
                    Découvrez les experts passionnés qui travaillent à comprendre et protéger nos océans
                </p>
            </div>

            <!-- Grille de l'équipe -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto slide-up slide-up-2">
                
                <!-- Membre de l'équipe 1 - Ahmed -->
                <div class="group bg-slate-800/40 backdrop-blur-sm rounded-2xl p-6 border border-blue-500/20 hover:border-cyan-400/50 transition-all duration-300 hover:transform hover:scale-105">
                    <div class="relative mb-6">
                        <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-cyan-400 to-blue-600 p-1">
                            <img 
                                src="/web/assets/team/ahmed.jpg" 
                                alt="Ahmed"
                                class="w-full h-full rounded-full object-cover bg-slate-700"
                            />
                        </div>
                    </div>
                    <div class="text-center">
                        <h3 class="text-xl font-semibold text-white mb-2">Ahmed</h3>
                        <p class="text-cyan-400 font-medium mb-3">Chef de projet</p>
                        <p class="text-blue-200/80 text-sm leading-relaxed mb-4">
                            Coordination de l'équipe, planification des tâches et garantie du respect des objectifs et des délais du projet
                        </p>
                    </div>
                </div>

                <!-- Membre de l'équipe 2 - Zayd -->
                <div class="group bg-slate-800/40 backdrop-blur-sm rounded-2xl p-6 border border-blue-500/20 hover:border-cyan-400/50 transition-all duration-300 hover:transform hover:scale-105">
                    <div class="relative mb-6">
                        <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-cyan-400 to-blue-600 p-1">
                            <img 
                                src="/web/assets/team/zayd.jpeg" 
                                alt="Zayd"
                                class="w-full h-full rounded-full object-cover bg-slate-700"
                            />
                        </div>
                    </div>
                    <div class="text-center">
                        <h3 class="text-xl font-semibold text-white mb-2">Zayd</h3>
                        <p class="text-cyan-400 font-medium mb-3">Développeur Frontend</p>
                        <p class="text-blue-200/80 text-sm leading-relaxed mb-4">
                            Création d'interfaces utilisateur claires, intuitives et responsives pour la visualisation des données
                        </p>
                    </div>
                </div>

                <!-- Membre de l'équipe 3 - Ryan -->
                <div class="group bg-slate-800/40 backdrop-blur-sm rounded-2xl p-6 border border-blue-500/20 hover:border-cyan-400/50 transition-all duration-300 hover:transform hover:scale-105">
                    <div class="relative mb-6">
                        <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-cyan-400 to-blue-600 p-1">
                            <img 
                                src="/web/assets/team/ryan.jpeg" 
                                alt="Ryan"
                                class="w-full h-full rounded-full object-cover bg-slate-700"
                            />
                        </div>
                    </div>
                    <div class="text-center">
                        <h3 class="text-xl font-semibold text-white mb-2">Ryan</h3>
                        <p class="text-cyan-400 font-medium mb-3">Développeur Backend</p>
                        <p class="text-blue-200/80 text-sm leading-relaxed mb-4">
                            Gestion de la logique métier et communication entre la base de données et l'application
                        </p>
                    </div>
                </div>

                <!-- Membre de l'équipe 4 - Adam -->
                <div class="group bg-slate-800/40 backdrop-blur-sm rounded-2xl p-6 border border-blue-500/20 hover:border-cyan-400/50 transition-all duration-300 hover:transform hover:scale-105">
                    <div class="relative mb-6">
                        <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-cyan-400 to-blue-600 p-1">
                            <img 
                                src="/web/assets/team/adam.png" 
                                alt="Adam"
                                class="w-full h-full rounded-full object-cover bg-slate-700"
                            />
                        </div>
                    </div>
                    <div class="text-center">
                        <h3 class="text-xl font-semibold text-white mb-2">Adam</h3>
                        <p class="text-cyan-400 font-medium mb-3">Gestionnaire de Base de Données</p>
                        <p class="text-blue-200/80 text-sm leading-relaxed mb-4">
                            Conception, optimisation et sécurisation des bases de données pour garantir la fiabilité et la cohérence des données
                        </p>
                    </div>
                </div>

                <!-- Membre de l'équipe 5 - Fiona -->
                <div class="group bg-slate-800/40 backdrop-blur-sm rounded-2xl p-6 border border-blue-500/20 hover:border-cyan-400/50 transition-all duration-300 hover:transform hover:scale-105">
                    <div class="relative mb-6">
                        <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-cyan-400 to-blue-600 p-1">
                            <img 
                                src="/web/assets/team/fiona.JPG"  
                                alt="Fiona"
                                class="w-full h-full rounded-full object-cover bg-slate-700"
                            />
                        </div>
                    </div>
                    <div class="text-center">
                        <h3 class="text-xl font-semibold text-white mb-2">Fiona</h3>
                        <p class="text-cyan-400 font-medium mb-3">Analyste de Données</p>
                        <p class="text-blue-200/80 text-sm leading-relaxed mb-4">
                            Traitement, analyse et mise en forme des données à travers des visualisations interactives et lisibles
                        </p>
                    </div>
                </div>

                <!-- Membre de l'équipe 6 - Selmane -->
                <div class="group bg-slate-800/40 backdrop-blur-sm rounded-2xl p-6 border border-blue-500/20 hover:border-cyan-400/50 transition-all duration-300 hover:transform hover:scale-105">
                    <div class="relative mb-6">
                        <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-cyan-400 to-blue-600 p-1">
                            <img 
                                src="/web/assets/team/selmane.png" 
                                alt="Selmane"
                                class="w-full h-full rounded-full object-cover bg-slate-700"
                            />
                        </div>
                    </div>
                    <div class="text-center">
                        <h3 class="text-xl font-semibold text-white mb-2">Selmane</h3>
                        <p class="text-cyan-400 font-medium mb-3">Responsable Tests</p>
                        <p class="text-blue-200/80 text-sm leading-relaxed mb-4">
                            Tests fonctionnels, validation de la stabilité de l'application et rédaction de la documentation du projet
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
