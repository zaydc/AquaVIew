document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    console.log('Éléments trouvés:', {
        mobileMenuBtn: !!mobileMenuBtn,
        mobileMenu: !!mobileMenu
    });

    // Ouvrir le menu mobile
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Clic sur bouton menu');
            mobileMenu.classList.remove('hidden');
            document.body.classList.add('menu-open');
        });
    }

    // Utiliser event delegation pour gérer tous les clics de fermeture
    document.addEventListener('click', function(e) {
        // Vérifier si on clique sur le bouton de fermeture ou ses éléments enfants
        const closeBtn = e.target.closest('#mobile-menu-close');
        if (closeBtn) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Clic sur bouton fermeture (cible:', e.target.tagName, ')');
            mobileMenu.classList.add('hidden');
            document.body.classList.remove('menu-open');
            return;
        }

        // Fermer le menu en cliquant sur le fond
        if (e.target === mobileMenu || e.target.closest('#mobile-menu .absolute.inset-0')) {
            // Vérifier si on clique sur le fond (pas sur les éléments du menu)
            if (e.target === mobileMenu || e.target.classList.contains('absolute') && e.target.classList.contains('inset-0')) {
                console.log('Clic sur le fond');
                mobileMenu.classList.add('hidden');
                document.body.classList.remove('menu-open');
            }
        }
    });

    // Fermer le menu avec la touche Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileMenu && !mobileMenu.classList.contains('hidden')) {
            console.log('Touche Escape pressée');
            mobileMenu.classList.add('hidden');
            document.body.classList.remove('menu-open');
        }
    });
});
