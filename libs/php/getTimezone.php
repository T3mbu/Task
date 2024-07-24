<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);


$executionStartTime = microtime(true);


$latitude = isset($_GET['latitude']) ? $_GET['latitude'] : '';
$longitude = isset($_GET['longitude']) ? $_GET['longitude'] : '';
$radius = isset($_GET['radius']) ? $_GET['radius'] : '';
$lang = isset($_GET['lang']) ? $_GET['lang'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : '';

$url = "http://api.geonames.org/timezoneJSON?lat=$latitude&lng=$longitude" .
       ($radius ? "&radius=$radius" : '') .
       ($lang ? "&lang=$lang" : '') .
       ($date ? "&date=$date" : '') .
       "&username=tembuu";


$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);


$result = curl_exec($ch);
curl_close($ch);

// Decode JSON response
$decode = json_decode($result, true);

// Prepare output
$output = [
    'status' => [
        'code' => "200",
        'name' => "ok",
        'description' => "success",
        'returnedIn' => intval((microtime(true) - $executionStartTime) * 1000) . " ms"
    ],
    'data' => $decode
];


header('Content-Type: application/json; charset=UTF-8');
echo json_encode($output);
?>
