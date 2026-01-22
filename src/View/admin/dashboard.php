<!-- 
    Tableau de bord administrateur d'AquaView
    BUT2 - S3 - AquaView Project
    Page d'administration avec statistiques et gestion des utilisateurs
-->
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AquaView - Administration</title>
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
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/80 via-slate-900/60 to-slate-900"></div>
    </div>

    <!-- Contenu principal au-dessus du fond -->
    <div class="relative z-10">

<div class="min-h-screen pt-24 px-4 pb-12">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-white mb-2">Tableau de bord Admin</h1>
            <p class="text-white/70">Gestion des utilisateurs et du système</p>
        </div>

        <!-- Messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="mb-6 p-4 rounded-xl bg-green-500/20 border border-green-500/30 text-green-300">
                <?= htmlspecialchars($_SESSION['success']) ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-500/30 text-red-300">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-2xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/70 text-sm mb-1">Utilisateurs totaux</p>
                        <p class="text-3xl font-bold text-white"><?= $stats['totalUsers'] ?></p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-2xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/70 text-sm mb-1">Administrateurs</p>
                        <p class="text-3xl font-bold text-white"><?= $stats['adminUsers'] ?></p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-2xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/70 text-sm mb-1">Utilisateurs réguliers</p>
                        <p class="text-3xl font-bold text-white"><?= $stats['regularUsers'] ?></p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-cyan-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Utilisateurs récents -->
            <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-2xl p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Utilisateurs récents</h2>
                <div class="space-y-3">
                    <?php if (empty($stats['recentUsers'])): ?>
                        <p class="text-white/50">Aucun utilisateur récent</p>
                    <?php else: ?>
                        <?php foreach ($stats['recentUsers'] as $user): ?>
                            <div class="flex items-center justify-between p-3 rounded-lg bg-white/5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-cyan-400 to-blue-400 flex items-center justify-center text-white font-semibold">
                                        <?= strtoupper(substr($user['prenom'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <p class="text-white font-medium"><?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></p>
                                        <p class="text-white/50 text-sm"><?= htmlspecialchars($user['email']) ?></p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-block px-2 py-1 rounded-lg text-xs font-medium <?= $user['role'] === 'admin' ? 'bg-purple-500/20 text-purple-300' : 'bg-cyan-500/20 text-cyan-300' ?>">
                                        <?= ucfirst($user['role']) ?>
                                    </span>
                                    <p class="text-white/50 text-xs mt-1">
                                        <?= date('d/m/Y', strtotime($user['date_inscription'])) ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="mt-4">
                    <a href="?controller=admin&action=users" class="inline-flex items-center gap-2 text-cyan-400 hover:text-cyan-300 transition-colors">
                        Voir tous les utilisateurs
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-2xl p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Actions rapides</h2>
                <div class="space-y-3">
                    <a href="?controller=admin&action=users" class="block p-4 rounded-xl bg-gradient-to-r from-cyan-500/20 to-blue-500/20 border border-cyan-500/30 hover:from-cyan-500/30 hover:to-blue-500/30 transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <div>
                                <p class="text-white font-medium">Gérer les utilisateurs</p>
                                <p class="text-white/50 text-sm">Modifier les rôles et supprimer des comptes</p>
                            </div>
                        </div>
                    </a>

                    <a href="?controller=utilisateur&action=create" class="block p-4 rounded-xl bg-gradient-to-r from-green-500/20 to-emerald-500/20 border border-green-500/30 hover:from-green-500/30 hover:to-emerald-500/30 transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            <div>
                                <p class="text-white font-medium">Créer un utilisateur</p>
                                <p class="text-white/50 text-sm">Ajouter un nouvel utilisateur au système</p>
                            </div>
                        </div>
                    </a>

                    <a href="?controller=utilisateur&action=profile" class="block p-4 rounded-xl bg-gradient-to-r from-purple-500/20 to-pink-500/20 border border-purple-500/30 hover:from-purple-500/30 hover:to-pink-500/30 transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <div>
                                <p class="text-white font-medium">Mon profil</p>
                                <p class="text-white/50 text-sm">Gérer mes informations personnelles</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Scripts pour l'animation du fond -->
    <script>
        // Animation du fond au chargement de la page
        document.addEventListener('DOMContentLoaded', function() {
            const bg = document.getElementById('global-bg');
            if (bg) {
                setTimeout(() => {
                    bg.classList.remove('opacity-0', 'scale-110');
                    bg.classList.add('opacity-100', 'scale-100');
                }, 100);
            }
        });
    </script>

    <!-- Inclusion du footer -->
    <?php include __DIR__ . '/../components/footer.php'; ?>
</body>
</html>
