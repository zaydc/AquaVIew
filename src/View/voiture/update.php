<?php 
$pageTitle = 'AquaView - Modifier voiture';
require_once __DIR__ . '/../components/header.php';
require_once __DIR__ . '/../components/navbar.php';

$error = getError();
?>

<div class="relative min-h-screen text-white bg-slate-900 pt-20">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900/95 via-blue-900/85 to-cyan-800/75"></div>

    <main class="relative z-10 max-w-2xl mx-auto px-6 py-12">
        <h1 class="text-4xl font-light mb-8">Modifier la voiture</h1>

        <?php if ($error): ?>
            <div class="p-4 rounded-lg bg-red-500/20 text-red-300 border border-red-500/30 mb-6"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="p-8 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10">
            <form action="?controller=voiture&action=update&id=<?= $voiture['id'] ?>" method="POST" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-white/70 mb-2">Marque</label>
                    <input type="text" name="marque" required value="<?= htmlspecialchars($voiture['marque']) ?>"
                           class="w-full px-4 py-3 rounded-lg bg-slate-800/50 border border-white/10 text-white focus:border-cyan-400 focus:outline-none transition-colors" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-white/70 mb-2">Modèle</label>
                    <input type="text" name="modele" required value="<?= htmlspecialchars($voiture['modele']) ?>"
                           class="w-full px-4 py-3 rounded-lg bg-slate-800/50 border border-white/10 text-white focus:border-cyan-400 focus:outline-none transition-colors" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-white/70 mb-2">Année</label>
                    <input type="number" name="annee" required value="<?= $voiture['annee'] ?>"
                           class="w-full px-4 py-3 rounded-lg bg-slate-800/50 border border-white/10 text-white focus:border-cyan-400 focus:outline-none transition-colors" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-white/70 mb-2">Prix (€)</label>
                    <input type="number" name="prix" required step="0.01" value="<?= $voiture['prix'] ?>"
                           class="w-full px-4 py-3 rounded-lg bg-slate-800/50 border border-white/10 text-white focus:border-cyan-400 focus:outline-none transition-colors" />
                </div>
                <div class="flex gap-4">
                    <button type="submit" class="flex-1 py-3 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold hover:shadow-lg hover:shadow-cyan-500/50 transition-all">
                        Enregistrer
                    </button>
                    <a href="?controller=voiture&action=list" class="px-6 py-3 rounded-lg bg-white/10 border border-white/20 text-white hover:bg-white/20 transition-all text-center">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../components/footer.php'; ?>
