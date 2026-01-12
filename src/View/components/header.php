<?php require_once __DIR__ . '/../../Lib/helpers.php'; ?>
<!-- 
    Header HTML standard pour toutes les pages du site
    BUT2 - S3 - AquaView Project
    Inclut : meta, TailwindCSS, fonts, styles globaux
-->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Titre dynamique de la page -->
    <title><?= $pageTitle ?? 'AquaView' ?></title>
    <!-- TailwindCSS via CDN pour le design responsive -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Configuration Tailwind personnalisee -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <!-- Preconnexion aux fonts Google pour optimiser le chargement -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Styles globaux personnalises -->
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        select option { background-color: #0f172a; color: white; }
        
        /* Animations CSS pour les transitions */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(1.1); }
            to { opacity: 1; transform: scale(1); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.7s ease-out forwards; }
        .animate-fade-in { animation: fadeIn 1.5s ease-out forwards; }
        .animate-scale-in { animation: scaleIn 2.5s ease-out forwards; }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }
        .delay-700 { animation-delay: 0.7s; }
        .delay-1000 { animation-delay: 1s; }
    </style>
</head>
<body class="bg-slate-900 text-white min-h-screen">
