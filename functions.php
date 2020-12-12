<?php
// Here my fonction

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
    //print_r($array_associative);

    foreach($array_associative['data']['METAR'] as $data){
        if($data['station_id'] == $airport_ICAO){
            return $data['raw_text'];
        }
        
    }
}



?>

