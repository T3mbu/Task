<?php


ini_set('display_errors', 'On');
error_reporting(E_ALL);


$executionStartTime = microtime(true);


$latitude = isset($_GET['latitude']) ? $_GET['latitude'] : '';
$longitude = isset($_GET['longitude']) ? $_GET['longitude'] : '';


if ($latitude === '' || $longitude === '') {
    echo json_encode([
        'status' => [
            'code' => '400',
            'name' => 'bad request',
            'description' => 'Latitude and Longitude are required.'
        ]
    ]);
    exit;
}


$url = "http://api.geonames.org/neighbourhoodJSON?formatted=true&lat=$latitude&lng=$longitude&username=tembuu";


$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);


$result = curl_exec($ch);
curl_close($ch);

$decode = json_decode($result, true);


if (isset($decode['neighbourhood'])) {
    $neighbourhood = $decode['neighbourhood'];
    $output['data'] = [
        'name' => $neighbourhood['name'] ?? 'N/A',
        'city' => $neighbourhood['adminName2'] ?? 'N/A'
    ];
} else {
    $output['data'] = [
        'name' => 'N/A',
        'city' => 'N/A'
    ];
}


$output['status'] = [
    'code' => '200',
    'name' => 'ok',
    'description' => 'success',
    'returnedIn' => intval((microtime(true) - $executionStartTime) * 1000) . ' ms'
];


header('Content-Type: application/json; charset=UTF-8');
echo json_encode($output);

?>
