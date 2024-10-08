<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit49bbcd30469947972cb0f68af758ad1a
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

        spl_autoload_register(array('ComposerAutoloaderInit49bbcd30469947972cb0f68af758ad1a', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit49bbcd30469947972cb0f68af758ad1a', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit49bbcd30469947972cb0f68af758ad1a::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
