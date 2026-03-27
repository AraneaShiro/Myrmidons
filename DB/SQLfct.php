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

/**
 * fonction qui recherche les mots qui ressemble à celui donner
 */
function rechercherRecettes($motRecherche) {

    try {
    $query =    "SELECT * FROM recette
                WHERE nom 
                LIKE :motRecherche 
                ORDER BY nom DESC" ;

    $statement = $this->pdo->prepare($query);

    // remplacement des valeurs avec les parametres
    $statement->bindValue(':motRecherche',   "%".$motRecherche."%") ;

    $statement->execute();

    return $statement->fetchAll();

    } catch(\Exception $ex){
        die("Erreur rechercherRecettes : " . $ex->getMessage()) ;
}
}

/* 
=================================================
 * FONCTIONS POUR CREER OU MODIFIER DANS LA BDD *
=================================================
 */

/*
===============
  * AJOUTER *  
===============
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

/**
 * fonction qui rajoute dans la BDD un ingrédient avec son nom
 */
function ajouterIngredient($nomIngredient) {

    try {
    $query = "INSERT INTO ingredient (nom) VALUES (:nom)" ;

    $statement = $this->pdo->prepare($query);

    // remplacement des valeurs avec les parametres
    $statement->bindValue(':nom', $nomIngredient) ;

    $statement->execute();

    } catch(\Exception $ex){
        die("Erreur insertion ingredient : " . $ex->getMessage());
    }

}

/**
 * fonction qui rajoute dans la BDD un tag avec son nom
 */
function ajouterTag($nomTag) {

    try {
    $query = "INSERT INTO tag (nom) VALUES (:nom)" ;

    $statement = $this->pdo->prepare($query);

    // remplacement des valeurs avec les parametres
    $statement->bindValue(':nom', $nomTag) ;

    $statement->execute();

    } catch(\Exception $ex){
        die("Erreur insertion tag : " . $ex->getMessage());
    }
}

/*
===============
 * SUPPRIMER *  
===============
*/


/**
 * fonction qui supprime dans la BDD une recette avec son nom
 */
function supprimerRecette($nomRecette) {

    try {
    $query = "DELETE 
            FROM recette 
            WHERE nom = :nom" ;

    $statement = $this->pdo->prepare($query);

    // remplacement des valeurs avec les parametres
    $statement->bindValue(':nom', $nomRecette) ;


    $statement->execute();

    } catch(\Exception $ex){
        die("Erreur supprimer recette : " . $ex->getMessage());
    }

}

/**
 * fonction qui supprime dans la BDD un ingredient avec son nom
 */
function supprimerIngredient($nomIngredient) {

    try {
    $query = "DELETE 
            FROM ingredient 
            WHERE nom = :nom" ;

    $statement = $this->pdo->prepare($query);

    // remplacement des valeurs avec les parametres
    $statement->bindValue(':nom', $nomIngredient) ;


    $statement->execute();

    } catch(\Exception $ex){
        die("Erreur supprimer ingredient : " . $ex->getMessage());
    }

}

/**
 * fonction qui supprime dans la BDD un tag avec son nom
 */
function supprimerTag($nomTag) {

    try {
    $query = "DELETE 
            FROM tag 
            WHERE nom = :nom" ;

    $statement = $this->pdo->prepare($query);

    // remplacement des valeurs avec les parametres
    $statement->bindValue(':nom', $nomTag) ;


    $statement->execute();

    } catch(\Exception $ex){
        die("Erreur supprimer tag : " . $ex->getMessage());
    }

}





}


