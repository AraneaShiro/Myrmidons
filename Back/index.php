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
<p>HELLO</p>
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
            <link rel="stylesheet" href="../Front/css/inputRecette.css">

            <?php $addition->generateRecetteAddForm() ?>
            <link rel="stylesheet" href="../Front/css/carte.css">
            <div class="card">

                <!-- LIGNE HAUTE -->
                <div class="card__top">
                    <button class="ModifRecette">Modifier</button>
                    <button class="DeleteRecette">Supprimer</button>

                    <!-- IMAGE -->
                    <div class="card__image">
                        <img src="../image/pateCarbo.jpg" alt="Image du plat" />
                    </div>

                    <!-- TITRE + LISTE -->
                    <div class="card__right">

                        <div class="card__title">
                            <h2>Nom recette</h2>

                        </div>
                        <div class="tags-section">
                            <label>Tags :</label>
                            <div class="tags-row" id="tagsRowRecette">
                                <p class="tag">test</p>
                                <p class="tag">test2</p>
                            </div>


                        </div>
                        <div class="card__list">
                            <h3>Liste Ingrédients</h3>
                            <ul>
                                <li><span class="dot"></span> Ing1</li>
                                <li><span class="dot"></span> Ing1</li>
                                <li><span class="dot"></span> Ing1</li>
                                <li><span class="dot"></span> Ing1</li>
                                <li><span class="dot"></span> Ing1g</li>
                                <li><span class="dot"></span> Ing1</li>
                                <li><span class="dot"></span> Ing1</li>
                                <li><span class="dot"></span> Ing1</li>
                            </ul>
                        </div>

                    </div>
                </div>

                <!-- LIGNE BASSE : DESCRIPTION -->
                <div class="card__desc">
                    <h3>Description</h3>
                    <p>
                        dsifjskldffgjnklgjfkldjgdfklgjdfklgjdfkljgdfklgjdfogjd[fkgjdo[hkndogjd[js[ejfs[ofgknsd[ofsd[ofjsokgdfnokgdfnokgldfngkldgdkfgkdfngkndkgdfngldnkglkfdgkldjnmgdklfgndflkjgdfokgjdfklgdfjgldkjgdklf]]]]]]]
                    </p>

                </div>
                <!-- ID n'apparait que en mode admin-->
                <h6 class="IdRecette">55248</h6>
            </div>
        </div>
    </div>
</div>

<script src="../script/filter.js"></script>
<script src="../script/CRUD.js"></script>
<?php $content=ob_get_clean() ?>
<?php Template::render($content) ?>