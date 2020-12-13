<?php

function get_bdd(){
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=api;charset=utf8', 'root', '');
        return $bdd;
    }
    catch (Exception $e)
    {
            die('Erreur : ' . $e->getMessage());
    }
}


function get_indent_and_name_of_airport(){
    $bdd = get_bdd();
    $req =$bdd->prepare('SELECT ident,name FROM `mytable`');
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);

}

?>