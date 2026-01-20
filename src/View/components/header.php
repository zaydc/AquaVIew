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
    <link rel="stylesheet" href="/web/assets/css/global.css">
</head>
<body class="bg-slate-900 text-white min-h-screen">
