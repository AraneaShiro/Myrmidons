<?php

require_once "../DB/SQLfct.php";
//classe pour ajouter des contenus (recettes / tags / ingrédients)
class AddContent{
    private $db;
    public function __construct() {
        $this->db = new SQLfct();
    }


    // fonction pour generer le formulaire d'ajout de tags
    public function generateTagAdditionForm(){
        echo '<label for="NamenewTag">NewTagName</label>
            <input type="text" id="NewTagInput" class="form-control">
            <button class="btn" id="AddNewTag">+</button>';
    }

    // fonction pour generer le formulaire de suppression des tags
    public function generateTagDeleteForm(){
        $tags = $this->db->rechercherIngredientAll();
        echo '<label for="Tag">Tag</label>
        <select name="tagSelection" id="tagDeleteSelection">
        <option value="" disabled selected>-- Choisir un tag --</option>
        <option value="test" class="TagSelect"> test</option>'; //Ligne pour les tests
        foreach ($tags as $tag){
            $nom = htmlspecialchars($tag['nom']);
            echo "<option value=\"{$nom}\">{$nom}</option>";
        }
        echo '</select>
        <button class="btn btn-warning btn-sm" id="DeleteTag">-</button>';
    }

    // fonction pour generer le formulaire d'ajout d'ingrédient
    public function generateIngredientAddForm(){
        echo '
        <div class="input-group mb-3">
        <label for="NamenewIng" class="input-group-text">New Ingredient name</label>
                    <input type="text" id="NewIngIput" placeholder="Tomate">
                    <input type="file" class="form-control" id="imgInputIng" name="imgInputIng">
                    <button class="btn btn-success btn-sm" id="AddNewIng">+</button>
        </div>'; 
    }


    public function addTag($tag){
        if($tag != ""){
            $this->db->ajouterTag($tag);
        } else{
            echo "<div id='error'>Tag vide !</div>";
        }
    }

    public function addIngredient($ingredient){
        if($ingredient != ""){
            $this->db->ajouterIngredient($ingredient);
        } else{
            echo "<div id='error'>Ingredient vide !</div>";
        }
    }

    public function addRecette($recette, $texteRecette, $photoRecette){
        if($recette != "" && $texteRecette != "" && $photoRecette != ""){
            $this->db->ajouterRecette($recette, $texteRecette, $photoRecette);
        } else{
            if($recette ==""){
                echo "<div id='error'>Nom de recette vide !</div>";
            }
            if($photoRecette == ""){
                echo "<div id='error'>Entrez un fichier!</div>";
            }
            if($texteRecette=""){
                echo "<div id='error'>Description vide !</div>";
            }
        }
    }

    //Fonction qui genere l'input de l image pour la recette
    public function generateImgForm(){
    echo '<div class="image-zone">
        <div class="image-preview" id="imagePreview"
            onclick="document.getElementById(\'imgFileInput\').click()">
            <div class="image-placeholder" id="imgPlaceholder">
                <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <rect x="3" y="3" width="18" height="18" rx="3" />
                    <circle cx="8.5" cy="8.5" r="1.5" />
                    <path d="M21 15l-5-5L5 21" />
                </svg>
                <span>Cliquer pour choisir une image</span>
            </div>
        </div>
        <input type="file" id="imgFileInput" accept="image/*" />
        <button class="btn-img btn" onclick="document.getElementById(\'imgFileInput\').click()">📁
            Choisir une image</button>
        <div class="error-msg" id="errImg">Veuillez sélectionner une image valide.</div>
    </div>';
}


    // fonction qui genere le formulaire pour ajouter des tags à une recette lors de sa creation
    public function generateTagListAdd(){
        $tags = $this->db->rechercherIngredientAll();
        echo   '<label>Tags</label>
                <div class="tags-row" id="tagsRow">
                    <span>Aucun tag ajouté</span>
                </div>
                <select id="tagInput">
                    <option value="" disabled selected>-- Choisir un tag --</option>
                    <option value="test" class="TagSelect"> test</option>';//Ligne pour les tests
        foreach ($tags as $tag){
            $nom = htmlspecialchars($tag['nom']);
            $id = htmlspecialchars($tag['id']);
            echo "<option value=\"{$id}\">{$nom}</option>";
        }
        echo '</select>
            <button class="btn-add-tag" id="btnAddTag">+ Ajouter</button>
            
            ';
    }

        // fonction qui genere le formulaire pour ajouter des ingredients à une recette lors de sa creation

    public function generateIngredientList(){
        $ingredients = $this->db->rechercherIngredientAll();
        echo'
        <label>Liste Ingrédients</label>
        <div class="ing-grid" id="ingGrid"></div>
        <select id="ingSelect">
                <option value="" disabled selected>-- Choisir un ingrédient --</option>
                <option value="test" class="TagSelect"> test</option>';//Ligne pour les tests
        foreach ($ingredients as $ingredient){ 
            $nom = htmlspecialchars($ingredient['nom']);
            $id = htmlspecialchars($ingredient['id']);
            echo "<option value=\"{$id}\">{$nom}</option>";
        }
        echo '</select>
            <button class="btn-add-ing btn" id="btnAddIng">+ Ajouter un ingrédient</button>
            <div class="error-msg" id="errIng">Ajoutez au moins un ingrédient.</div>
        ';
    }
 
        // fonction qui genere le formulaire pour ajouter la description à une recette lors de sa creation

    public function generateDescriptionForm(){
        echo '<div class="desc-section" id="descSection">
                        <label>Description</label>
                        <textarea id="inputDesc" placeholder="Décrivez votre recette..." rows="4"></textarea>
                        <div class="error-msg" id="errDesc">La description est requise.</div>
                </div>';
    }

    //     // fonction qui genere le formulaire de creation d'une recette

    public function generateRecetteAddForm(){
        echo '<!-- TITRE -->
        <div class="page" id="FormRecette">
                <div class="recipe-title-wrap">
                    <input type="text" id="inputTitle" placeholder="Nom recette" maxlength="80" />
                    <div class="error-msg" id="errTitle">Le nom de la recette est requis.</div>
                </div>
                <!-- CONTENU PRINCIPAL -->
                <div class="main-content">

                <!-- IMAGE -->
                <div class="image-zone">';
        $this->generateImgForm();
        echo '</div>
                <!-- INFOS DROITE -->
                <div class="info-right">
                    <!-- TAGS recette : select peuplé par PHP -->
                    <div class="tags-section">
                        <label>Tags</label>
                        <div class="tags-row" id="tagsRow">
                            <span>Aucun tag ajouté</span>
                        </div>
                        <div class="tag-add-row">';
        $this->generateTagListAdd();
        echo '</div>
                <div class="error-msg" id="errTag">Veuillez sélectionner un tag.</div>
                </div>
                <!-- INGRÉDIENTS recette : select peuplé par PHP -->
                <div class="ing-section">';
        $this->generateIngredientList();
        echo '</div>
                </div>
                </div>
                    <!-- DESCRIPTION -->';
        $this->generateDescriptionForm();
        echo '
        <!-- ID -->
        <h6 id="IdContainer"></h6>
            <!-- SUBMIT -->
            <div class="submit-row">
            <button class="btn-submit btn" id="btnSubmit">Enregistrer la recette</button>
            </div> </div>'
            ;
    }
}