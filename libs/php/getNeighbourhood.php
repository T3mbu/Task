<?php

// Enable error reporting for debugging
ini_set('display_errors', 'On');
error_reporting(E_ALL);

// Start timing for performance measurement
$executionStartTime = microtime(true);

// Retrieve latitude and longitude from the request
$latitude = isset($_GET['latitude']) ? $_GET['latitude'] : '';
$longitude = isset($_GET['longitude']) ? $_GET['longitude'] : '';

// Ensure latitude and longitude are provided
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

// Prepare the URL to fetch neighborhood information based on latitude and longitude
$url = "http://api.geonames.org/neighbourhoodJSON?formatted=true&lat=$latitude&lng=$longitude&username=tembuu";

// Initialize cURL session
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);

// Execute the cURL request
$result = curl_exec($ch);
curl_close($ch);

// Decode the JSON response
$decode = json_decode($result, true);

// Check if the response contains neighborhood information
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

// Build the output array
$output['status'] = [
    'code' => '200',
    'name' => 'ok',
    'description' => 'success',
    'returnedIn' => intval((microtime(true) - $executionStartTime) * 1000) . ' ms'
];

// Send the JSON response
header('Content-Type: application/json; charset=UTF-8');
echo json_encode($output);

?>
