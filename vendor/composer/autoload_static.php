<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit12d53ee97b93470b75cd8d0ac0487db2
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Telefonica\\Latch\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Telefonica\\Latch\\' => 
        array (
            0 => __DIR__ . '/..' . '/Telefonica/latch-sdk-php/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit12d53ee97b93470b75cd8d0ac0487db2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit12d53ee97b93470b75cd8d0ac0487db2::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit12d53ee97b93470b75cd8d0ac0487db2::$classMap;

        }, null, ClassLoader::class);
    }
}
