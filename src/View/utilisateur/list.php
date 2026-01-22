<?php 
$pageTitle = 'AquaView - Liste des utilisateurs';
require_once __DIR__ . '/../components/header.php';
require_once __DIR__ . '/../components/navbar.php';

$error = getError();
$success = getSuccess();
?>

<div class="relative min-h-screen text-white bg-slate-900 pt-20">
    <!-- Arrière-plan avec image oceanique et overlay -->
    <div class="fixed inset-0 z-0">
        <div id="global-bg" class="absolute inset-0 transition-all duration-[2500ms] ease-out opacity-0 scale-110">
            <!-- Image d'ocean depuis Unsplash -->
            <img src="https://images.unsplash.com/photo-1518837695005-2083093ee35b?w=1920&q=80" alt="Ocean" class="w-full h-full object-cover" />
        </div>
        <!-- Overlay sombre pour la lisibilite du texte -->
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/80 via-slate-900/60 to-slate-900"></div>
    </div>

    <main class="relative z-10 max-w-7xl mx-auto px-6 py-12">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-light">Liste des Utilisateurs</h1>
            <a href="?controller=utilisateur&action=create" 
               class="px-6 py-3 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold hover:shadow-lg hover:shadow-cyan-500/50 transition-all duration-300">
                Ajouter un utilisateur
            </a>
        </div>

        <?php if ($error): ?>
            <div class="p-4 rounded-lg bg-red-500/20 text-red-300 border border-red-500/30 mb-6"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="p-4 rounded-lg bg-green-500/20 text-green-300 border border-green-500/30 mb-6"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 overflow-hidden">
            <table class="w-full">
                <thead class="bg-white/5">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-medium text-white/70">ID</th>
                        <th class="px-6 py-4 text-left text-sm font-medium text-white/70">Nom</th>
                        <th class="px-6 py-4 text-left text-sm font-medium text-white/70">Prénom</th>
                        <th class="px-6 py-4 text-left text-sm font-medium text-white/70">Email</th>
                        <th class="px-6 py-4 text-left text-sm font-medium text-white/70">Numéro</th>
                        <th class="px-6 py-4 text-right text-sm font-medium text-white/70">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    <?php if (empty($utilisateurs)): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-white/50">Aucun utilisateur trouvé</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($utilisateurs as $u): ?>
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 text-white"><?= $u['id'] ?></td>
                                <td class="px-6 py-4 text-white"><?= htmlspecialchars($u['nom']) ?></td>
                                <td class="px-6 py-4 text-white"><?= htmlspecialchars($u['prenom']) ?></td>
                                <td class="px-6 py-4 text-cyan-400"><?= htmlspecialchars($u['email']) ?></td>
                                <td class="px-6 py-4 text-white"><?= htmlspecialchars($u['numero']) ?></td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="?controller=utilisateur&action=detail&id=<?= $u['id'] ?>" class="text-cyan-400 hover:text-cyan-300">Voir</a>
                                    <a href="?controller=utilisateur&action=update&id=<?= $u['id'] ?>" class="text-blue-400 hover:text-blue-300">Modifier</a>
                                    <a href="?controller=utilisateur&action=delete&id=<?= $u['id'] ?>" class="text-red-400 hover:text-red-300" onclick="return confirm('Supprimer cet utilisateur ?')">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<!-- Script pour l'animation du fond -->
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

<?php require_once __DIR__ . '/../components/footer.php'; ?>
