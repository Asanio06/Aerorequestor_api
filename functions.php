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
            if($data['flight_category']){

                if($data["flight_category"] == 'VFR'){
                    $advise = "You can do all type of flight" ;
    
                }else if($data["flight_category"] == 'MVFR'){
                    $advise = "You can do special vfr and IFR";
                }else{
                    $advise = "You can also do IFR flight";
                }

            }else{
                $advise = 'No advise for this airport';
            }
            

            return array("metar"=>$data['raw_text'],"advise"=>$advise) ;
        }
        
    }
}

function get_windiest_airport(){
    $array_associative = get_weather_data();
    $maximum = 0 ;
    $ICAO_of_max ='';
    $list_of_open_airport = array_column(get_list_of_open_airport()->fetchAll(PDO::FETCH_ASSOC) ,'ident');
    foreach($array_associative['data']['METAR'] as $data){

        if(in_array($data['station_id'],$list_of_open_airport)){

            if(isset($data['wind_speed_kt'])   ){
                $wind_speed= $data['wind_speed_kt'];
                if($wind_speed>$maximum){
                    $maximum = $wind_speed;
                    $ICAO_of_max = $data['station_id'];
                }
            }
        }

    }
    $metar = get_metar_of_airport($ICAO_of_max)['metar']; 
    $airport_name = get_name_of_airport_with_ICAO($ICAO_of_max)['name'];
    $countrie_name = get_name_of_countries_with_ICAO($ICAO_of_max)->fetch()['name'];
    $windiest_airport = array("name_of_airport"=>$airport_name,"name_of_countrie"=>$countrie_name,"metar"=>$metar);
    return $windiest_airport;
}



function get_name_of_all_airport(){
    $name_of_airport = get_indent_and_name_of_airport();
    return $name_of_airport;
    
}

function get_url_of_charts($name_of_charts){

    $information_of_chart = get_information_about_chart($name_of_charts)->fetch();

    if($information_of_chart['Countrie_code'] == 'FR'){
        $url_of_charts = 'https://www.sia.aviation-civile.gouv.fr/dvd/eAIP_'. $information_of_chart['Info1']  . '/' . 'FRANCE' .'/'. 
        $information_of_chart['Info2']  .'/html/eAIP/Cartes/'. $information_of_chart['ICAO_AIRPORT'].'/'. rawurlencode($name_of_charts)  . '.pdf' ;
    }else{
        return false ;
    }

    return $url_of_charts ;
    
}
/*
function get_url_of_vfr_chart($airport){

    

    if($information_of_chart['Countrie_code'] == 'FR'){
        $url_of_charts = 'https://www.sia.aviation-civile.gouv.fr/dvd/eAIP_'. $information_of_chart['Info1']  . '/' . 'FRANCE' .'/'. 
        $information_of_chart['Info2']  .'/html/eAIP/Cartes/'. $information_of_chart['ICAO_AIRPORT'].'/'. rawurlencode($name_of_charts)  . '.pdf' ;
    }else{
        return false ;
    }

    return $url_of_charts ;
    
}*/

function generate_datalist_name_of_airport(){
    $airport_list = get_name_of_all_airport();
    
    ob_start();
?>

    <datalist id="list_airport">
                
    <?php
        foreach($airport_list as $airport){


    ?>
            <option value=<?=$airport['ident']?>> <?= $airport['name']?></option>

    <?php

        }
    ?>

    </datalist>

<?php
    $content = ob_get_clean();
    return $content;
}
// END OF FUNCTION generate_datalist_name_of_airport

function generate_datalist_ifr_charts_of_airport($ICAO_airport){

    $charts_list = get_list_of_ifr_chart_of_airport($ICAO_airport)->fetchAll(PDO::FETCH_ASSOC);
    if(!$charts_list){
        header('HTTP/1.1 204 No Content');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'ERROR', 'code' => 204)));
    }
    ob_start();
?>

    <datalist id="list_ifr_chart">
                
        <?php
            foreach($charts_list as $chart){


        ?>
                <option > <?= $chart['Chart_name'] ?></option>

        <?php

            }
        ?>

    </datalist>

<?php
    $content = ob_get_clean();
    return $content;
}
// END OF FUNCTION 



?>





