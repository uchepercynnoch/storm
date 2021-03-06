<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9ef9e49693da6615d6ac6339cb2281fa
{
    public static $prefixLengthsPsr4 = array (
        'h' => 
        array (
            'hotspot\\' => 8,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'hotspot\\' => 
        array (
            0 => __DIR__ . '/../..' . '/mikrotik/hotspot',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'PayPal' => 
            array (
                0 => __DIR__ . '/..' . '/paypal/rest-api-sdk-php/lib',
            ),
            'PEAR2\\Net\\Transmitter\\' => 
            array (
                0 => __DIR__ . '/..' . '/pear2/net_transmitter/src',
                1 => __DIR__ . '/..' . '/pear2/net_routeros/vendor/pear2/net_transmitter/src',
            ),
            'PEAR2\\Net\\RouterOS\\' => 
            array (
                0 => __DIR__ . '/..' . '/pear2/net_routeros/src',
            ),
            'PEAR2\\Console\\Color' => 
            array (
                0 => __DIR__ . '/..' . '/pear2/net_routeros/vendor/pear2/console_color/src',
            ),
            'PEAR2\\Cache\\SHM' => 
            array (
                0 => __DIR__ . '/..' . '/pear2/cache_shm/src',
                1 => __DIR__ . '/..' . '/pear2/net_routeros/vendor/pear2/cache_shm/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9ef9e49693da6615d6ac6339cb2281fa::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9ef9e49693da6615d6ac6339cb2281fa::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit9ef9e49693da6615d6ac6339cb2281fa::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
