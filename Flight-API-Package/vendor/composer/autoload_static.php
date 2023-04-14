<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite40b45be5701103b5ce683ed433cfefd
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Flight\\Aerodatabox\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Flight\\Aerodatabox\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite40b45be5701103b5ce683ed433cfefd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite40b45be5701103b5ce683ed433cfefd::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite40b45be5701103b5ce683ed433cfefd::$classMap;

        }, null, ClassLoader::class);
    }
}
