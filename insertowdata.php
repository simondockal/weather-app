<?php
require_once('dbconnection.php');


$cities = array(
    'Praha' => array('lat' => 50.073658, 'lon' => 14.418540),
    'Brno' => array('lat' => 49.195060, 'lon' => 16.606837),
    'Ostrava' => array('lat' => 49.820922, 'lon' => 18.262524),
    'Plzeň' => array('lat' => 49.747717, 'lon' => 13.377670),
    'Liberec' => array('lat' => 50.767072, 'lon' => 15.056678)
);


$lat = $cities['trebic']['lat'];
$lon = $cities['trebic']['lon'];

$url = "https://api.openweathermap.org/data/2.5/weather?lat=$lat&lon=$lon&appid=4921810ad61b7cc86d5d721dbdee166f";

$urlContent = file_get_contents($url);
$weatherArray = json_decode($urlContent, true);

if ($weatherArray['cod'] == 200) {
    $sql = "INSERT INTO weather (city_id, temp, pres, hum, insert_time) VALUES (?, ?, ?, ?, ?)";

    $teplota = intval($weatherArray['main']['temp'] - 273);

    $stmt = $conn->prepare($sql);
    
    // Check if the prepare statement was successful
    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }

    $city_id = 1;
    $d = date('Y-m-d H:i:s');
    
    $result = $stmt->bind_param("iiiis", $city_id, $teplota, $weatherArray['main']['pressure'], $weatherArray['main']['humidity'], $d);
    
    // Check if the bind was successful
    if ($result === false) {
        die('Binding parameters failed: ' . $stmt->error);
    }

    $execResult = $stmt->execute();
    
    // Check if the execution was successful
    if ($execResult === false) {
        die('Execute failed: ' . $stmt->error);
    }

    echo "Data inserted successfully!";
    error_log("Data inserted successfully!");
} else {
    echo "Weather data not available.";
}
?>
