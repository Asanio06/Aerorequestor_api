<?php
// The router

require_once('functions.php');

if(isset($_GET['request'])){

  if($_GET['request']=='metar_of_airport'){ // If user want metar of one airport

    if(isset($_GET['airport'])){ // Verification

      if($_GET['airport']){ // If we have 

        $airport =  $_GET['airport'];
        echo json_encode(get_metar_of_airport($airport));

      }
    }

  }elseif($_GET['request']=='Windiest_airport'){ // get Windiest airport

    echo json_encode(get_windiest_airport());

  }


}else{

  echo json_encode(get_metar_of_airport('LFMN'));
  
  //http_response_code()

}












?>