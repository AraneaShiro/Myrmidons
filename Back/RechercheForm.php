<?php
require_once "../DB/SQLfct.php";
// generation des formulaires pour la recherche
class RechercheForm{
    private $db;

    public function __construct() {
        $this->db = new SQLfct();
    }
    public function generateRecetteForm(){
        $motRecherche = htmlspecialchars($_GET['recette'] ?? '');
        echo '<input class="inputText" type="text" name="recette" placeholder="Recette ..." value="' . $motRecherche . '">';
        if($motRecherche != ''){
            $recettes = $this->db->rechercherRecettes($motRecherche);
            echo '<select class="RecetteSelect" name="recette">';
            foreach($recettes as $recette){
                $nom = htmlspecialchars(($recette['nom']));
                $id = htmlspecialchars(($recette['id']));
                echo "<option value=\"{$id}\">{$nom}</option>";
            }
            echo '</select>';
        }
        echo '<button id="btnSearch">Recherche</button>';
    }

    public function generateIngredientForm(){
        $ingredients = $this->db->rechercherIngredientAll();
        echo '<label for="Ingredient">Ingredient</label>
            <select class="IngredientSelect" name="ingredient">';
        foreach ($ingredients as $ingredient){
            $nom = htmlspecialchars($ingredient['nom']);
            $id = htmlspecialchars($ingredient['id']);
            echo "<option value=\"{$id}\">{$nom}</option>";
        }
        echo '</select>
        <button id="AddIngredient" class="btn">Add Ingredient</button>';
    }

    public function generateTagForm(){
        $tags = $this->db->rechercherIngredientAll();
        echo '<label for="Tag">Tag</label><select class="TagSelect" name="tag">';
        foreach ($tags as $tag){
            $nom = htmlspecialchars($tag['nom']);
            $id = htmlspecialchars($tag['id']);
            echo "<option value=\"{$id}\">{$nom}</option>";
        }
        echo '</select><button id="AddTag" class="btn">Add Tag</button>';
    }

}