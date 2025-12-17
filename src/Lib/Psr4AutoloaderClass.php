<?php
namespace App\Lib;

class Psr4AutoloaderClass {
    protected array $prefixes = [];

    public function register(): void {
        spl_autoload_register([$this, 'loadClass']);
    }

    public function addNamespace(string $prefix, string $baseDir, bool $prepend = false): void {
        $prefix = trim($prefix, '\\') . '\\';
        $baseDir = rtrim($baseDir, DIRECTORY_SEPARATOR) . '/';
        
        if (!isset($this->prefixes[$prefix])) {
            $this->prefixes[$prefix] = [];
        }
        
        if ($prepend) {
            array_unshift($this->prefixes[$prefix], $baseDir);
        } else {
            $this->prefixes[$prefix][] = $baseDir;
        }
    }

    public function loadClass(string $class): ?bool {
        $prefix = $class;
        
        while (($pos = strrpos($prefix, '\\')) !== false) {
            $prefix = substr($class, 0, $pos + 1);
            $relativeClass = substr($class, $pos + 1);
            $mappedFile = $this->loadMappedFile($prefix, $relativeClass);
            
            if ($mappedFile) {
                return true;
            }
            
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
