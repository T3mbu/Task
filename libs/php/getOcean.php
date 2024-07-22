<?php

// For debugging (remove for production)
ini_set('display_errors', 'On');
error_reporting(E_ALL);

// Start measuring execution time
$executionStartTime = microtime(true);

// Prepare the URL for GeoNames Ocean API
$url = 'http://api.geonames.org/oceanJSON?lat=' . urlencode($_REQUEST['latitude']) . '&lng=' . urlencode($_REQUEST['longitude']) . '&username=tembuu';

// Initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);

// Execute cURL request
$result = curl_exec($ch);

// Close cURL session
curl_close($ch);

// Decode JSON response
$decode = json_decode($result, true);

// Prepare output
$output = array(
    'status' => array(
        'code' => "200",
        'name' => "ok",
        'description' => "success",
        'returnedIn' => intval((microtime(true) - $executionStartTime) * 1000) . " ms"
    ),
    'data' => isset($decode['ocean']) ? $decode['ocean'] : $decode
);

// Set Content-Type header to application/json
header('Content-Type: application/json; charset=UTF-8');

// Output JSON response
echo json_encode($output);

?>
