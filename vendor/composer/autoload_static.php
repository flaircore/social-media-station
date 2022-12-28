<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5149a8e198dce913dfc181ec3d3fc56d
{
    public static $prefixLengthsPsr4 = array (
        'N' => 
        array (
            'Nick\\SocialMediaStation\\' => 24,
        ),
        'F' => 
        array (
            'Facebook\\' => 9,
        ),
        'C' => 
        array (
            'Composer\\CaBundle\\' => 18,
        ),
        'A' => 
        array (
            'Abraham\\TwitterOAuth\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Nick\\SocialMediaStation\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
        'Facebook\\' => 
        array (
            0 => __DIR__ . '/..' . '/facebook/graph-sdk/src/Facebook',
        ),
        'Composer\\CaBundle\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/ca-bundle/src',
        ),
        'Abraham\\TwitterOAuth\\' => 
        array (
            0 => __DIR__ . '/..' . '/abraham/twitteroauth/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5149a8e198dce913dfc181ec3d3fc56d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5149a8e198dce913dfc181ec3d3fc56d::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit5149a8e198dce913dfc181ec3d3fc56d::$classMap;

        }, null, ClassLoader::class);
    }
}