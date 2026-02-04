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
        
        /* Modal animations */
        .modal-overlay {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        .modal-content {
            transform: scale(0.9) translateY(20px);
            opacity: 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }
        .modal-overlay.active .modal-content {
            transform: scale(1) translateY(0);
            opacity: 1;
        }
        
        /* Cursor pointer for clickable cards */
        .team-card {
            cursor: pointer;
        }
        .team-card:hover .view-cv-hint {
            opacity: 1;
        }
        .view-cv-hint {
            opacity: 0;
            transition: opacity 0.3s ease;
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
                    Découvrez notre équipe qui contribue à la création d'AquaView, une application innovante dédiée à la visualisation des données hydrométriques. 
                </p>
            </div>

            <!-- Grille de l'équipe -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto slide-up slide-up-2">
                
                <!-- Membre de l'équipe 1 - Ahmed -->
                <div class="team-card group bg-slate-800/40 backdrop-blur-sm rounded-2xl p-6 border border-blue-500/20 hover:border-cyan-400/50 transition-all duration-300 hover:transform hover:scale-105"
                     data-member="ahmed"
                     onclick="openCVModal('ahmed')">
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
                        <span class="view-cv-hint inline-flex items-center gap-2 text-cyan-300 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Voir le CV
                        </span>
                    </div>
                </div>

                <!-- Membre de l'équipe 2 - Zayd -->
                <div class="team-card group bg-slate-800/40 backdrop-blur-sm rounded-2xl p-6 border border-blue-500/20 hover:border-cyan-400/50 transition-all duration-300 hover:transform hover:scale-105"
                     data-member="zayd"
                     onclick="openCVModal('zayd')">
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
                        <span class="view-cv-hint inline-flex items-center gap-2 text-cyan-300 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Voir le CV
                        </span>
                    </div>
                </div>

                <!-- Membre de l'équipe 3 - Ryan -->
                <div class="team-card group bg-slate-800/40 backdrop-blur-sm rounded-2xl p-6 border border-blue-500/20 hover:border-cyan-400/50 transition-all duration-300 hover:transform hover:scale-105"
                     data-member="ryan"
                     onclick="openCVModal('ryan')">
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
                        <span class="view-cv-hint inline-flex items-center gap-2 text-cyan-300 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Voir le CV
                        </span>
                    </div>
                </div>

                <!-- Membre de l'équipe 4 - Adam -->
                <div class="team-card group bg-slate-800/40 backdrop-blur-sm rounded-2xl p-6 border border-blue-500/20 hover:border-cyan-400/50 transition-all duration-300 hover:transform hover:scale-105"
                     data-member="adam"
                     onclick="openCVModal('adam')">
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
                        <span class="view-cv-hint inline-flex items-center gap-2 text-cyan-300 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Voir le CV
                        </span>
                    </div>
                </div>

                <!-- Membre de l'équipe 5 - Fiona -->
                <div class="team-card group bg-slate-800/40 backdrop-blur-sm rounded-2xl p-6 border border-blue-500/20 hover:border-cyan-400/50 transition-all duration-300 hover:transform hover:scale-105"
                     data-member="fiona"
                     onclick="openCVModal('fiona')">
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
                        <span class="view-cv-hint inline-flex items-center gap-2 text-cyan-300 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Voir le CV
                        </span>
                    </div>
                </div>

                <!-- Membre de l'équipe 6 - Selmane -->
                <div class="team-card group bg-slate-800/40 backdrop-blur-sm rounded-2xl p-6 border border-blue-500/20 hover:border-cyan-400/50 transition-all duration-300 hover:transform hover:scale-105"
                     data-member="selmane"
                     onclick="openCVModal('selmane')">
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
                        <span class="view-cv-hint inline-flex items-center gap-2 text-cyan-300 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Voir le CV
                        </span>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- MODAL CV -->
    <div id="cvModal" class="modal-overlay fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm">
        <div class="modal-content bg-slate-800/95 backdrop-blur-md rounded-2xl border border-blue-500/30 w-full max-w-3xl max-h-[90vh] overflow-y-auto">
            <!-- Header du modal -->
            <div class="sticky top-0 bg-slate-800/95 backdrop-blur-md border-b border-blue-500/20 p-6 flex items-center justify-between">
                <h2 class="text-2xl font-semibold text-white">Curriculum Vitae</h2>
                <button onclick="closeCVModal()" class="p-2 rounded-full hover:bg-slate-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white/70 hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Contenu du CV -->
            <div class="p-6">
                <!-- Photo et infos principales -->
                <div class="flex flex-col md:flex-row gap-6 mb-8">
                    <div class="flex-shrink-0">
                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-cyan-400 to-blue-600 p-1">
                            <img id="cvPhoto" src="" alt="" class="w-full h-full rounded-full object-cover bg-slate-700" />
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 id="cvName" class="text-3xl font-bold text-white mb-2"></h3>
                        <p id="cvRole" class="text-cyan-400 text-xl font-medium mb-4"></p>
                        <p id="cvEmail" class="text-blue-200/80 flex items-center gap-2 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span></span>
                        </p>
                        <p id="cvLinkedin" class="text-blue-200/80 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                            </svg>
                            <span></span>
                        </p>
                        <p id="cvTelephone" class="text-blue-200/80 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span></span>
                        </p>
                        <p id="cvLocalisation" class="text-blue-200/80 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span></span>
                        </p>
                    </div>
                </div>

                <!-- Section Formation -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                        </svg>
                        Formation
                    </h4>
                    <div id="cvFormation" class="space-y-3"></div>
                </div>

                <!-- Section Expérience -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Expérience
                    </h4>
                    <div id="cvExperience" class="space-y-3"></div>
                </div>

                <!-- Section Compétences -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                        Compétences
                    </h4>
                    <div id="cvCompetences" class="flex flex-wrap gap-2"></div>
                </div>

                <!-- Section Langues -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                        </svg>
                        Langues
                    </h4>
                    <div id="cvLangues" class="flex flex-wrap gap-4"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Données des CV des membres de l'équipe
        const teamCVData = {
            ahmed: {
                name: "Ahmed GDAIEM",
                role: "Chef de projet",
                photo: "/web/assets/team/ahmed.jpg",
                email: "agdaiem35@gmail.com",
                linkedin: "linkedin.com/in/ahmed-gdaiem",
                telephone: "07 64 27 59 84",
                localisation: "Aubervilliers",
                formation: [
                    { diplome: "BUT Informatique - Parcours Réalisation d'Applications", ecole: "Université Paris-Est Créteil (UPEC)", annee: "2024 - 2027" },
                    { diplome: "Baccalauréat STI2D - Option SIN (Systèmes d'Information et Numérique)", ecole: "Lycée Le Corbusier", annee: "2023" }
                ],
                experience: [
                    { poste: "Chef de projet - AquaView", entreprise: "Projet académique UPEC", periode: "2025", description: "Coordination de l'équipe, planification des tâches et garantie du respect des objectifs et des délais du projet" },
                    { poste: "Full-Stack Web Developer", entreprise: "Projet E-Commerce - UPEC", periode: "2024 - 2025", description: "Conception et développement d'un site e-commerce complet (HTML, CSS, JS), API REST sécurisée, base MySQL, système d'authentification" },
                    { poste: "Python Developer - Algorithmics & Data Analysis", entreprise: "Projet académique UPEC", periode: "2024", description: "Implémentation d'algorithmes de tri, analyse de complexité, traitement de données avec Pandas et Matplotlib" },
                    { poste: "Systems & Network Technician", entreprise: "Projet DevOps/Infrastructure - UPEC", periode: "2024", description: "Configuration Linux, Docker, CI/CD avec GitHub Actions, sécurisation des accès" }
                ],
                competences: ["Python", "JavaScript", "React", "HTML/CSS", "SQL", "MySQL", "Oracle", "SQLite", "Flask", "Node.js", "Git/GitHub", "Docker", "CI/CD", "Linux", "Agile/Scrum", "Modélisation UML"],
                langues: [
                    { langue: "Français", niveau: "Natif" },
                    { langue: "Anglais", niveau: "Intermédiaire (B1-B2)" },
                    { langue: "Allemand", niveau: "Débutant (A1)" }
                ]
            },
            zayd: {
                name: "Zayd CROMBEZ",
                role: "Développeur Frontend",
                photo: "/web/assets/team/zayd.jpeg",
                email: "zayd.crombez@gmail.com",
                linkedin: "linkedin.com/in/zayd-crombez",
                telephone: "06 95 36 46 09",
                localisation: "Vigneux-sur-Seine",
                formation: [
                    { diplome: "BUT Informatique - Parcours Réalisation d'Applications", ecole: "IUT de Créteil Vitry - UPEC", annee: "En cours" },
                    { diplome: "Baccalauréat Générale - Spécialités NSI, Maths", ecole: "Lycée Rosa Parks - Montgeron", annee: "2021 - 2024" }
                ],
                experience: [
                    { poste: "Développeur Frontend - AquaView", entreprise: "Projet académique", periode: "Sept. 2025 - Présent", description: "Développement d'une application web dynamique en Vue.js, incluant visualisations interactives et interface réactive connectée à une API REST en PHP" },
                    { poste: "Application web d'analyse de données océanographiques", entreprise: "Projet académique", periode: "Mars - Avril 2025", description: "Collecte automatisée de données via API, traitement et validation en PHP, nettoyage et intégration dans une base MySQL optimisée" },
                    { poste: "Application avec base de données et visualisation", entreprise: "Projet académique", periode: "Fév. - Mars 2025", description: "Développement en Python avec stockage SQL, utilisation de Pandas et Matplotlib pour graphiques interactifs" },
                    { poste: "Analyse de données et cartographie", entreprise: "Projet académique", periode: "Janv. - Fév. 2025", description: "Script Python pour données Vélib', carte interactive avec Folium, SciPy et NumPy" }
                ],
                competences: ["Vue.js", "JavaScript", "PHP", "Python", "HTML/CSS", "Flask", "API REST", "MySQL", "SQLite", "PL/SQL", "Pandas", "NumPy", "Matplotlib", "Plotly", "Git/GitHub", "Docker", "Figma", "Photoshop", "Illustrator", "Agile"],
                langues: [
                    { langue: "Français", niveau: "Langue maternelle" },
                    { langue: "Anglais", niveau: "B2" },
                    { langue: "Espagnol", niveau: "B1" }
                ]
            },
            ryan: {
                name: "Ryan BACHATENE",
                role: "Développeur Backend",
                photo: "/web/assets/team/ryan.jpeg",
                email: "ryan.bachatene@etu.u-pec.fr",
                linkedin: "linkedin.com/in/ryan-bachatene-1456ab330",
                telephone: "06 95 69 24 99",
                localisation: "Paris 75020",
                formation: [
                    { diplome: "BUT Informatique - 2ème année", ecole: "Université Paris Est Créteil - Vitry-sur-Seine", annee: "Depuis Sept. 2024" },
                    { diplome: "Baccalauréat STI2D SIN", ecole: "Lycée Raspail - Paris", annee: "Juillet 2024" }
                ],
                experience: [
                    { poste: "Développeur Backend - AquaView", entreprise: "Projet académique", periode: "2025", description: "Gestion de la logique métier et communication entre la base de données et l'application" },
                    { poste: "Développement plateforme de covoiturage", entreprise: "Projet académique", periode: "Oct. 2025", description: "Site dynamique en PHP/HTML/CSS sous MAMP, architecture MVC, base MySQL, gestion sessions et cookies" },
                    { poste: "Application avec base de données et visualisation", entreprise: "Projet académique", periode: "Janv. 2025", description: "Application Python avec stockage SQL, Pandas et Matplotlib, données de santé Ameli" },
                    { poste: "Analyse de données et cartographie", entreprise: "Projet académique", periode: "Mars 2025", description: "Script Python pour données Vélib' en JSON, carte interactive avec Folium, Scipy et Numpy" },
                    { poste: "Création de base de données", entreprise: "Projet académique", periode: "Déc. 2024", description: "Traitement fichiers CSV, modélisation base relationnelle sur DBeaver, requêtes SQL" }
                ],
                competences: ["C", "Python", "Java POO", "PL/SQL", "PHP", "HTML", "CSS", "SQL", "SQLite", "MySQL", "Pandas", "Matplotlib", "Flask", "Folium", "Scipy", "Numpy", "phpMyAdmin", "VS Code", "VirtualBox", "DBeaver", "Oracle", "Git", "Figma", "SCRUM", "Agile"],
                langues: [
                    { langue: "Français", niveau: "Natif" },
                    { langue: "Anglais", niveau: "B1" },
                    { langue: "Arabe", niveau: "Langue parentale" }
                ]
            },
            adam: {
                name: "Adam AZIROU",
                role: "Gestionnaire de Base de Données",
                photo: "/web/assets/team/adam.png",
                email: "adam.azirou@etu-u-pec.fr",
                linkedin: "linkedin.com/in/adam-azirou-142352330",
                telephone: "07 68 30 51 22",
                localisation: "Choisy-Le-Roi",
                formation: [
                    { diplome: "BUT Informatique - 2ème année", ecole: "IUT de Créteil - Vitry, Université Paris Est Créteil", annee: "2024 - Aujourd'hui" },
                    { diplome: "Baccalauréat STI2D - Option SIN", ecole: "Lycée Maximilien Perret, Alfortville", annee: "2024" },
                    { diplome: "Formation BAFA", ecole: "", annee: "2022 - 2023" }
                ],
                experience: [
                    { poste: "Gestionnaire BDD - AquaView", entreprise: "Projet académique", periode: "2025", description: "Conception, optimisation et sécurisation des bases de données pour garantir la fiabilité et la cohérence des données" },
                    { poste: "Application web d'analyse de données océanographiques", entreprise: "Projet académique", periode: "2025", description: "Collecte de données via API, nettoyage, modélisation et intégration dans une base SQL, développement d'une application web dynamique" },
                    { poste: "Application avec base de données et visualisation", entreprise: "Projet académique", periode: "2025", description: "Développement en Python avec stockage SQL, utilisation de Pandas et Matplotlib pour graphiques interactifs" },
                    { poste: "Analyse de données et cartographie interactive", entreprise: "Projet académique", periode: "2025", description: "Script Python pour données Vélib', extraction coordonnées, carte interactive avec Folium, SciPy et NumPy" },
                    { poste: "Animation centre de loisirs", entreprise: "Vacataire - Choisy-Le-Roi", periode: "Début 2024 - Aujourd'hui", description: "Animation et encadrement d'enfants" },
                    { poste: "Agent administratif", entreprise: "Terres d'Ailleurs - Paris 13", periode: "Juillet - Août 2023", description: "Gestion administrative" }
                ],
                competences: ["Python", "Java", "C", "SQL", "PHP", "HTML", "CSS", "MySQL", "SQLite", "Oracle", "Pandas", "Matplotlib", "API", "CSV", "JSON", "GitHub", "VS Code", "Wamp", "VirtualBox", "DBeaver", "Figma"],
                langues: [
                    { langue: "Français", niveau: "Langue maternelle" },
                    { langue: "Anglais", niveau: "B1" },
                    { langue: "Espagnol", niveau: "B1" }
                ]
            },
fiona: {
  name: "Fiona Ho",
  role: "Analyste de Données",
  photo: "/web/assets/team/fiona.JPG",
  email: "fiona.ho@etu.u-pec.fr",
  linkedin: "linkedin.com/in/fiona-ho",
  telephone: "07 78 95 05 54",
  localisation: "Vitry-sur-Seine",
  formation: [
  { diplome: "BUT Informatique - Parcours Réalisation d'Applications", ecole: "IUT de Créteil-Vitry, UPEC", annee: "Sept. 2024 - En cours" },
  { diplome: "Baccalauréat STMG - Option SIG (Systèmes d'Information de Gestion)", ecole: "Lycée privé Sainte-Catherine Labouré, Paris", annee: "Mention Assez bien" }
  ],
  experience: [
  { poste: "Analyste de Données - AquaView", entreprise: "Projet académique", periode: "2025", description: "Traitement, analyse et mise en forme des données à travers des visualisations interactives et lisibles" },
  { poste: "Développement d'une application web", entreprise: "Projet universitaire", periode: "2024-2025", description: "Développement interface web (Flask, HTML/CSS, Python), intégration base de données locale et API Hub'eau, affichage interactif sur carte et gestion des requêtes dynamiques" },
  { poste: "Conception et exploitation d'une base de données", entreprise: "Projet universitaire", periode: "2024-2025", description: "Modélisation E/R et création base SQL locale, script Python pour import données depuis API Hub'eau, tests et validation de l'intégrité des données" },
  { poste: "Comparaison d'approches algorithmiques", entreprise: "Projet universitaire", periode: "2024-2025", description: "Implémentation d'algorithmes de tri en C et Python, mesure et comparaison des temps d'exécution, analyse des complexités et visualisation graphique" }
  ],
  competences: ["Python", "Java", "PHP", "C", "HTML/CSS", "SQL", "SQLite", "MySQL", "PL/SQL", "Debian", "Ubuntu", "Bash", "Réseaux LAN", "SSH", "FTP", "DHCP", "VS Code", "IntelliJ IDEA", "Git", "GitHub", "phpMyAdmin", "MobaXterm", "VirtualBox", "DBeaver", "Travail en équipe", "Gestion de projet", "Autonomie", "Esprit d'analyse"],
  langues: [
  { langue: "Français", niveau: "Langue maternelle" },
  { langue: "Anglais", niveau: "Courant" },
  { langue: "Chinois (cantonnais)", niveau: "Intermédiaire" }
  ]
  },
            selmane: {
                name: "Selmane BENYELLES",
                role: "Responsable Tests",
                photo: "/web/assets/team/Selman.png",
                email: "selmane.benyelles@etu.u-pec.fr",
                linkedin: "linkedin.com/in/selmane-benyelles",
                telephone: "07 69 67 29 55",
                localisation: "Alfortville",
                formation: [
                    { diplome: "Licence Sciences pour l'Ingénieur", ecole: "Université Paris-Est Créteil (UPEC)", annee: "2024 - 2025" },
                    { diplome: "Baccalauréat Général - Spécialités Mathématiques et Physique", ecole: "Lycée Maximilien Perret, Alfortville", annee: "2021 - 2024" }
                ],
                experience: [
                    { poste: "Responsable Tests - AquaView", entreprise: "Projet académique UPEC", periode: "2025", description: "Élaboration des plans de tests fonctionnels et de non-régression, validation de la stabilité de l'application et rédaction de la documentation technique du projet" },
                    { poste: "Tests et validation d'application web", entreprise: "Projet universitaire", periode: "2024 - 2025", description: "Conception de scénarios de tests, exécution de tests manuels et automatisés, rédaction de rapports de bugs et suivi des corrections" },
                    { poste: "Analyse et modélisation de systèmes", entreprise: "Projet universitaire", periode: "2024 - 2025", description: "Modélisation UML de systèmes d'information, analyse des besoins fonctionnels et rédaction de cahiers des charges" },
                    { poste: "Développement et tests d'algorithmes", entreprise: "Projet universitaire", periode: "2024", description: "Implémentation d'algorithmes en Python et C, tests unitaires et analyse de complexité algorithmique" }
                ],
                competences: ["Tests fonctionnels", "Tests de non-régression", "Rédaction documentation", "Python", "C", "SQL", "Modélisation UML", "Analyse des besoins", "Gestion de bugs", "Méthodologie QA", "Rigueur", "Esprit analytique", "Git/GitHub", "VS Code"],
                langues: [
                    { langue: "Français", niveau: "Langue maternelle" },
                    { langue: "Anglais", niveau: "B1" },
                    { langue: "Arabe", niveau: "Langue parentale" }
                ]
            }
        };

        // Ouvrir le modal avec les données du membre
        function openCVModal(memberId) {
            const member = teamCVData[memberId];
            if (!member) return;

            // Remplir les données de base
            document.getElementById('cvPhoto').src = member.photo;
            document.getElementById('cvPhoto').alt = member.name;
            document.getElementById('cvName').textContent = member.name;
            document.getElementById('cvRole').textContent = member.role;
            document.getElementById('cvEmail').querySelector('span').textContent = member.email;
            document.getElementById('cvLinkedin').querySelector('span').textContent = member.linkedin;
            
            // Afficher telephone et localisation si disponibles
            const telElement = document.getElementById('cvTelephone');
            const locElement = document.getElementById('cvLocalisation');
            if (member.telephone) {
                telElement.style.display = 'flex';
                telElement.querySelector('span').textContent = member.telephone;
            } else {
                telElement.style.display = 'none';
            }
            if (member.localisation) {
                locElement.style.display = 'flex';
                locElement.querySelector('span').textContent = member.localisation;
            } else {
                locElement.style.display = 'none';
            }

            // Remplir la formation
            const formationContainer = document.getElementById('cvFormation');
            formationContainer.innerHTML = member.formation.map(f => `
                <div class="bg-slate-700/50 rounded-lg p-4 border-l-4 border-cyan-400">
                    <p class="font-semibold text-white">${f.diplome}</p>
                    <p class="text-blue-200/80 text-sm">${f.ecole} - ${f.annee}</p>
                </div>
            `).join('');

            // Remplir l'expérience
            const experienceContainer = document.getElementById('cvExperience');
            experienceContainer.innerHTML = member.experience.map(e => `
                <div class="bg-slate-700/50 rounded-lg p-4 border-l-4 border-blue-400">
                    <p class="font-semibold text-white">${e.poste}</p>
                    <p class="text-cyan-400 text-sm">${e.entreprise} | ${e.periode}</p>
                    <p class="text-blue-200/80 text-sm mt-2">${e.description}</p>
                </div>
            `).join('');

            // Remplir les compétences
            const competencesContainer = document.getElementById('cvCompetences');
            competencesContainer.innerHTML = member.competences.map(c => `
                <span class="px-3 py-1 bg-cyan-500/20 text-cyan-300 rounded-full text-sm border border-cyan-500/30">${c}</span>
            `).join('');

            // Remplir les langues
            const languesContainer = document.getElementById('cvLangues');
            languesContainer.innerHTML = member.langues.map(l => `
                <div class="flex items-center gap-2">
                    <span class="font-medium text-white">${l.langue}:</span>
                    <span class="text-blue-200/80">${l.niveau}</span>
                </div>
            `).join('');

            // Afficher le modal
            document.getElementById('cvModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        // Fermer le modal
        function closeCVModal() {
            document.getElementById('cvModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        // Fermer le modal en cliquant sur l'overlay
        document.getElementById('cvModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCVModal();
            }
        });

        // Fermer le modal avec la touche Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeCVModal();
            }
        });
    </script>
</body>
</html>
