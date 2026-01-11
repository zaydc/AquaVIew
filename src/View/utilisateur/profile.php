<?php 
$pageTitle = 'AquaView - Mon Profil';
require_once __DIR__ . '/../components/header.php';
require_once __DIR__ . '/../components/navbar.php';

$error = getError();
$success = getSuccess();
?>

<div class="relative min-h-screen text-white bg-slate-900 pt-20">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900/95 via-blue-900/85 to-cyan-800/75"></div>

    <main class="relative z-10 max-w-4xl mx-auto px-6 py-12">
        <h1 class="text-4xl font-light mb-8">Mon Profil</h1>

        <?php if ($error): ?>
            <div class="p-4 rounded-lg bg-red-500/20 text-red-300 border border-red-500/30 mb-6"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="p-4 rounded-lg bg-green-500/20 text-green-300 border border-green-500/30 mb-6"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Section Modification du profil -->
            <div class="p-8 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10">
                <h2 class="text-2xl font-semibold mb-6 text-cyan-400">Modifier mes informations</h2>
                
                <form action="?controller=utilisateur&action=doUpdateProfile" method="POST" class="space-y-6">
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
                        <label class="block text-sm font-medium text-white/70 mb-2">Numéro de téléphone</label>
                        <input type="tel" name="numero" required value="<?= htmlspecialchars($utilisateur['numero']) ?>"
                               class="w-full px-4 py-3 rounded-lg bg-slate-800/50 border border-white/10 text-white focus:border-cyan-400 focus:outline-none transition-colors" />
                    </div>
                    <div class="text-sm text-white/50">
                        <p>Date d'inscription : <?= date('d/m/Y', strtotime($utilisateur['date_inscription'])) ?></p>
                    </div>
                    <button type="submit" class="w-full py-3 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold hover:shadow-lg hover:shadow-cyan-500/50 transition-all">
                        Mettre à jour mon profil
                    </button>
                </form>
            </div>

            <!-- Section Suppression du compte -->
            <div class="p-8 rounded-2xl backdrop-blur-xl bg-white/5 border border-red-500/20">
                <h2 class="text-2xl font-semibold mb-6 text-red-400">Zone de danger</h2>
                
                <div class="space-y-6">
                    <div class="p-4 rounded-lg bg-red-500/10 border border-red-500/30">
                        <h3 class="font-semibold text-red-300 mb-2">⚠️ Suppression du compte</h3>
                        <p class="text-white/70 text-sm mb-4">
                            La suppression de votre compte est <strong>irréversible</strong>. 
                            Toutes vos données seront définitivement perdues.
                        </p>
                        <p class="text-white/70 text-sm mb-4">
                            Pour confirmer la suppression, vous devrez saisir votre mot de passe actuel.
                        </p>
                    </div>

                    <form action="?controller=utilisateur&action=doDeleteAccount" method="POST" 
                          onsubmit="return confirm('Êtes-vous absolument certain de vouloir supprimer votre compte ? Cette action ne peut pas être annulée.');"
                          class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-white/70 mb-2">Confirmez avec votre mot de passe</label>
                            <input type="password" name="password" required 
                                   placeholder="Entrez votre mot de passe pour confirmer"
                                   class="w-full px-4 py-3 rounded-lg bg-slate-800/50 border border-red-500/30 text-white focus:border-red-400 focus:outline-none transition-colors" />
                        </div>
                        <button type="submit" class="w-full py-3 rounded-lg bg-gradient-to-r from-red-600 to-red-700 text-white font-semibold hover:shadow-lg hover:shadow-red-500/50 transition-all border border-red-500/30">
                            Supprimer définitivement mon compte
                        </button>
                    </form>

                    <div class="pt-4 border-t border-white/10">
                        <a href="/" class="inline-flex items-center text-cyan-400 hover:text-cyan-300 transition-colors">
                            ← Revenir à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../components/footer.php'; ?>
