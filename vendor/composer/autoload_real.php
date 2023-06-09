<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderIniteb9d18f9bdf9920ec94c12a4fdd2b013
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderIniteb9d18f9bdf9920ec94c12a4fdd2b013', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderIniteb9d18f9bdf9920ec94c12a4fdd2b013', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticIniteb9d18f9bdf9920ec94c12a4fdd2b013::getInitializer($loader));

        $loader->register(true);

        $includeFiles = \Composer\Autoload\ComposerStaticIniteb9d18f9bdf9920ec94c12a4fdd2b013::$files;
        foreach ($includeFiles as $fileIdentifier => $file) {
            composerRequireeb9d18f9bdf9920ec94c12a4fdd2b013($fileIdentifier, $file);
        }

        return $loader;
    }
}

/**
 * @param string $fileIdentifier
 * @param string $file
 * @return void
 */
function composerRequireeb9d18f9bdf9920ec94c12a4fdd2b013($fileIdentifier, $file)
{
    if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) {
        $GLOBALS['__composer_autoload_files'][$fileIdentifier] = true;

        require $file;
    }
}
