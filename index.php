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
        echo generate_datalist_ifr_charts_of_airport($airport);

      }
    }

  }elseif($_GET['request']=='get_url_of_chart'){ // 

    if(isset($_GET['charts'])){ // 

      if($_GET['charts']){ // 

        $name_of_charts =  rawurldecode($_GET['charts']) ;
        echo  json_encode(get_url_of_charts($name_of_charts)) ;

      }
    }

  }

}else{

  get_url_of_charts('AD 2 LFPO AMSR 01');

  
  //http_response_code();

}












?>