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
        echo '<div class="topFiltre"><label for="NamenewTag">NewTagName</label><button class="btn" id="AddNewTag">+</button></div>
        
            <input type="text" id="NewTagInput" class="form-control">
            ';
    }

    // fonction pour generer le formulaire de suppression des tags
    public function generateTagDeleteForm(){
        $tags = $this->db->rechercherTagAll();
        
        echo '<div class="topFiltre"><label for="Tag">Tag</label><button class="btn btn-warning btn-sm" id="DeleteTag">-</button>
        </div>
        <select name="tagSelection" id="tagDeleteSelection">
        <option value="" disabled selected>-- Choisir un tag --</option>
        <option value="test" class="TagSelect"> test</option>'; //Ligne pour les tests
        foreach ($tags as $tag){
            $nom = htmlspecialchars($tag['nom']);
            echo "<option value=\"{$nom}\">{$nom}</option>";
        }
        echo '</select>
        ';
    }

    // fonction pour generer le formulaire d'ajout d'ingrédient
    public function generateIngredientAddForm(){
        echo '
        <div class="input-group mb-3 topFiltre">
        <label for="NamenewIng" class="input-group-text">Nouvelle Ingredient</label>
        <button class="btn btn-success btn-sm" id="AddNewIng">+</button>
        </div>
                    <input type="text" id="NewIngIput" placeholder="Tomate">
                    <input type="file" class="form-control" id="imgInputIng" name="imgInputIng">
                    
        '; 
    }

    // fonction pour ajouter un tag à la base de données
    public function addTag($tag){
        if (!empty($tag)) {
            $this->db->ajouterTag($tag);
            return ['succes' => true, 'message' => 'Tag ajouté'];
        }
        return ['succes' => false, 'message' => 'Tag vide !'];
    }

    // fonction pour supprimer un tag de la base de données
    public function deleteTag($nom){
        if (!empty($nom)) {
            $this->db->supprimerTag($nom);
            return ['succes' => true, 'message' => 'Tag supprimé'];
        }
        return ['succes' => false, 'message' => 'Aucun tag sélectionné'];
    }

    // fonction pour ajouter un ingredient à la base de données
    public function addIngredient($ingredient, $photo = ''){
        if (!empty($ingredient)) {
            if (empty($photo)) {
                return ['succes' => false, 'message' => 'Photo de l\'ingrédient manquante !'];
            }
            $this->db->ajouterIngredient($ingredient);
            if (!empty($photo)) {
                $ing = $this->db->rechercherIngredientAll();
                foreach ($ing as $i) {
                    if ($i['nom'] === $ingredient) {
                        $this->db->modifierIngredient($i['ingredientID'], $ingredient, $photo);
                        break;
                    }
                }
            }
            return ['succes' => true, 'message' => 'Ingrédient ajouté'];
        }
        return ['succes' => false, 'message' => 'Ingrédient vide !'];
    }

    // fonction pour ajouter une recette à la base de données
    public function addRecette($nom, $texte, $photo = ''){
        if (empty($nom)) {
            return ['succes' => false, 'message' => 'Nom de recette vide !'];
        }
        if (empty($texte)) {
            return ['succes' => false, 'message' => 'Description vide !'];
        }
        if (empty($photo)) {
            return ['succes' => false, 'message' => 'Photo de la recette manquante !'];
        }
        $this->db->ajouterRecette($nom, $texte, $photo);
        return ['succes' => true, 'message' => 'Recette ajoutée'];
    }

    // fonction pour modifier une recette existante dans la base de données
    public function modifierRecette($id, $nom, $texte, $photo){
        if (empty($nom)) {
            return ['succes' => false, 'message' => 'Nom de recette vide !'];
        }
        $this->db->modifierRecette(intval($id), $nom, $texte, $photo);
        return ['succes' => true, 'message' => 'Recette modifiée'];
    }

    // fonction pour supprimer une recette dans la base de données
    public function deleteRecette($id){
        if (empty($id)) {
            return ['succes' => false, 'message' => 'ID manquant'];
        }
        $this->db->supprimerRecette(intval($id));
        return ['succes' => true, 'message' => 'Recette supprimée'];
    }

    // fonction pour gestion de l'upload d'une photo
    public function uploadPhoto($fileKey){
        if (!empty($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] == 0) {
            $file       = $_FILES[$fileKey];
            $dirImg     = "../image/";
            if (!is_dir($dirImg)) mkdir($dirImg); // crée le dossier si besoin
            $nomFichier = basename($file['name']); // sécurise le nom
            move_uploaded_file($file['tmp_name'], $dirImg . $nomFichier);
            return $nomFichier;
        }
        return '';
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
        $tags = $this->db->rechercherTagAll();
        echo   '<label>Tags</label>
                <div class="tags-row" id="tagsRow">
                    <span>Aucun tag ajouté</span>
                </div>
                <select id="tagInput">
                    <option value="" disabled selected>-- Choisir un tag --</option>
                    <option value="test" class="TagSelect"> test</option>';//Ligne pour les tests
        foreach ($tags as $tag){
            $nom = htmlspecialchars($tag['nom']);
            $id = htmlspecialchars($tag['tagID']);
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
            $id = htmlspecialchars($ingredient['ingredientID']);
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