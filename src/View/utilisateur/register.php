<?php 
$pageTitle = 'AquaView - Inscription';
require_once __DIR__ . '/../components/header.php';
require_once __DIR__ . '/../components/navbar.php';

$error = getError();
$success = getSuccess();
?>

<div class="relative min-h-screen text-white bg-slate-900 pt-20">
    <!-- IMAGE DE FOND AVEC ANIMATION -->
    <div class="absolute inset-0 opacity-0 animate-scale-in">
        <img src="https://images.unsplash.com/photo-1518837695005-2083093ee35b?w=1920&q=80" 
             alt="Océan" 
             class="absolute inset-0 w-full h-full object-cover" />
    </div>

    <!-- OVERLAY DÉGRADÉ -->
    <div class="absolute inset-0 opacity-0 animate-fade-in">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900/95 via-blue-900/80 to-cyan-800/70"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent"></div>
    </div>

    <!-- CONTENU -->
    <div class="relative z-10 flex items-center justify-center min-h-[calc(100vh-64px)] py-12">
        <div class="w-full max-w-md mx-4 opacity-0 animate-fade-in-up delay-300">
            <div class="p-8 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 shadow-2xl shadow-black/20">
                <!-- HEADER -->
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-light text-white mb-2">Inscription</h1>
                    <p class="text-white/60 text-sm">Créez votre compte AquaView</p>
                </div>

                <!-- MESSAGES -->
                <?php if ($error): ?>
                    <div class="p-3 rounded-lg bg-red-500/20 text-red-300 text-sm border border-red-500/30 mb-5">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="p-3 rounded-lg bg-green-500/20 text-green-300 text-sm border border-green-500/30 mb-5">
                        <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>

                <!-- FORM -->
                <form action="?controller=utilisateur&action=doRegister" method="POST" class="space-y-5">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-white/70 mb-2">Nom</label>
                            <input type="text" 
                                   name="nom" 
                                   required
                                   placeholder="Votre nom"
                                   class="w-full px-4 py-3 rounded-lg bg-slate-800/50 border border-white/10 text-white placeholder-white/40 focus:border-cyan-400 focus:outline-none transition-colors duration-300" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-white/70 mb-2">Prénom</label>
                            <input type="text" 
                                   name="prenom" 
                                   required
                                   placeholder="Votre prénom"
                                   class="w-full px-4 py-3 rounded-lg bg-slate-800/50 border border-white/10 text-white placeholder-white/40 focus:border-cyan-400 focus:outline-none transition-colors duration-300" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-2">Email</label>
                        <input type="email" 
                               name="email" 
                               required
                               placeholder="votre.email@exemple.com"
                               class="w-full px-4 py-3 rounded-lg bg-slate-800/50 border border-white/10 text-white placeholder-white/40 focus:border-cyan-400 focus:outline-none transition-colors duration-300" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-2">Numéro de téléphone</label>
                        <input type="tel" 
                               name="numero" 
                               required
                               placeholder="+33 1 23 45 67 89"
                               class="w-full px-4 py-3 rounded-lg bg-slate-800/50 border border-white/10 text-white placeholder-white/40 focus:border-cyan-400 focus:outline-none transition-colors duration-300" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-2">Mot de passe</label>
                        <input type="password" 
                               name="password" 
                               required
                               placeholder="Min 8 car., 1 Maj, 1 Chiffre"
                               class="w-full px-4 py-3 rounded-lg bg-slate-800/50 border border-white/10 text-white placeholder-white/40 focus:border-cyan-400 focus:outline-none transition-colors duration-300" />
                    </div>

                    <!-- BOUTON -->
                    <button type="submit"
                            class="w-full py-3 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold shadow-lg hover:shadow-cyan-500/50 hover:scale-[1.02] transition-all duration-300">
                        Créer mon compte
                    </button>
                </form>

                <!-- LIEN CONNEXION -->
                <div class="mt-6 text-center">
                    <p class="text-white/60 text-sm">
                        Déjà un compte ?
                        <a href="/login" class="text-cyan-400 hover:text-cyan-300 font-semibold transition-colors">
                            Se connecter
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../components/footer.php'; ?>
