<?php 
$pageTitle = 'AquaView - Liste des voitures';
require_once __DIR__ . '/../components/header.php';
require_once __DIR__ . '/../components/navbar.php';

$error = getError();
$success = getSuccess();
?>

<div class="relative min-h-screen text-white bg-slate-900 pt-20">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900/95 via-blue-900/85 to-cyan-800/75"></div>

    <main class="relative z-10 max-w-7xl mx-auto px-6 py-12">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-light">Liste des Voitures</h1>
            <a href="?controller=voiture&action=create" 
               class="px-6 py-3 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold hover:shadow-lg hover:shadow-cyan-500/50 transition-all duration-300">
                Ajouter une voiture
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
                        <th class="px-6 py-4 text-left text-sm font-medium text-white/70">Marque</th>
                        <th class="px-6 py-4 text-left text-sm font-medium text-white/70">Modèle</th>
                        <th class="px-6 py-4 text-left text-sm font-medium text-white/70">Année</th>
                        <th class="px-6 py-4 text-left text-sm font-medium text-white/70">Prix</th>
                        <th class="px-6 py-4 text-right text-sm font-medium text-white/70">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    <?php if (empty($voitures)): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-white/50">Aucune voiture trouvée</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($voitures as $voiture): ?>
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 text-white"><?= $voiture['id'] ?></td>
                                <td class="px-6 py-4 text-white"><?= htmlspecialchars($voiture['marque']) ?></td>
                                <td class="px-6 py-4 text-white"><?= htmlspecialchars($voiture['modele']) ?></td>
                                <td class="px-6 py-4 text-white"><?= $voiture['annee'] ?></td>
                                <td class="px-6 py-4 text-cyan-400"><?= number_format($voiture['prix'], 2, ',', ' ') ?> €</td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="?controller=voiture&action=detail&id=<?= $voiture['id'] ?>" class="text-cyan-400 hover:text-cyan-300">Voir</a>
                                    <a href="?controller=voiture&action=update&id=<?= $voiture['id'] ?>" class="text-blue-400 hover:text-blue-300">Modifier</a>
                                    <a href="?controller=voiture&action=delete&id=<?= $voiture['id'] ?>" class="text-red-400 hover:text-red-300" onclick="return confirm('Supprimer cette voiture ?')">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../components/footer.php'; ?>
