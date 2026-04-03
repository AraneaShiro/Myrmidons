<?php
require_once "../DB/SQLfct.php";
class Recette
{
    private $db;
    public function __construct()
    {
        $this->db = new SQLfct();
    }


    public function generateRecetteTagList($id)
    {
        $taglist = $this->db->rechercherTagsDansRecette($id);
        echo '<div class="tags-section">
                    <label>Tags :</label>
                    <div class="tags-row" id="tagsRowRecette">';
        foreach ($taglist as $tag) {
            $nom = htmlspecialchars($tag['nom']);
            echo '<p class="' . $nom . '">' . $nom . '</p>';
        }
        echo '</div>
            </div>';
    }

    public function generateRecetteIngredientList($id)
    {
        $ingredientList = $this->db->rechercherIngredientsDansRecette($id);
        echo '<div class="card__list">
                            <h3>Liste Ingrédients</h3>
                            <ul>';
        foreach ($ingredientList as $ingredient) {
            $img = htmlspecialchars($ingredient['photo']);
            $nom = htmlspecialchars($ingredient['nom']);
            echo '<li><img class="IngPicture" src="' . $img . '" alt="image ingredient">' . $nom . '</li>';
        }
        echo ' </ul>
            </div>';
    }

    public function generateRecetteCard($id)
    {
        $recette = $this->db->rechercherRecetteParID($id);
        $img = htmlspecialchars($recette["photo"]);
        $nom = htmlspecialchars($recette["nom"]);
        $description = htmlspecialchars($recette["texte"]);
        echo '<div class="card">
                <div class="adminButton">
                    <button class="ModifRecette btn-outline-warning">Modifier</button>
                    <button class="DeleteRecette btn-outline-danger">Supprimer</button>

                </div>
                <!-- LIGNE HAUTE -->
                <div class="card__top">
                    <!-- IMAGE -->
                    <div class="card__image">
                        <img src="' . $img . '" alt="Image du plat" />
                    </div>

                    <!-- TITRE + LISTE -->
                    <div class="card__right">

                        <div class="card__title">
                            <h2>' . $nom . '</h2>

                        </div>';
        $this->generateRecetteTagList($id);
        $this->generateRecetteIngredientList($id);
        echo '</div>
                </div>

                <!-- LIGNE BASSE : DESCRIPTION -->
                <div class="card__desc">
                    <h3>Description</h3>
                    <p>' . $description . '</p>
                </div>
                <h6 class="IdRecette">' . $id . '</h6>
            </div>';
    }
}