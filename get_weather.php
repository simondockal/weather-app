<?php

if (isset($_POST['city'])) {
    $city = strtolower($_POST['city']);
    
    // Definujte informace pro jednotlivá města
    $cities = array(
        'trebic' => array('lat' => 50.073658, 'lon' => 13.818540),
        'jihlava' => array('lat' => 49.396548, 'lon' => 15.590650),
        'zdar' => array('lat' => 49.562473, 'lon' => 15.939089),
        'pelhrimov' => array('lat' => 49.431576, 'lon' => 15.583588)
    );

    // Získání informací o počasí pro vybrané město
    if (array_key_exists($city, $cities)) {
        $lat = $cities[$city]['lat'];
        $lon = $cities[$city]['lon'];

        $url = "https://api.openweathermap.org/data/2.5/weather?lat=$lat&lon=$lon&appid=4921810ad61b7cc86d5d721dbdee166f";

        $urlContents = file_get_contents($url);

        $weatherArray = json_decode($urlContents, true);

        if ($weatherArray) {
            $humidity = $weatherArray['main']['humidity'];
            $sunset = date('H:i:s', $weatherArray['sys']['sunset']);
            $temperature = ((int)$weatherArray['main']['temp'] - 273);

            $response = array(
                'city' => $weatherArray['name'],
                'temperature' => $temperature,
                'description' => $weatherArray['weather'][0]['description'],
                'humidity' => $humidity,
                'sunset' => $sunset
            );

            echo json_encode($response);
        } else {
            // Handle case where weather information is not available
            echo json_encode(array('error' => 'Není k dispozici informace pro toto město.'));
        }
    } else {
        // Handle case where city information is not available
        echo json_encode(array('error' => 'Není k dispozici informace pro toto město.'));
    }
}

?>
