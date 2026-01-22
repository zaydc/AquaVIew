<!-- 
    Page de gestion des utilisateurs - Administration AquaView
    BUT2 - S3 - AquaView Project
    Page d'administration pour gérer les utilisateurs et leurs rôles
-->
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AquaView - Gestion des utilisateurs</title>
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
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold text-white mb-2">Gestion des utilisateurs</h1>
                <p class="text-white/70">Liste complète des utilisateurs et gestion des rôles</p>
            </div>
            <a href="?controller=admin&action=dashboard" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white hover:bg-white/20 transition-colors">
                ← Retour au dashboard
            </a>
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

        <!-- Tableau des utilisateurs -->
        <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
            <div class="p-6 border-b border-white/10">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-white">
                        <?= count($utilisateurs) ?> utilisateur(s) au total
                    </h2>
                    <a href="?controller=utilisateur&action=create" class="px-4 py-2 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white hover:shadow-lg hover:shadow-cyan-500/50 transition-all duration-300">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Nouvel utilisateur
                    </a>
                </div>
            </div>

            <?php if (empty($utilisateurs)): ?>
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-white/30 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <p class="text-white/50">Aucun utilisateur trouvé</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-white/5 border-b border-white/10">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-white/70 uppercase tracking-wider">Utilisateur</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-white/70 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-white/70 uppercase tracking-wider">Téléphone</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-white/70 uppercase tracking-wider">Inscription</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-white/70 uppercase tracking-wider">Rôle</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-white/70 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            <?php foreach ($utilisateurs as $utilisateur): ?>
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-cyan-400 to-blue-400 flex items-center justify-center text-white font-semibold">
                                                <?= strtoupper(substr($utilisateur['prenom'], 0, 1)) ?>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-white font-medium">
                                                    <?= htmlspecialchars($utilisateur['prenom'] . ' ' . $utilisateur['nom']) ?>
                                                </div>
                                                <?php if ($utilisateur['id'] === $_SESSION['user']['id']): ?>
                                                    <div class="text-cyan-400 text-xs">Vous</div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-white/80"><?= htmlspecialchars($utilisateur['email']) ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-white/80"><?= htmlspecialchars($utilisateur['numero']) ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-white/80">
                                            <?= date('d/m/Y', strtotime($utilisateur['date_inscription'])) ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            <?php 
                                            if ($utilisateur['role'] === 'super_admin') {
                                                echo 'bg-red-500/20 text-red-300 border border-red-500/30';
                                            } elseif ($utilisateur['role'] === 'admin') {
                                                echo 'bg-purple-500/20 text-purple-300 border border-purple-500/30';
                                            } else {
                                                echo 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/30';
                                            }
                                            ?>">
                                            <?php 
                                            if ($utilisateur['role'] === 'super_admin') {
                                                echo 'Super Admin';
                                            } elseif ($utilisateur['role'] === 'admin') {
                                                echo 'Admin';
                                            } else {
                                                echo 'Utilisateur';
                                            }
                                            ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <!-- Basculer le rôle -->
                                            <?php 
                                            $currentUserRole = $_SESSION['user']['role'];
                                            $targetRole = $utilisateur['role'];
                                            $canModify = $utilisateur['id'] !== $_SESSION['user']['id'] && 
                                                        ($currentUserRole === 'super_admin' || 
                                                         ($currentUserRole === 'admin' && $targetRole === 'user'));
                                            ?>
                                            
                                            <?php if ($canModify && $utilisateur['role'] !== 'super_admin'): ?>
                                                <a href="?controller=admin&action=toggleRole&id=<?= $utilisateur['id'] ?>" 
                                                   class="p-2 rounded-lg <?= $utilisateur['role'] === 'admin' ? 'bg-orange-500/20 text-orange-300 hover:bg-orange-500/30' : 'bg-green-500/20 text-green-300 hover:bg-green-500/30' ?> transition-colors inline-block"
                                                   title="<?= $utilisateur['role'] === 'admin' ? 'Rétrograder en utilisateur' : 'Promouvoir en admin' ?>"
                                                   onclick="return confirm('Êtes-vous sûr de vouloir <?= $utilisateur['role'] === 'admin' ? 'rétrograder' : 'promouvoir' ?> cet utilisateur ?')">
                                                    <?php if ($utilisateur['role'] === 'admin'): ?>
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                                        </svg>
                                                    <?php else: ?>
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                                        </svg>
                                                    <?php endif; ?>
                                                </a>
                                            <?php endif; ?>

                                            <!-- Supprimer -->
                                            <?php 
                                            $canDelete = $utilisateur['id'] !== $_SESSION['user']['id'] && 
                                                        $utilisateur['role'] !== 'super_admin' &&
                                                        ($currentUserRole === 'super_admin' || 
                                                         ($currentUserRole === 'admin' && $targetRole === 'user'));
                                            ?>
                                            
                                            <?php if ($canDelete): ?>
                                                <a href="?controller=admin&action=deleteUser&id=<?= $utilisateur['id'] ?>" 
                                                   class="p-2 rounded-lg bg-red-500/20 text-red-300 hover:bg-red-500/30 transition-colors inline-block"
                                                   title="Supprimer l'utilisateur"
                                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </a>
                                            <?php endif; ?>

                                            <!-- Voir le profil -->
                                            <a href="?controller=utilisateur&action=detail&id=<?= $utilisateur['id'] ?>" 
                                               class="p-2 rounded-lg bg-blue-500/20 text-blue-300 hover:bg-blue-500/30 transition-colors"
                                               title="Voir le profil">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
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
