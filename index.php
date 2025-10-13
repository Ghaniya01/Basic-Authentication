<?php declare(strict_types=1);


if(!defined('ROOT_DIR')) define('ROOT_DIR', realpath(__DIR__));


require ROOT_DIR . '/vendor/autoload.php';

Dotenv\Dotenv::createImmutable(__DIR__)->load();


if (($_ENV['APP_ENV'] ?? 'prod') === 'local') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}



require_once 'route/slash.route.php';
