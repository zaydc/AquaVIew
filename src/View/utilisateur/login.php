<?php 
$pageTitle = 'AquaView - Connexion';
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
    <div class="relative z-10 flex items-center justify-center min-h-[calc(100vh-64px)]">
        <div class="w-full max-w-md mx-4 opacity-0 animate-fade-in-up delay-300">
            <div class="p-8 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 shadow-2xl shadow-black/20">
                <!-- HEADER -->
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-light text-white mb-2">Connexion</h1>
                    <p class="text-white/60 text-sm">Accédez à votre compte AquaView</p>
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
                <form action="?controller=utilisateur&action=doLogin" method="POST" class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-2">Email</label>
                        <input type="email" 
                               name="email" 
                               required
                               placeholder="votre.email@exemple.com"
                               class="w-full px-4 py-3 rounded-lg bg-slate-800/50 border border-white/10 text-white placeholder-white/40 focus:border-cyan-400 focus:outline-none transition-colors duration-300" />
                    </div>

                    <div class="relative">
                        <label class="block text-sm font-medium text-white/70 mb-2">Mot de passe</label>
                        <input type="password" 
                               id="password"
                               name="password" 
                               required
                               placeholder="•••••••"
                               class="w-full px-4 py-3 pr-12 rounded-lg bg-slate-800/50 border border-white/10 text-white placeholder-white/40 focus:border-cyan-400 focus:outline-none transition-colors duration-300" />
                        <button type="button" onclick="togglePassword('password')" 
                                class="absolute right-3 top-10 text-white/50 hover:text-white/70 transition-colors z-10 bg-transparent border-0 p-1 cursor-pointer">
                            <svg id="password_icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>

                    <!-- BOUTON -->
                    <button type="submit"
                            class="w-full py-3 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold shadow-lg hover:shadow-cyan-500/50 hover:scale-[1.02] transition-all duration-300">
                        Se connecter
                    </button>
                </form>

                <!-- LIEN INSCRIPTION -->
                <div class="mt-6 text-center">
                    <p class="text-white/60 text-sm">
                        Pas encore de compte ?
                        <a href="?controller=utilisateur&action=register" class="text-cyan-400 hover:text-cyan-300 font-semibold transition-colors">
                            S'inscrire
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../components/footer.php'; ?>

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
