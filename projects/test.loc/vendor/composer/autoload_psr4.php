<?php

// autoload_psr4.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'user_services\\' => array($vendorDir . '/core/lib/user_services'),
    'models\\' => array($baseDir . '/app/models'),
    'database\\' => array($vendorDir . '/core/lib/database'),
    'core\\' => array($vendorDir . '/core'),
    'controllers\\' => array($baseDir . '/app/controllers'),
    'Symfony\\Polyfill\\Ctype\\' => array($vendorDir . '/symfony/polyfill-ctype'),
    'Dotenv\\' => array($vendorDir . '/vlucas/phpdotenv/src'),
);
