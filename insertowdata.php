<?php
require_once('dbconnection.php');

$cities = array(
    'trebic' => array('lat' => 50.073658, 'lon' => 13.818540),
    'jihlava' => array('lat' => 49.396548, 'lon' => 15.590650),
    'zdar' => array('lat' => 49.562473, 'lon' => 15.939089),
    'pelhrimov' => array('lat' => 49.431576, 'lon' => 15.583588)
);

$lat = $cities['trebic']['lat'];
$lon = $cities['trebic']['lon'];


$url = "https://api.openweathermap.org/data/2.5/weather?lat=$lat&lon=$lon&appid=4921810ad61b7cc86d5d721dbdee166f";

$urlContent = file_get_contents($url);
$weatherArray = json_decode($urlContent, true);

if($weatherArray['cod'] == 200){

$sql = "INSERT INTO weather ( city_id, temp, pres, hum, insert_time) values(?,?, ?,?,?)";

$teplota = intval($weatherArray['main']['temp'] - 273);

$stmt = $conn->prepare($sql);
$city_id = 1;
$d = date('Y-m-d H:i:s');
$stmt->bind_param("iiiis", $city_id, $teplota, $weatherArray['main']['pressure'],$weatherArray['main']['humidity'], $d);
$result = $stmt->execute();

    echo "chjochjo everifink ok";
    error_log("chjochjo data ok");

}

?>