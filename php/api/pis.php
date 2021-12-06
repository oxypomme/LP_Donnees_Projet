<?php

namespace Nancy\api;

require_once __DIR__ . '/../Connection.php';

function encode($value, int $f = 0): ?string
{
  $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | $f;
  $res = \json_encode($value, $flags);
  if (!$res) {
    return null;
  }
  return $res;
}

$db = (new \Nancy\Connection())->db;
$cursor = $db->pis->find();
$data = [];
foreach ($cursor as $document) {
  $data[] = $document;
}

header('Content-Type: application/json');
exit(encode($data));
