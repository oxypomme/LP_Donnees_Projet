<?php

$settings = require_once __DIR__ . '/settings.php';

$db = (new MongoDB\Client('mongodb://mongo'))->selectDatabase('nancy');

$data = json_decode(file_get_contents('https://geoservices.grand-nancy.org/arcgis/rest/services/public/VOIRIE_Parking/MapServer/0/query?where=1%3D1&text=&objectIds=&time=&geometry=&geometryType=esriGeometryEnvelope&inSR=&spatialRel=esriSpatialRelIntersects&relationParam=&outFields=nom%2Cadresse%2Cplaces%2Ccapacite&returnGeometry=true&returnTrueCurves=false&maxAllowableOffset=&geometryPrecision=&outSR=4326&returnIdsOnly=false&returnCountOnly=false&orderByFields=&groupByFieldsForStatistics=&outStatistics=&returnZ=false&returnM=false&gdbVersion=&returnDistinctValues=false&resultOffset=&resultRecordCount=&queryByDistance=&returnExtentsOnly=false&datumTransformation=&parameterValues=&rangeValues=&f=pjson'));


$db->createCollection('pis');
$db = $db->selectCollection('pis');
$pis = [];
foreach ($data->features as $feature) {
  $pi = [
    'name' => $feature->attributes->NOM,
    'address' => $feature->attributes->ADRESSE,
    'description' => '',
    'category' => [
      'name' => 'parking',
      'icon' => 'fa-square-parking',
      'color' => 'blue'
    ],
    'geometry' => $feature->geometry,
    'places' => $feature->attributes->PLACES,
    'capacity' => $feature->attributes->CAPACITE,
  ];
  $pis[] = $pi;
}

$stops = array_map(function ($row) {
  return explode(',', $row);
}, explode("\n", file_get_contents('stan/stops.csv')));

foreach ($stops as $stop) {
  $name = explode('"', $stop[2])[1];
  // Skip header and duplicates
  if ($stop[0] === 'stop_id' || array_search($name, array_column($pis, 'name'))) {
    continue;
  }
  $pi = [
    'name' => $name,
    'address' => '',
    'description' => '',
    'category' => [
      'name' => 'bus',
      'icon' => 'fa-bus-simple',
      'color' => 'red'
    ],
    'geometry' => [
      'x' => $stop[5],
      'y' => $stop[4],
    ]
  ];
  $pis[] = $pi;
}

if (count($pis) > 0) {
  $res = $db->insertMany($pis);
}
