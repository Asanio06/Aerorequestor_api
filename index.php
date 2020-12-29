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

  }elseif($_GET['request']=='airport_list'){ // get Windiest airport

    echo generate_datalist_name_of_airport();

  }elseif($_GET['request']=='list_charts_of_airport'){ // If user want metar of one airport

    if(isset($_GET['airport'])){ // Verification

      if($_GET['airport']){ // If we have 

        $airport =  $_GET['airport'];
        echo json_encode(generate_datalist_ifr_charts_of_airport($airport));

      }
    }

  }


}else{

  echo generate_datalist_ifr_charts_of_airport('LFKJ');
  
  //http_response_code();

}












?>