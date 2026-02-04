<?php 
$pageTitle = 'AquaView - Modifier utilisateur';
require_once __DIR__ . '/../components/header.php';
require_once __DIR__ . '/../components/navbar.php';

$error = getError();
?>

<div class="relative min-h-screen text-white bg-slate-900 pt-20">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900/95 via-blue-900/85 to-cyan-800/75"></div>

    <main class="relative z-10 max-w-2xl mx-auto px-6 py-12">
        <h1 class="text-4xl font-light mb-8">Modifier l'utilisateur</h1>

        <?php if ($error): ?>
            <div class="p-4 rounded-lg bg-red-500/20 text-red-300 border border-red-500/30 mb-6"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="p-8 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10">
            <form action="?controller=utilisateur&action=update&id=<?= $utilisateur['id'] ?>" method="POST" class="space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-2">Nom</label>
                        <input type="text" name="nom" required value="<?= htmlspecialchars($utilisateur['nom']) ?>"
                               class="w-full px-4 py-3 rounded-lg bg-slate-800/50 border border-white/10 text-white focus:border-cyan-400 focus:outline-none transition-colors" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-2">Prénom</label>
                        <input type="text" name="prenom" required value="<?= htmlspecialchars($utilisateur['prenom']) ?>"
                               class="w-full px-4 py-3 rounded-lg bg-slate-800/50 border border-white/10 text-white focus:border-cyan-400 focus:outline-none transition-colors" />
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-white/70 mb-2">Email</label>
                    <input type="email" name="email" required value="<?= htmlspecialchars($utilisateur['email']) ?>"
                           class="w-full px-4 py-3 rounded-lg bg-slate-800/50 border border-white/10 text-white focus:border-cyan-400 focus:outline-none transition-colors" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-white/70 mb-2">Numéro</label>
                    <input type="tel" name="numero" required value="<?= htmlspecialchars($utilisateur['numero']) ?>"
                           class="w-full px-4 py-3 rounded-lg bg-slate-800/50 border border-white/10 text-white focus:border-cyan-400 focus:outline-none transition-colors" />
                </div>
                <div class="flex gap-4">
                    <button type="submit" class="flex-1 py-3 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold hover:shadow-lg hover:shadow-cyan-500/50 transition-all">
                        Enregistrer
                    </button>
                    <a href="?controller=utilisateur&action=list" class="px-6 py-3 rounded-lg bg-white/10 border border-white/20 text-white hover:bg-white/20 transition-all text-center">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../components/footer.php'; ?>
