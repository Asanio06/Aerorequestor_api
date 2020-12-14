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

?>