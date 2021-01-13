<?php

function get_bdd(){
    try
    {
        $bdd = new PDO('mysql:host=mysql-asanio.alwaysdata.net;dbname=asanio_api;charset=utf8', 'asanio_php', ']{jrcrmS{vRL48!<');
        return $bdd;
    }
    catch (Exception $e)
    {
            die('Erreur : ' . $e->getMessage());
    }
}


function get_indent_and_name_of_airport(){
    $bdd = get_bdd();
    $req =$bdd->prepare('SELECT ident,name FROM `Airport` ');
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);

}

function get_name_of_airport_with_ICAO($ICAO_airport){
    $bdd = get_bdd();
    $req =$bdd->prepare('SELECT name,type FROM `Airport` WHERE ident =:ICAO_airport');
    $req->bindParam(':ICAO_airport',$ICAO_airport,PDO::PARAM_STR);
    $req->execute();
    return $req->fetch();

}

function get_list_of_ifr_chart_of_airport($ICAO_airport){
    $bdd = get_bdd();
    $req =$bdd->prepare('SELECT * FROM `Chart_of_airport` WHERE ICAO_AIRPORT = :ICAO_airport');
    $req->bindParam(':ICAO_airport',$ICAO_airport,PDO::PARAM_STR);
    $req->execute();
    return $req;

}

function get_list_of_open_airport(){
    // I want to know if is airport , heliport or other
    $bdd = get_bdd();
    $req =$bdd->prepare('SELECT  ident,name FROM `Airport` WHERE type LIKE \'%airport%\'');
    $req->execute();

    return $req;
    
}

function get_information_about_chart($chart_name){
    
    $bdd = get_bdd();
    $req =$bdd->prepare('SELECT Chart_of_airport.ICAO_AIRPORT , Chart_of_airport.Chart_name , information_of_airac.* 
    FROM `Chart_of_airport`, Airport , information_of_airac WHERE information_of_airac.Countrie_code = Airport.iso_country AND 
    Airport.ident = Chart_of_airport.ICAO_AIRPORT AND Chart_of_airport.Chart_name = :Chart_name
    AND NOW() BETWEEN information_of_airac.Date_begin AND information_of_airac.Date_end');
    $req->bindParam(':Chart_name',$chart_name,PDO::PARAM_STR);
    $req->execute();

    return $req;
}

function get_name_of_countries_with_ICAO($ICAO_airport){
    $bdd = get_bdd();
    $req =$bdd->prepare('SELECT Countries.name FROM Airport, Countries WHERE Countries.code = Airport.iso_country AND Airport.ident = :ICAO_airport');
    $req->bindParam(':ICAO_airport',$ICAO_airport,PDO::PARAM_STR);
    $req->execute();
    return $req;
}


?>