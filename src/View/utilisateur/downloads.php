<?php 
$pageTitle = 'AquaView - Mes Téléchargements';
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
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-light mb-2">Mes Téléchargements</h1>
                    <p class="text-white/60">Historique complet de vos exports de données</p>
                </div>
                <a href="?controller=utilisateur&action=profile" 
                   class="inline-flex items-center px-6 py-3 rounded-xl bg-gradient-to-r from-purple-500 to-blue-500 text-white font-medium hover:from-purple-600 hover:to-blue-600 transition-all shadow-lg shadow-purple-500/30">
                    ← Retour au profil
                </a>
            </div>
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

        <?php if (empty($allDownloads)): ?>
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6 border border-white/10">
                    <svg class="w-12 h-12 text-purple-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-medium text-white mb-3">Aucun téléchargement</h2>
                <p class="text-white/50 text-lg mb-8">Vous n'avez pas encore exporté de données</p>
                <a href="?action=analyse" 
                   class="inline-flex items-center px-8 py-4 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-medium hover:from-cyan-600 hover:to-blue-600 transition-all shadow-lg shadow-cyan-500/30">
                    Commencer une analyse
                </a>
            </div>
        <?php else: ?>
            <!-- Statistiques des téléchargements -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="text-center p-6 rounded-xl bg-white/5 border border-white/10">
                    <div class="text-3xl font-bold text-purple-300"><?= count($allDownloads) ?></div>
                    <div class="text-sm text-white/50 mt-1">Téléchargements totaux</div>
                </div>
                <div class="text-center p-6 rounded-xl bg-white/5 border border-white/10">
                    <div class="text-3xl font-bold text-blue-300">
                        <?= array_sum(array_column($allDownloads, 'record_count')) ?>
                    </div>
                    <div class="text-sm text-white/50 mt-1">Enregistrements totaux</div>
                </div>
                <div class="text-center p-6 rounded-xl bg-white/5 border border-white/10">
                    <div class="text-3xl font-bold text-cyan-300">
                        <?= formatFileSize(array_sum(array_column($allDownloads, 'file_size'))) ?>
                    </div>
                    <div class="text-sm text-white/50 mt-1">Espace total utilisé</div>
                </div>
                <div class="text-center p-6 rounded-xl bg-white/5 border border-white/10">
                    <div class="text-3xl font-bold text-green-300">
                        <?= count(array_unique(array_column($allDownloads, 'format'))) ?>
                    </div>
                    <div class="text-sm text-white/50 mt-1">Formats différents</div>
                </div>
            </div>

            <!-- Liste des téléchargements -->
            <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-2xl p-8">
                <h2 class="text-2xl font-semibold text-purple-300 mb-8">Historique complet</h2>
                
                <div class="space-y-4 max-h-96 overflow-y-auto">
                    <?php foreach ($allDownloads as $download): ?>
                        <div class="p-6 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center border border-purple-500/30">
                                        <?php
                                        $iconClass = '';
                                        switch($download['format']) {
                                            case 'csv':
                                                $iconClass = '📊';
                                                break;
                                            case 'json':
                                                $iconClass = '📄';
                                                break;
                                            case 'pdf':
                                                $iconClass = '📋';
                                                break;
                                            default:
                                                $iconClass = '📁';
                                        }
                                        ?>
                                        <span class="text-xl"><?= $iconClass ?></span>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-white text-lg mb-1">
                                            <?= htmlspecialchars($download['metric']) ?> - <?= strtoupper($download['format']) ?>
                                        </h3>
                                        <p class="text-sm text-white/50">
                                            <?= date('d F Y à H:i', strtotime($download['created_at'])) ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs text-white/40 mb-1">Taille</div>
                                    <div class="text-lg font-semibold text-white">
                                        <?= formatFileSize($download['file_size']) ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between text-sm text-white/60">
                                <div class="flex items-center gap-6">
                                    <span>📊 <?= $download['record_count'] ?> enregistrements</span>
                                    <span>📅 <?= $download['date_range'] ?></span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <?php if (!empty($download['file_path'])): ?>
                                        <a href="<?= htmlspecialchars($download['file_path']) ?>" 
                                           class="px-4 py-2 rounded-lg bg-purple-500/20 border border-purple-500/30 text-purple-300 hover:bg-purple-500/30 hover:border-purple-500/40 transition-all font-medium"
                                           download>
                                            📥 Télécharger
                                        </a>
                                    <?php endif; ?>
                                    <button onclick="confirmDelete(<?= $download['id'] ?>)" 
                                            class="px-4 py-2 rounded-lg bg-red-500/20 border border-red-500/30 text-red-300 hover:bg-red-500/30 hover:border-red-500/40 transition-all font-medium">
                                        🗑️ Supprimer
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </main>
</div>

<script>
function confirmDelete(downloadId) {
    if (confirm('Êtes-vous certain de vouloir supprimer ce téléchargement ?')) {
        window.location.href = '?controller=utilisateur&action=deleteDownload&id=' + downloadId;
    }
}
</script>

<?php require_once __DIR__ . '/../components/footer.php'; ?>
