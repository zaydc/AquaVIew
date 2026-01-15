<?php 
$pageTitle = 'AquaView - Mon Profil';
require_once __DIR__ . '/../components/header.php';
require_once __DIR__ . '/../components/navbar.php';

$error = getError();
$success = getSuccess();
?>

<div class="relative min-h-screen text-white bg-slate-900 pt-20">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900/95 via-blue-900/85 to-cyan-800/75"></div>

    <main class="relative z-10 max-w-6xl mx-auto px-6 py-12">
        <!-- En-tête épuré -->
        <div class="mb-12">
            <h1 class="text-4xl font-light mb-2">Mon Profil</h1>
            <p class="text-white/60">Gérez vos informations et consultez vos analyses océaniques</p>
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
                </div>

                <!-- Carte analyses -->
                <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-2xl p-8">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-2xl font-semibold text-green-300">Mes analyses</h2>
                        <a href="?action=analyse" class="text-cyan-400 hover:text-cyan-300 font-medium text-sm transition-colors">
                            Nouvelle analyse →
                        </a>
                    </div>
                    
                    <?php if (empty($recentAnalyses)): ?>
                        <div class="text-center py-12">
                            <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-4 border border-white/10">
                                <svg class="w-10 h-10 text-cyan-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-white mb-2">Aucune analyse</h3>
                            <p class="text-white/50 mb-6">Commencez à explorer les données océaniques</p>
                            <a href="?action=analyse" class="inline-flex items-center px-6 py-3 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-medium hover:from-cyan-600 hover:to-blue-600 transition-all shadow-lg shadow-cyan-500/30">
                                Commencer une analyse
                            </a>
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
                                    <label class="block text-sm font-medium text-red-300 mb-2">Mot de passe requis</label>
                                    <input type="password" name="password" required 
                                           placeholder="Entrez votre mot de passe"
                                           class="w-full px-4 py-3 rounded-xl bg-white/5 border border-red-500/30 text-white placeholder-red-400/50 focus:border-red-400 focus:ring-2 focus:ring-red-400/20 transition-all" />
                                </div>
                                <button type="submit" class="w-full py-3 rounded-xl bg-red-600 text-white font-medium hover:bg-red-700 transition-colors shadow-lg shadow-red-500/30">
                                    Supprimer mon compte
                                </button>
                            </form>
                        </div>

                        <!-- Actions rapides -->
                        <div class="pt-6 border-t border-white/10">
                            <h3 class="font-medium text-white mb-4">Actions rapides</h3>
                            <div class="space-y-3">
                                <a href="?action=analyse" class="block w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white/70 hover:bg-white/10 hover:border-white/20 hover:text-white transition-all text-center">
                                    📊 Nouvelle analyse
                                </a>
                                <a href="/" class="block w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white/70 hover:bg-white/10 hover:border-white/20 hover:text-white transition-all text-center">
                                    🏠 Retour à l'accueil
                                </a>
                                <a href="?controller=utilisateur&action=logout" class="block w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white/70 hover:bg-white/10 hover:border-white/20 hover:text-white transition-all text-center">
                                    🚪 Déconnexion
                                </a>
                            </div>
                        </div>

                        <!-- Modification du mot de passe -->
                        <div class="pt-6 border-t border-white/10">
                            <h3 class="font-medium text-white mb-4">Modifier le mot de passe</h3>
                            
                            <form action="?controller=utilisateur&action=doUpdatePassword" method="POST" class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-white/70 mb-2">Ancien mot de passe</label>
                                    <input type="password" name="old_password" required 
                                           placeholder="Entrez votre ancien mot de passe"
                                           class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-white/50 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 transition-all" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-white/70 mb-2">Nouveau mot de passe</label>
                                    <input type="password" name="new_password" required 
                                           placeholder="Entrez votre nouveau mot de passe"
                                           class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-white/50 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 transition-all" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-white/70 mb-2">Confirmer le nouveau mot de passe</label>
                                    <input type="password" name="confirm_password" required 
                                           placeholder="Confirmez votre nouveau mot de passe"
                                           class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-white/50 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 transition-all" />
                                </div>
                                <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-medium hover:from-cyan-600 hover:to-blue-600 transition-all shadow-lg shadow-cyan-500/30">
                                    Mettre à jour le mot de passe
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../components/footer.php'; ?>
