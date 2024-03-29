<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit072eeaacc772a89e2b1caccce169267e
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'app\\' => 4,
        ),
        'C' => 
        array (
            'Contracts\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes',
        ),
        'Contracts\\' => 
        array (
            0 => __DIR__ . '/../..' . '/contracts',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit072eeaacc772a89e2b1caccce169267e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit072eeaacc772a89e2b1caccce169267e::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
