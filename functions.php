<?php
// Here my fonction
require_once('BDD_data.php');

function get_xml_of_aviation_weather_center(){
    $lines = file_get_contents('https://www.aviationweather.gov/adds/dataserver_current/current/metars.cache.xml');
    $xml = simplexml_load_string($lines);
    return $xml;
}

function convert_xml_to_array_associative($xml_data){
    $json_data = json_encode($xml_data);
    $array_associative = json_decode($json_data,true);
    return $array_associative;
}

function get_weather_data(){

    $xml_data = get_xml_of_aviation_weather_center();
    $array_associative = convert_xml_to_array_associative($xml_data);

    return $array_associative;
}

function get_metar_of_airport($airport_ICAO){
    $array_associative = get_weather_data();

    foreach($array_associative['data']['METAR'] as $data){
        if($data['station_id'] == $airport_ICAO){
            return $data['raw_text'];
        }
        
    }
}

function get_windiest_airport(){
    $array_associative = get_weather_data();
    $maximum = 0 ;
    $ICAO_of_max ='';

    foreach($array_associative['data']['METAR'] as $data){
        if(isset($data['wind_speed_kt'])){
            $wind_speed= $data['wind_speed_kt'];
            if($wind_speed>$maximum){
                $maximum = $wind_speed;
                $ICAO_of_max = $data['station_id'];
            }
        }
        

    }
    return get_metar_of_airport($ICAO_of_max);
}



?>

