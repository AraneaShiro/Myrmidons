<?php

class SQLfct {

    private $db_name = "myrmidons";
    private $db_host = "127.0.0.1";
    private $db_port = "3306";

    private $db_user = "root";
    private $db_pwd = "root";

    private $pdo;

public function __construct() {

    try { 

        $dsn = 'mysql:dbname=' . $this->db_name . ';host='. $this->db_host. ';port=' . $this->db_port;

        $this->pdo = new PDO($dsn, $this->db_user, $this->db_pwd) ;

    } catch(\Exception $ex){
        die("Erreur connexion BDD : " . $ex->getMessage()) ;
}

}

/* 
=================================================
    * FONCTIONS POUR RECHERCHER DANS LA BDD *
=================================================
*/

/**
 * fonction qui donne toutes les recettes existantes
 */
function rechercherRecettesAll() {

    try {
    $query =    "SELECT * FROM recette 
                ORDER BY nom DESC" ;

    $statement = $this->pdo->prepare($query);

    $statement->execute();

    return $statement->fetchAll();
    } catch(\Exception $ex){
        die("Erreur rechercherRecetteAll : " . $ex->getMessage()) ;
}
}

/* 
=================================================
 * FONCTIONS POUR CREER OU MODIFIER DANS LA BDD *
=================================================
 */

/**
 * fonction qui rajoute dans la BDD une recette avec son nom, texte et photo
 */
function ajouterRecette($nomRecette, $texteRecette, $photoRecette) {

    try {
    $query = "INSERT INTO recette (nom, texte, photo) VALUES (:nom, :texte, :photo)" ;

    $statement = $this->pdo->prepare($query);

    // remplacement des valeurs avec les parametres
    $statement->bindValue(':nom', $nomRecette) ;
    $statement->bindValue(':texte', $texteRecette) ;
    $statement->bindValue(':photo', $photoRecette) ;

    $statement->execute();

    } catch(\Exception $ex){
        die("Erreur insertion recette : " . $ex->getMessage());
    }

}

}


