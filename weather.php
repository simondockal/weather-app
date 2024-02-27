<?php


class City {

public $id;
public $lon;
public $name;
public $lat;

public function __construct($id, $name, $lat, $lon){
    $this->name = $name;
    $this->lon = $lon;
    $this->lat = $lat;
    $this->id = $id;
}

$cities = array(
    'trebic' => array('lat' => 50.073658, 'lon' => 13.818540),
    'jihlava' => array('lat' => 49.396548, 'lon' => 15.590650),
    'zdar' => array('lat' => 49.562473, 'lon' => 15.939089),
    'pelhrimov' => array('lat' => 49.431576, 'lon' => 15.583588)
);

setlocale(LC_ALL, 'cs_CZ.UTF-8');

$city = $cities[$cityid];

}


$cityid = $_POST['cityid'];

error_log("Received id:" . $cityid);
?>