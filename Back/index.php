<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once 'Template.php';
    require_once "AdminLogger.php";
    require_once "RechercheForm.php";
    require_once "AddContent.php";
    session_start();
    $recherche = new RechercheForm();
    $addition = new AddContent();
?>
<?php ob_start() ?>
    <!-- Barre de recherche en haut-->
    <div id="searchBar">
        <?php $recherche->generateRecetteForm()?>
    </div>
    <!-- Wrapper principal -->
    <div id="mainWrapper">
        <!-- Partie gauche-->
        <div id="leftContainer">
            <!-- Wrapper des filtres de recherche -->
            <div id="filterContent">
                <!-- Filtre ingrédient -->
                <div>
                    <?php $recherche->generateIngredientForm()?>
                </div>
                <!-- Filtre tag -->
                <div>
                    <?php $recherche->generateTagForm()?>
                </div>
            </div>
            <!-- Partie admin d'ajout et suppression tag et ing-->
            <div class="adminCrud" id="IngTagCrud">
                <?php if(isset($_SESSION['nickname'])):?>
                <!-- Partie Tag -->
                <div id="CrudTag">
                    <?php 
                        $addition->generateTagDeleteForm();
                        $addition->generateTagAdditionForm();
                    ?>
                </div>
                <!-- Partie ingrédient -->
                <div id="CrudIng">
                    <?php $addition->generateIngredientAddForm(); ?>
                    <div>
                    <button class="btn" id="AddRecetteForm">Add recette</button>
                </div>
                </div>
                <?php endif ?>
            </div>   
        </div>
        <!-- Partie droite -->
        <div class="mainContentWrapper">
            <?php echo '' ?>
            <!-- Filtre appliqué -->
            <div class="DisplayFilter">
                <div>Tags:
                    <div id="filterDisplayTag"></div>
                </div>
                <div>Ingrédients:
                    <div id="filterDisplayIng"></div>
                </div>
            </div>
            <!-- Montre les résultats -->
            <div class="showResult">
                <link rel="stylesheet" href="css/inputRecette.css">
                <div class="page">
                    <?php $addition->generateRecetteAddForm() ?>
                </div>
            </div>
        </div>
    </div>
<?php $content=ob_get_clean() ?>
<?php Template::render($content) ?>
