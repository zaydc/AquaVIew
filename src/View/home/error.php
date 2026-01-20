<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur - AquaView</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900">
    <?php include __DIR__ . '/../components/navbar.php'; ?>
    
    <div class="relative min-h-screen text-white bg-slate-900 pt-20">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900/95 via-blue-900/80 to-cyan-800/70"></div>
        
        <div class="relative z-10 flex items-center justify-center min-h-[calc(100vh-80px)]">
            <div class="text-center px-6">
                <h1 class="text-8xl font-bold bg-gradient-to-r from-cyan-300 to-blue-300 bg-clip-text text-transparent mb-6">404</h1>
                <h2 class="text-2xl md:text-3xl font-light text-white mb-4">Page non trouvée</h2>
                <p class="text-white/60 mb-8 max-w-md mx-auto">
                    La page que vous recherchez n'existe pas ou a été déplacée.
                </p>
                <a 
                    href="?action=home" 
                    class="inline-flex items-center gap-2 px-8 py-3 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold hover:shadow-lg hover:shadow-cyan-500/50 transition-all duration-300"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
</body>
</html>
