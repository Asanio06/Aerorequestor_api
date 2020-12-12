<?php
// The router

require_once('functions.php');

if(isset($_GET['data'])){

 echo $_GET['data'];

}else{

  
  
  //print_r($array_associative['data']['METAR'][0]) ;
  $array_associative = get_weather_data();
  print_r($array_associative);

  /*foreach($array_associative['data']['METAR'] as $data){
    if($data['station_id'] == 'LFMN'){
      echo $data['raw_text'];
    }
    
  }*/

}












?>