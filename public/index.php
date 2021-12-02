<?php

$settings = require_once __DIR__ . '/../settings.php';

$manager = new MongoDB\Driver\Manager("mongodb://{$settings['DB_USER']}:{$settings['DB_USER']}@mongo:27017");
var_dump($manager);
