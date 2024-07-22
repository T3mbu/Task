<?php


ini_set('display_errors', 'On');
error_reporting(E_ALL);


$executionStartTime = microtime(true);


$url = 'http://api.geonames.org/oceanJSON?lat=' . urlencode($_REQUEST['latitude']) . '&lng=' . urlencode($_REQUEST['longitude']) . '&username=tembuu';


$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);


$result = curl_exec($ch);


curl_close($ch);


$decode = json_decode($result, true);


$output = array(
    'status' => array(
        'code' => "200",
        'name' => "ok",
        'description' => "success",
        'returnedIn' => intval((microtime(true) - $executionStartTime) * 1000) . " ms"
    ),
    'data' => isset($decode['ocean']) ? $decode['ocean'] : $decode
);


header('Content-Type: application/json; charset=UTF-8');


echo json_encode($output);

?>
