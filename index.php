<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

Dotenv\Dotenv::createImmutable(dirname(__DIR__))->safeLoad();

if (($_ENV['APP_ENV'] ?? 'prod') === 'local') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}


