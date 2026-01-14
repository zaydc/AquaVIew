<?php
$currentPage = $_GET['action'] ?? 'home';
$isLoggedIn = isset($_SESSION['user']) && !empty($_SESSION['user']);
$user = $_SESSION['user'] ?? null;

$navItems = [
    ['label' => 'Accueil', 'path' => '?action=home', 'action' => 'home'],
    ['label' => 'Analyse', 'path' => '?action=analyse', 'action' => 'analyse'],
    ['label' => 'Équipe', 'path' => '?action=equipe', 'action' => 'equipe'],
    
];
?>

<!-- Floating Top Navigation -->
<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 flex justify-center px-4 pt-6 transition-transform duration-400">
    <header class="inline-flex items-center justify-between gap-6 md:gap-12 px-6 md:px-10 py-4 rounded-2xl backdrop-blur-xl bg-white/5 border border-white/10 shadow-2xl shadow-black/20 transition-all duration-300">
        <!-- Logo -->
        <a href="?action=home" class="flex items-center gap-3 font-semibold tracking-wide text-lg">
            <span class="bg-gradient-to-r from-white to-cyan-200 bg-clip-text text-transparent">
                AquaView
            </span>
        </a>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex gap-8 text-sm">
            <?php foreach ($navItems as $item): ?>
                <a href="<?= $item['path'] ?>" 
                   class="relative text-white/70 hover:text-white transition-colors duration-300 group <?= $currentPage === $item['action'] ? 'text-white' : '' ?>">
                    <?= $item['label'] ?>
                    <span class="absolute -bottom-1 left-0 h-0.5 bg-gradient-to-r from-cyan-400 to-blue-400 transition-all duration-300 <?= $currentPage === $item['action'] ? 'w-full' : 'w-0 group-hover:w-full' ?>"></span>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Right Side Menu -->
        <div class="hidden md:flex items-center gap-4">
            <?php if ($isLoggedIn): ?>
                <a href="?controller=utilisateur&action=profile" 
                   class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-cyan-500/20 to-blue-500/20 border border-cyan-500/30 text-cyan-300 hover:bg-cyan-500/30 transition-colors duration-300 text-sm font-medium">
                    Mon Profil
                </a>
                <span class="text-white/70 text-sm"><?= htmlspecialchars($user['email'] ?? '') ?></span>
                <a href="?controller=utilisateur&action=logout" 
                   class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-red-500/20 to-red-500/20 border border-red-500/30 text-red-300 hover:bg-red-500/30 transition-colors duration-300 text-sm font-medium">
                    Déconnexion
                </a>
            <?php else: ?>
                <a href="?controller=utilisateur&action=login" 
                   class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-cyan-500/20 to-blue-500/20 border border-white/20 text-sm font-medium text-white/70 hover:from-cyan-500/30 hover:to-blue-500/30 hover:border-white/40 hover:shadow-lg hover:shadow-cyan-500/20 transition-all duration-300">
                    Connexion
                </a>
                <a href="?controller=utilisateur&action=register" 
                   class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white hover:shadow-lg hover:shadow-cyan-500/50 transition-all duration-300 text-sm font-medium">
                    S'inscrire
                </a>
            <?php endif; ?>
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobile-menu-btn" class="md:hidden text-white p-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </header>
</nav>

<!-- Mobile Menu -->
<div id="mobile-menu" class="fixed inset-0 z-40 hidden">
    <div class="absolute inset-0 bg-slate-900/95 backdrop-blur-xl">
        <div class="flex flex-col items-center justify-center h-full gap-6">
            <?php foreach ($navItems as $item): ?>
                <a href="<?= $item['path'] ?>" 
                   class="text-2xl text-white/70 hover:text-white transition-colors">
                    <?= $item['label'] ?>
                </a>
            <?php endforeach; ?>
            <div class="flex flex-col gap-4 mt-8">
                <?php if ($isLoggedIn): ?>
                    <a href="?controller=utilisateur&action=profile" class="px-8 py-3 rounded-xl bg-cyan-500/20 border border-cyan-500/30 text-cyan-300 text-center">
                        Mon Profil
                    </a>
                    <a href="?controller=utilisateur&action=logout" class="px-8 py-3 rounded-xl bg-red-500/20 border border-red-500/30 text-red-300 text-center">
                        Déconnexion
                    </a>
                <?php else: ?>
                    <a href="?controller=utilisateur&action=login" class="px-8 py-3 rounded-xl bg-white/10 border border-white/20 text-white text-center">
                        Connexion
                    </a>
                    <a href="?controller=utilisateur&action=register" class="px-8 py-3 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-center">
                        S'inscrire
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <button id="mobile-menu-close" class="absolute top-6 right-6 text-white p-2">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>

<script src="/web/assets/js/navbar.js"></script>
