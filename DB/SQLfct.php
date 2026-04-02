<?php

class SQLfct {

    private $db_name = "myrmidonsBDD";
    private $db_host = "127.0.0.1";
    private $db_port = "3306";

    private $db_user = "root";
    private $db_pwd = "";

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

/*
------------------------
   * RECHERCHE ALL *
------------------------
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
 * fonction qui donne toutes les ingredients existantes
 */
function rechercherIngredientAll() {

    try {
    $query =    "SELECT * FROM ingredient
                ORDER BY nom DESC" ;

    $statement = $this->pdo->prepare($query);

    $statement->execute();

    return $statement->fetchAll();
    } catch(\Exception $ex){
        die("Erreur rechercherIngredientAll : " . $ex->getMessage()) ;
}
}

/**
 * fonction qui donne toutes les tags existantes
 */
function rechercherTagAll() {

    try {
    $query =    "SELECT * FROM tag
                ORDER BY nom DESC" ;

    $statement = $this->pdo->prepare($query);

    $statement->execute();

    return $statement->fetchAll();
    } catch(\Exception $ex){
        die("Erreur rechercherTagAll : " . $ex->getMessage()) ;
}
}

/*
-------------------------
 * RECHERCHE SPECIFIQUE *
-------------------------
 */

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

/**
 * fonction qui recherche les recettes contenants le tag
 */
function rechercherRecettesParTag($tagNom) {

    try {
    $query =    "SELECT * FROM recette
                JOIN recetteTag ON recetteTag.recetteID = recette.recetteID
                WHERE recetteTag.tagNom = :tagNom
                ORDER BY recette.nom DESC" ;

    $statement = $this->pdo->prepare($query);

    // remplacement des valeurs avec les parametres
    $statement->bindValue(':tagNom',   $tagNom) ;

    $statement->execute();

    return $statement->fetchAll();

    } catch(\Exception $ex){
        die("Erreur rechercherRecettesParTag : " . $ex->getMessage()) ;
}
}

/**
 * fonction qui recherche les recettes contenants l'ingredient
 */
function rechercherRecettesParIngredient($ingredientID) {

    try {
    $query =    "SELECT * FROM recette
                JOIN recetteIngredient ON recetteIngredient.recetteID = recette.recetteID
                WHERE recetteIngredient.ingredientID = :ingredientID
                ORDER BY recette.nom DESC" ;

    $statement = $this->pdo->prepare($query);

    // remplacement des valeurs avec les parametres
    $statement->bindValue(':ingredientID',   $ingredientID) ;

    $statement->execute();

    return $statement->fetchAll();

    } catch(\Exception $ex){
        die("Erreur rechercherRecettesParIngredient : " . $ex->getMessage()) ;
}
}

/**
 * donne tous les ingrédients qui sont dans la recette
 */
function rechercherIngredientsDansRecette($recetteID) {
    try{
    $query =    "SELECT * FROM ingredient
                JOIN recetteIngredient ON recetteIngredient.ingredientID = ingredient.ingredientID
                WHERE recetteIngredient.recetteID = :recetteID
                ORDER BY ingredient.nom DESC" ;
      
    $statement = $this->pdo->prepare($query);

    // remplacement des valeurs avec les parametres
    $statement->bindValue(':recetteID',   $recetteID) ;

    $statement->execute();

    return $statement->fetchAll();

} catch(\Exception $ex){
        die("Erreur rechercherRecettesParIngredient : " . $ex->getMessage()) ;
}
}

/**
 * donne tous les tags qui sont dans la recette
 */
function rechercherTagsDansRecette($recetteID) {
    try{
    $query =    "SELECT * FROM tag
                JOIN recetteTag ON recetteTag.tagNom = tag.tagNom
                WHERE recetteTag.recetteID = :recetteID
                ORDER BY tag.nom DESC" ;
      
    $statement = $this->pdo->prepare($query);

    // remplacement des valeurs avec les parametres
    $statement->bindValue(':recetteID',   $recetteID) ;

    $statement->execute();

    return $statement->fetchAll();
    
} catch(\Exception $ex){
        die("Erreur rechercherTagsParIngredient : " . $ex->getMessage()) ;
}
}

/**
 * fonction qui donne les recettes qui possèdent tous les ingrédients des IngredientID donnés
 */
function rechercherRecettesAvecIngredients($tabIngredientsRechercheID) {

    $allRecettes = $this->rechercherRecettesAll();

    $tabRecetteValide = [];

    foreach($allRecettes as $currentRecette) {

        //tous les ingrédients de cette recette
        $ingredientsRecette = $this->rechercherIngredientsDansRecette(  $currentRecette['recetteID']   );

        //on garde juste les ID des ingredients dans la recette
        $tabIngredientsID = array_column($ingredientsRecette, 'ingredientID');

        $contientTout = true;

        //chaque ingredient des ingredients recherchés
        foreach($tabIngredientsRechercheID as $currentIngredientID) {

            //si 1 des ingrédients est manquant
            if(!in_array($currentIngredientID, $tabIngredientsID)) {
                $contientTout = false;
                break;
            }

        }

        //si la recette possède tous les ingredients, on le rajoute
        if($contientTout) $tabRecetteValide[] = $currentRecette;


    }

    return $tabRecetteValide;

}

/*
--------------------
  * RECHERCHE ID *
--------------------
 */

/**
 *  fonction qui donne une recette en utilisant son ID
 */ 
function rechercherRecetteParID($recetteID) {

    try{
        $query =  "SELECT * FROM recette
                WHERE recetteID = :recetteID";

        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':recetteID', $recetteID) ;

        $statement->execute();

        return $statement->fetch();

} catch(\Exception $ex){
        die("Erreur rechercherRecetteParID : " . $ex->getMessage()) ;
}

}

/**
 * fonction qui donne un ingredient en utilisant son ID
 */ 
function rechercherIngredientParID($ingredientID) {

    try{
        $query = "SELECT * FROM ingredient
                WHERE ingredientID = :ingredientID";

        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':ingredientID', $ingredientID);

        $statement->execute();

        return $statement->fetch();

    } catch(\Exception $ex){
        die("Erreur rechercherIngredientParID : " . $ex->getMessage());
    }
}

/**
 * fonction qui donne un tag en utilisant son ID
 */ 
function rechercherTagParNom($tagNom) {

    try{
        $query = "SELECT * FROM tag
                WHERE nom = :tagNom";

        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':tagNom', $tagNom);

        $statement->execute();

        return $statement->fetch();

    } catch(\Exception $ex){
        die("Erreur rechercherTagParNom : " . $ex->getMessage());
    }
}


/* 
=======================================================================
 * FONCTIONS POUR AJOUTER/SUPPRIMER/LIER/DELIER/MODIFIER DANS LA BDD *
=======================================================================
 */

/*
---------------
  * AJOUTER *  
---------------
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
---------------
 * SUPPRIMER *  
---------------
*/


/**
 * fonction qui supprime dans la BDD une recette avec son ID
 */
function supprimerRecette($idRecette) {

    try {
    $query = "DELETE 
            FROM recette 
            WHERE recetteID = :recetteID" ;

    $statement = $this->pdo->prepare($query);

    // remplacement des valeurs avec les parametres
    $statement->bindValue(':recetteID', $idRecette) ;


    $statement->execute();

    } catch(\Exception $ex){
        die("Erreur supprimer recette : " . $ex->getMessage());
    }

}

/**
 * fonction qui supprime dans la BDD un ingredient avec son nom
 */
/*
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
*/

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

/*
----------------
    * LIER *  
----------------
*/

/**
 * fonction pour lier une recette & un ingredient
 * on donnera les ID
 */
function lierRecetteIngredient($recetteID, $ingredientID) {

    try {
        $query = "INSERT INTO recetteIngredient (recetteID, ingredientID) 
                VALUES (:recetteID, :ingredientID)";
        
        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':recetteID', $recetteID);
        $statement->bindValue(':ingredientID', $ingredientID);

        $statement->execute();

    } catch(\Exception $ex) {
        die("Erreur liaison recette-ingredient : " . $ex->getMessage());
    }

}

/**
 * fonction pour lier une recette & un tag
 * on donnera les ID
 */
function lierRecetteTag($recetteID, $tagNom) {

    try {
        $query = "INSERT INTO recetteTag (recetteID, tagNom) 
                VALUES (:recetteID, :tagNom)";
        
        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':recetteID', $recetteID);
        $statement->bindValue(':tagNom', $tagNom);

        $statement->execute();

    } catch(\Exception $ex) {
        die("Erreur liaison recette-tag : " . $ex->getMessage());
    }

}

/*
---------------
  * DELIER *  
---------------
*/

/**
 * fonction qui permet d'enlever la connexion entre une recette et un ingredient
 */
function delierRecetteIngredient($recetteID, $ingredientID) {

    try {
        $query =    "DELETE FROM recetteIngredient 
                    WHERE recetteID = :recetteID 
                    AND ingredientID = :ingredientID";

        $statement = $this->pdo->prepare($query);


        $statement->bindValue(':recetteID', $recetteID);
        $statement->bindValue(':ingredientID', $ingredientID);
        
        $statement->execute();

    } catch(\Exception $ex) {
        die("Erreur deliaison recette-ingredient : " . $ex->getMessage());
    }
}



/**
 * fonction qui permet d'enlever la connexion entre une recette et un tag
 */
function delierRecetteTag($recetteID, $tagNom) {

    try {
        $query =    "DELETE FROM recetteTag
                    WHERE recetteID = :recetteID 
                    AND tagNom = :tagNom";

        $statement = $this->pdo->prepare($query);


        $statement->bindValue(':recetteID', $recetteID);
        $statement->bindValue(':tagNom', $tagNom);
        
        $statement->execute();

    } catch(\Exception $ex) {
        die("Erreur deliaison recette-tag : " . $ex->getMessage());
    }
    
}

/*
----------------
  * MODIFIER *  
----------------
*/

function modifierRecette($recetteID, $nom, $texte, $photo) {

    try {
        $query = "UPDATE recette 
                SET nom = :nom,
                texte = :texte,
                photo = :photo
                WHERE recetteID = :recetteID";
        
        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':recetteID', $recetteID);

        $statement->bindValue(':nom', $nom);
        $statement->bindValue(':texte', $texte);
        $statement->bindValue(':photo', $photo);

        $statement->execute();

    } catch(\Exception $ex) {
        die("Erreur modifierRecette : " . $ex->getMessage());
    }

}

function modifierIngredient($ingredientID, $nom, $photo) {

    try {
        $query = "UPDATE ingredient
                SET nom = :nom,
                photo = :photo
                WHERE ingredientID = :ingredientID";
        
        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':ingredientID', $ingredientID);

        $statement->bindValue(':nom', $nom);
        $statement->bindValue(':photo', $photo);

        $statement->execute();

    } catch(\Exception $ex) {
        die("Erreur modifierIngredient : " . $ex->getMessage());
    }

}

function modifierTag($tagNom, $newNom) {

    try {
        $query = "UPDATE tag
                SET nom = :nom
                WHERE nom = :tagNom";
        
        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':tagNom', $tagNom);
        $statement->bindValue(':nom', $newNom);


        $statement->execute();

    } catch(\Exception $ex) {
        die("Erreur modifierTag: " . $ex->getMessage());
    }

}



}









