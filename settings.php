<?php

require_once __DIR__ . '/vendor/autoload.php';

const APP_ROOT = __DIR__;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

return $_ENV;
