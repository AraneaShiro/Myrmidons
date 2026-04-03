<?php
require_once "../DB/SQLfct.php";
// generation des formulaires pour la recherche
class RechercheForm
{
    private $db;

    public function __construct()
    {
        $this->db = new SQLfct();
    }
    public function generateRecetteForm()
    {
        $motRecherche = htmlspecialchars($_GET['recette'] ?? '');
        echo '<input class="inputText form-control" id="searchBarInput" type="text" name="recette" placeholder="Recette ..." value="' . $motRecherche . '">';
        if ($motRecherche != '') {

            ///?????????????????? PK ???????????? c est la barre de recherche
            $recettes = $this->db->rechercherRecettes($motRecherche);
            echo '<select class="RecetteSelect" name="recette">';
            foreach ($recettes as $recette) {
                $nom = htmlspecialchars(($recette['nom']));
                $id = htmlspecialchars(($recette['id']));
                echo "<option value=\"{$id}\">{$nom}</option>";
            }
            echo '</select>';
        }
        echo '<button id="btnSearch" class="btn ml-2 btn-outline-light"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg></i></button>';
    }


    public function generateIngredientForm()
    {
        $ingredients = $this->db->rechercherIngredientAll();
        echo '
        <div class="topFiltre">
            <label for="Ingredient">Ingredient</label>
            <button id="AddIngredient" class="btn btn-secondary">Add Ingredient</button>
        </div>
        <div class="customDropdownWrapper">
            <input
                type="text"
                id="ingredientFilter"
                class="form-control"
                placeholder="Rechercher un ingrédient..."
                autocomplete="off"
            >
            <ul id="ingredientList" class="dropdownList">';
        foreach ($ingredients as $ingredient) {
            $nom = htmlspecialchars($ingredient['nom']);
            echo "<li data-value=\"{$nom}\">{$nom}</li>";
        }
        echo '
            </ul>
        </div>';
    }

    public function generateTagForm()
    {
        $tags = $this->db->rechercherTagAll();
        echo '
        <div class="topFiltre">
            <label for="Tag">Tag</label>
            <button id="AddTag" class="btn btn-secondary">Add Tag</button>
        </div>
        <div class="customDropdownWrapper">
            <input
                type="text"
                id="tagFilter"
                class="form-control"
                placeholder="Rechercher un tag..."
                autocomplete="off"
            >
            <ul id="tagList" class="dropdownList">';
        foreach ($tags as $tag) {
            $nom = htmlspecialchars($tag['nom']);
            echo "<li data-value=\"{$nom}\">{$nom}</li>";
        }
        echo '
            </ul>
        </div>';
    }

}