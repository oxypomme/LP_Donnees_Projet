<?php

$settings = require_once __DIR__ . '/../settings.php';

$db = (new MongoDB\Client('mongodb://mongo'))->selectDatabase('nancy');
var_dump($db);
