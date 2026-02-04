<?php
/**
 * Autoloader PSR-4 - Chargement auto des classes
 * BUT2 - S3 - AquaView Project
 * Implémente la norme PSR-4 pour le chargement auto des classes PHP
 */

namespace App\Lib;

/**
 * Psr4AutoloaderClass - Implementation de l'autoloading PSR-4
 * 
 * Cette classe permet de charger auto les fichiers de classes
 * en suivant la convention PSR-4 : Namespace\\SubNamespace\\ClassName -> Namespace/SubNamespace/ClassName.php
 * 
 * Avantages :
 * - Plus besoin de require_once manuel
 * - Organisation claire du code
 * - Compatible avec les standards PHP-FIG
 */
class Psr4AutoloaderClass {
    /** @var array Tableau des namespaces et leurs repertoires correspondants */
    protected array $prefixes = [];

    /**
     * Enregistre l'autoloader aupres de PHP
     * Utilise spl_autoload_register pour intercepter les chargements de classes
     */
    public function register(): void {
        spl_autoload_register([$this, 'loadClass']);
    }

    /**
     * Ajoute un namespace et son repertoire de base
     * @param string $prefix Namespace (ex: 'App\\Controller')
     * @param string $baseDir Repertoire correspondant (ex: '/src/Controller')
     * @param bool $prepend Si true, ajoute au debut du tableau (priorite plus elevee)
     */
    public function addNamespace(string $prefix, string $baseDir, bool $prepend = false): void {
        // Normalisation du namespace (ajout du \\ final si manquant)
        $prefix = trim($prefix, '\\') . '\\';
        // Normalisation du repertoire (ajout du / final si manquant)
        $baseDir = rtrim($baseDir, DIRECTORY_SEPARATOR) . '/';
        
        // Initialisation du tableau pour ce namespace si non existant
        if (!isset($this->prefixes[$prefix])) {
            $this->prefixes[$prefix] = [];
        }
        
        // Ajout du repertoire (au debut ou a la fin selon $prepend)
        if ($prepend) {
            array_unshift($this->prefixes[$prefix], $baseDir);
        } else {
            $this->prefixes[$prefix][] = $baseDir;
        }
    }

    /**
     * Methode principale de chargement de classe
     * Appelee auto par PHP quand une classe n'est pas trouvee
     * @param string $class Nom complet de la classe avec namespace
     * @return bool|null True si la classe a ete chargee, null sinon
     */
    public function loadClass(string $class): ?bool {
        $prefix = $class;
        
        // Parcours recursif des namespaces pour trouver une correspondance
        while (($pos = strrpos($prefix, '\\')) !== false) {
            // Extraction du prefix et du nom de classe relatif
            $prefix = substr($class, 0, $pos + 1);
            $relativeClass = substr($class, $pos + 1);
            
            // Tentative de chargement du fichier mappe
            $mappedFile = $this->loadMappedFile($prefix, $relativeClass);
            
            if ($mappedFile) {
                return true;
            }
            
            // Si non trouve, on continue avec le namespace parent
            $prefix = rtrim($prefix, '\\');
        }
        
        return null;
    }

    protected function loadMappedFile(string $prefix, string $relativeClass): ?string {
        if (!isset($this->prefixes[$prefix])) {
            return null;
        }
        
        foreach ($this->prefixes[$prefix] as $baseDir) {
            $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
            
            if ($this->requireFile($file)) {
                return $file;
            }
        }
        
        return null;
    }

    protected function requireFile(string $file): bool {
        if (file_exists($file)) {
            require $file;
            return true;
        }
        return false;
    }
}
