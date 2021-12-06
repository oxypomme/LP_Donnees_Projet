<?php
$settings = require_once __DIR__ . '/../settings.php';

// Serve static content
if (!in_array($_SERVER['REQUEST_URI'], ['', '/'])) {
  $path = __DIR__ . $_SERVER['REQUEST_URI'];
  $matches = [];
  preg_match('/.*\.(.*)$/', $_SERVER['REQUEST_URI'], $matches);

  if (!$matches[0]) {
    require __DIR__ . '/../php' . $_SERVER['REQUEST_URI'] . '.php';
    exit;
  }

  if (file_exists($path)) {
    $type = 'text/plain';
    switch ($matches[1]) {
      case 'css':
        $type = 'text/css';
        break;
      case 'mjs':
      case 'js':
        $type = 'application/javascript';
        break;

      default:
        break;
    }
    header('Content-Type: ' . $type);
    exit(file_get_contents($path));
  } else {
    http_response_code(404);
    exit('404');
  }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />

  <!-- Meta Data -->
  <title></title>
  <meta name="description" content="" />
  <!-- Critical style -->
  <style>
    * {
      box-sizing: border-box;
    }

    html,
    body {
      margin: 0;
      padding: 0;
      height: 100%;
      width: 100%;
    }
  </style>

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- GMaps -->
  <script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQ_ofCjcXpnMueuwwiWnN6o64C0jJWh70" async defer></script>
  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
  <script defer src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
  <script defer src="https://unpkg.com/leaflet.gridlayer.googlemutant@latest/dist/Leaflet.GoogleMutant.js"></script>

  <!-- Style -->
  <link rel="stylesheet" href="/css/style.css" />
  <!-- JS -->
  <script defer src="/js/index.js"></script>


  <meta name="viewport" content="initial-scale=1" />
</head>

<body>
  <main>
    <div id="list"></div>
    <div id="filters"></div>
    <div>
      <div id="map"></div>
    </div>
  </main>
</body>

</html>