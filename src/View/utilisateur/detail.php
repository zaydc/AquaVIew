<?php 
$pageTitle = 'AquaView - Détail utilisateur';
require_once __DIR__ . '/../components/header.php';
require_once __DIR__ . '/../components/navbar.php';
?>

<div class="relative min-h-screen text-white bg-slate-900 pt-20">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900/95 via-blue-900/85 to-cyan-800/75"></div>

    <main class="relative z-10 max-w-2xl mx-auto px-6 py-12">
        <h1 class="text-4xl font-light mb-8">Détail de l'utilisateur</h1>

        <div class="p-8 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 space-y-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <span class="text-sm text-white/50">Nom</span>
                    <p class="text-xl text-white"><?= htmlspecialchars($utilisateur['nom']) ?></p>
                </div>
                <div>
                    <span class="text-sm text-white/50">Prénom</span>
                    <p class="text-xl text-white"><?= htmlspecialchars($utilisateur['prenom']) ?></p>
                </div>
                <div>
                    <span class="text-sm text-white/50">Email</span>
                    <p class="text-xl text-cyan-400"><?= htmlspecialchars($utilisateur['email']) ?></p>
                </div>
                <div>
                    <span class="text-sm text-white/50">Numéro</span>
                    <p class="text-xl text-white"><?= htmlspecialchars($utilisateur['numero']) ?></p>
                </div>
            </div>
            
            <div class="flex gap-4 pt-6 border-t border-white/10">
                <a href="?controller=utilisateur&action=update&id=<?= $utilisateur['id'] ?>" class="flex-1 py-3 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold text-center hover:shadow-lg hover:shadow-cyan-500/50 transition-all">
                    Modifier
                </a>
                <a href="?controller=utilisateur&action=list" class="px-6 py-3 rounded-lg bg-white/10 border border-white/20 text-white hover:bg-white/20 transition-all text-center">
                    Retour
                </a>
            </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../components/footer.php'; ?>
