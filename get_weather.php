<?php
if (isset($_POST['mesto']) && isset($_POST['od']) && isset($_POST['do'])) {
    $city = strtolower($_POST['mesto']);
    $od = strtotime($_POST['od']);
    $do = strtotime($_POST['do']);

    $cities = array(
        'praha' => array('lat' => 50.073658, 'lon' => 13.818540),
        'brno' => array('lat' => 49.396548, 'lon' => 15.590650),
        'ostrava' => array('lat' => 49.562473, 'lon' => 15.939089),
        'plzen' => array('lat' => 49.431576, 'lon' => 15.583588),
        'liberec' => array('lat' => 50.769479, 'lon' => 15.082995),
        'ceske-budejovice' => array('lat' => 48.974468, 'lon' => 14.474622)
    );

        // Zkontroluje, zda je zadané město v poli $cities
    if (array_key_exists($city, $cities)) {
        // Město je v poli, uložíme ho do proměnné $selected_city
        $selected_city = $city;
        // Uložíme data města do proměnné $city_data
        $weatherData = $cities[$selected_city];
    } else {
        // Město nenalezeno v poli, vypíšeme alert
        echo '<script>alert("Město nenalezeno.");</script>';
    }


    while ($od <= $do) {
        $date = date('Y-m-d', $od);
        $url = "https://api.openweathermap.org/data/2.5/weather?lat={$cities[$city]['lat']}&lon={$cities[$city]['lon']}&appid=4921810ad61b7cc86d5d721dbdee166f";

        $urlContents = file_get_contents($url);
        $weatherArray = json_decode($urlContents, true);

        if ($weatherArray) {
            $temperature = ((int)$weatherArray['main']['temp'] - 273);
            $humidity = $weatherArray['main']['humidity'];
            $sunset = date('H:i:s', $weatherArray['sys']['sunset']);
            $description = $weatherArray['weather'][0]['description'];

            $weatherData[] = array(
                'date' => $date,
                'city' => $weatherArray['name'],
                'temperature' => $temperature,
                'humidity' => $humidity,
                'sunset' => $sunset,
                'description' => $description
            );
        } else {
            // Handle case where weather information is not available
            echo json_encode(array('error' => 'Není k dispozici informace pro toto město.'));
        }

        // Přidání jednoho dne k $od
        $od = strtotime('+1 day', $od);
    }

    echo json_encode($weatherData);
}
?>