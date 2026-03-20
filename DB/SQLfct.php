<?php

class SQLfct {

    private $pdo;

public function __construct() {

    try { 
        $db_name = "myrmidons" ; $db_host = "127.0.0.1" ; $db_port = "3306" ;
        $db_user = "root" ; $db_pwd = "root" ;
        $dsn = 'mysql:dbname=' . $db_name . ';host='. $db_host. ';port=' . $db_port;
        $pdo = new PDO($dsn, $db_user, $db_pwd) ;
    } catch(\Exception $ex){
        die("Erreur : " . $ex->getMessage()) ;
}

}

//fonction qui rajouter dans la BDD une recette
function ajouterRecette($nomRecette, $descriptionRecette, $photo) {

    $query = "INSERT INTO recette (name, description, photo) VALUES (:nom, :desc, :photo)" ;
    $statement = $pdo->prepare($query);

    $statement->bindValue(':nom', $nomRecette) ;
    $statement->bindValue(':desc', $descriptionRecette) ;
    $statement->bindValue(':photo', $photo) ;

    $statement->execute() or die(var_dump($statement->errorInfo())) ;

    }

}


