<!-- 
    Page profil utilisateur d'AquaView
    BUT2 - S3 - AquaView Project
    Page personnelle pour gérer les informations utilisateur
-->
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AquaView - Mon Profil</title>
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

<?php 
require_once __DIR__ . '/../../Lib/helpers.php';
$error = getError();
$success = getSuccess();
?>

<div class="min-h-screen pt-24 px-4 pb-12 flex justify-center">
    <div class="w-full max-w-5xl px-6 md:px-10">
        <!-- En-tête épuré -->
        <div class="mb-12">
            <?php 
            $isOwnProfile = isset($_SESSION['user']['id']) && $utilisateur['id'] == $_SESSION['user']['id'];
            $pageTitle = $isOwnProfile ? 'Mon Profil' : 'Profil de ' . htmlspecialchars($utilisateur['prenom'] . ' ' . $utilisateur['nom']);
            $pageSubtitle = $isOwnProfile ? 'Gérez vos informations et consultez vos analyses océaniques' : 'Consultez les informations et les analyses océaniques de cet utilisateur';
            ?>
            <h1 class="text-4xl font-light mb-2"><?= $pageTitle ?></h1>
            <p class="text-white/60"><?= $pageSubtitle ?></p>
        </div>

        <?php if ($error): ?>
            <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-300">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="mb-6 p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-green-300">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Section Informations personnelles -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Carte profil -->
                <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-2xl p-8">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-2xl font-semibold text-cyan-300">Informations personnelles</h2>
                        <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-full flex items-center justify-center text-white font-semibold shadow-lg shadow-cyan-500/30">
                            <?= strtoupper(substr($utilisateur['prenom'], 0, 1)) . strtoupper(substr($utilisateur['nom'], 0, 1)) ?>
                        </div>
                    </div>
                    
                    <?php if ($isOwnProfile): ?>
                    <form action="?controller=utilisateur&action=doUpdateProfile" method="POST" class="space-y-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-white/70 mb-2">Nom</label>
                                <input type="text" name="nom" required value="<?= htmlspecialchars($utilisateur['nom']) ?>"
                                       class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 transition-all" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white/70 mb-2">Prénom</label>
                                <input type="text" name="prenom" required value="<?= htmlspecialchars($utilisateur['prenom']) ?>"
                                       class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 transition-all" />
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-white/70 mb-2">Email</label>
                            <input type="email" name="email" required value="<?= htmlspecialchars($utilisateur['email']) ?>"
                                   class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 transition-all" />
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-white/70 mb-2">Numéro de téléphone</label>
                            <input type="tel" name="numero" required value="<?= htmlspecialchars($utilisateur['numero']) ?>"
                                   class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 transition-all" />
                        </div>
                        
                        <div class="pt-6 border-t border-white/10">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-white/50">
                                    <p>Membre depuis le <?= date('d F Y', strtotime($utilisateur['date_inscription'])) ?></p>
                                </div>
                                <button type="submit" class="px-8 py-3 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-medium hover:from-cyan-600 hover:to-blue-600 transition-all transform hover:scale-105 shadow-lg shadow-cyan-500/30">
                                    Mettre à jour
                                </button>
                            </div>
                        </div>
                    </form>
                <?php else: ?>
                    <!-- Affichage en lecture seule pour l'admin -->
                    <div class="space-y-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-white/70 mb-2">Nom</label>
                                <div class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white/80">
                                    <?= htmlspecialchars($utilisateur['nom']) ?>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white/70 mb-2">Prénom</label>
                                <div class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white/80">
                                    <?= htmlspecialchars($utilisateur['prenom']) ?>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-white/70 mb-2">Email</label>
                            <div class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white/80">
                                <?= htmlspecialchars($utilisateur['email']) ?>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-white/70 mb-2">Numéro de téléphone</label>
                            <div class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white/80">
                                <?= htmlspecialchars($utilisateur['numero']) ?>
                            </div>
                        </div>
                        
                        <div class="pt-6 border-t border-white/10">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-white/50">
                                    <p>Membre depuis le <?= date('d F Y', strtotime($utilisateur['date_inscription'])) ?></p>
                                </div>
                                <a href="?controller=admin&action=users" class="px-8 py-3 rounded-xl bg-white/10 border border-white/20 text-white font-medium hover:bg-white/20 transition-all">
                                    ← Retour à la liste
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                </div>

                <!-- Carte analyses -->
                <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-2xl p-8">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-2xl font-semibold text-green-300"><?= $isOwnProfile ? 'Mes analyses' : 'Analyses de ' . htmlspecialchars($utilisateur['prenom']) ?></h2>
                        <?php if ($isOwnProfile): ?>
                            <a href="?action=analyse" class="text-cyan-400 hover:text-cyan-300 font-medium text-sm transition-colors">
                                Nouvelle analyse →
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (empty($recentAnalyses)): ?>
                        <div class="text-center py-12">
                            <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-4 border border-white/10">
                                <svg class="w-10 h-10 text-cyan-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-white mb-2">Aucune analyse</h3>
                            <p class="text-white/50 mb-6"><?= $isOwnProfile ? 'Commencez à explorer les données océaniques' : htmlspecialchars($utilisateur['prenom']) . ' n\'a pas encore effectué d\'analyse' ?></p>
                            <?php if ($isOwnProfile): ?>
                                <a href="?action=analyse" class="inline-flex items-center px-6 py-3 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-medium hover:from-cyan-600 hover:to-blue-600 transition-all shadow-lg shadow-cyan-500/30">
                                    Commencer une analyse
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <!-- Statistiques -->
                        <div class="grid grid-cols-3 gap-6 mb-8">
                            <div class="text-center p-4 rounded-xl bg-white/5 border border-white/10">
                                <div class="text-3xl font-bold text-cyan-300"><?= $userStats['total_analyses'] ?? 0 ?></div>
                                <div class="text-sm text-white/50 mt-1">Analyses totales</div>
                            </div>
                            <div class="text-center p-4 rounded-xl bg-white/5 border border-white/10">
                                <div class="text-3xl font-bold text-blue-300"><?= $userStats['unique_metrics'] ?? 0 ?></div>
                                <div class="text-sm text-white/50 mt-1">Métriques étudiées</div>
                            </div>
                            <div class="text-center p-4 rounded-xl bg-white/5 border border-white/10">
                                <div class="text-3xl font-bold text-green-300"><?= $userStats['avg_measures_per_analysis'] ? round($userStats['avg_measures_per_analysis']) : 0 ?></div>
                                <div class="text-sm text-white/50 mt-1">Mesures moyennes</div>
                            </div>
                        </div>

                        <!-- Liste des analyses -->
                        <div class="space-y-4 max-h-96 overflow-y-auto">
                            <?php foreach ($recentAnalyses as $analysis): ?>
                                <div class="p-6 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-cyan-500/20 rounded-xl flex items-center justify-center border border-cyan-500/30">
                                                <span class="text-cyan-300 font-semibold text-sm">
                                                    <?= strtoupper(substr(getMetricLabel($analysis['metric']), 0, 2)) ?>
                                                </span>
                                            </div>
                                            <div>
                                                <h3 class="font-medium text-white"><?= getMetricLabel($analysis['metric']) ?></h3>
                                                <p class="text-sm text-white/50"><?= date('d F Y', strtotime($analysis['created_at'])) ?></p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-2xl font-semibold text-white">
                                                <?= number_format($analysis['avg_value'], 2) ?>
                                                <span class="text-sm text-white/50 font-normal"><?= getMetricUnit($analysis['metric']) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center justify-between text-sm text-white/60">
                                        <div class="flex items-center gap-6">
                                            <span>Min: <?= number_format($analysis['min_value'], 2) ?></span>
                                            <span>Max: <?= number_format($analysis['max_value'], 2) ?></span>
                                            <span><?= $analysis['count_measures'] ?> mesures</span>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <span class="text-xs text-white/40">
                                                <?= date('d/m/Y', strtotime($analysis['start_date'])) ?> - <?= date('d/m/Y', strtotime($analysis['end_date'])) ?>
                                            </span>
                                            <a href="?action=analyse&metric=<?= urlencode($analysis['metric']) ?>&start_date=<?= date('Y-m-d', strtotime($analysis['start_date'])) ?>&end_date=<?= date('Y-m-d', strtotime($analysis['end_date'])) ?>" 
                                               class="text-cyan-400 hover:text-cyan-300 font-medium text-xs transition-colors">
                                                Revoir l'analyse →
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Section Paramètres -->
            <?php if ($isOwnProfile): ?>
            <div class="lg:col-span-1">
                <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-2xl p-8">
                    <h2 class="text-2xl font-semibold text-white mb-8">Paramètres</h2>
                    
                    <div class="space-y-6">
                        <!-- Zone de danger -->
                        <div class="p-6 rounded-xl bg-red-500/10 border border-red-500/20">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 bg-red-500/20 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-red-300">Supprimer le compte</h3>
                            </div>
                            
                            <p class="text-sm text-red-200 mb-4">
                                Cette action est <strong>irréversible</strong>. Toutes vos données seront définitivement perdues.
                            </p>

                            <form action="?controller=utilisateur&action=doDeleteAccount" method="POST" 
                                  onsubmit="return confirm('Êtes-vous absolument certain de vouloir supprimer votre compte ? Cette action ne peut pas être annulée.');"
                                  class="space-y-4">
                                <div>
                                    <label class="block text-xs font-medium text-red-300 mb-2">Mot de passe requis</label>
                                    <input type="password" name="password" required 
                                           placeholder="Entrez votre mot de passe"
                                           class="w-full px-4 py-3 rounded-xl bg-white/5 border border-red-500/30 text-white placeholder-red-400/50 focus:border-red-400 focus:ring-2 focus:ring-red-400/20 transition-all" />
                                </div>
                                <button type="submit" class="w-full py-3 rounded-xl bg-red-600 text-white font-medium hover:bg-red-700 transition-colors shadow-lg shadow-red-500/30">
                                    Supprimer mon compte
                                </button>
                            </form>
                        </div>

                        <!-- Modification du mot de passe -->
                        <div class="pt-6 border-t border-white/10">
                            <h3 class="font-medium text-white mb-4">Modifier le mot de passe</h3>
                            
                            <form action="?controller=utilisateur&action=doUpdatePassword" method="POST" class="space-y-4">
                                <div class="relative">
                                    <label class="block text-sm font-medium text-white/70 mb-2">Ancien mot de passe</label>
                                    <input type="password" id="old_password" name="old_password" required 
                                           placeholder="Entrez votre ancien mot de passe"
                                           class="w-full px-4 py-3 pr-12 rounded-xl bg-white/5 border border-white/10 text-white placeholder-white/50 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 transition-all" />
                                    <button type="button" onclick="togglePassword('old_password')" 
                                            class="absolute right-3 top-10 text-white/50 hover:text-white/70 transition-colors">
                                        <svg id="old_password_icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="relative">
                                    <label class="block text-sm font-medium text-white/70 mb-2">Nouveau mot de passe</label>
                                    <input type="password" id="new_password" name="new_password" required 
                                           placeholder="Entrez votre nouveau mot de passe"
                                           class="w-full px-4 py-3 pr-12 rounded-xl bg-white/5 border border-white/10 text-white placeholder-white/50 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 transition-all" />
                                    <button type="button" onclick="togglePassword('new_password')" 
                                            class="absolute right-3 top-10 text-white/50 hover:text-white/70 transition-colors">
                                        <svg id="new_password_icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="relative">
                                    <label class="block text-sm font-medium text-white/70 mb-2">Confirmer le nouveau mot de passe</label>
                                    <input type="password" id="confirm_password" name="confirm_password" required 
                                           placeholder="Confirmez votre nouveau mot de passe"
                                           class="w-full px-4 py-3 pr-12 rounded-xl bg-white/5 border border-white/10 text-white placeholder-white/50 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 transition-all" />
                                    <button type="button" onclick="togglePassword('confirm_password')" 
                                            class="absolute right-3 top-10 text-white/50 hover:text-white/70 transition-colors">
                                        <svg id="confirm_password_icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                                <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-medium hover:from-cyan-600 hover:to-blue-600 transition-all shadow-lg shadow-cyan-500/30">
                                    Mettre à jour le mot de passe
                                </button>
                            </form>
                        </div>
                    </div>
        </div>
            <?php endif; ?>
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

    <!-- Script pour la gestion des mots de passe -->
    <script>
    function togglePassword(fieldId) {
        const passwordField = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '_icon');
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            // Changer l'icône pour œil barré (masqué)
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
            `;
        } else {
            passwordField.type = 'password';
            // Remettre l'icône œil (visible)
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
        }
    }
    </script>

    <!-- Inclusion du footer -->
    <?php include __DIR__ . '/../components/footer.php'; ?>
</body>
</html>
