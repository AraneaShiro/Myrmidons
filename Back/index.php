<?php
    ob_start(); // capture tout output (warnings, erreurs) avant les headers JSON
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
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        ob_clean(); // vide le buffer avant d'envoyer le JSON

        // Traitement du login (username + password)
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $logger = new AdminLogger();
            $result = $logger->log($_POST['username'], $_POST['password']);
            if($result['granted']){
                $_SESSION['nickname'] = $result['username'];
                // Rediriger pour éviter la resoumission du formulaire
                header("Location: index.php");
                exit();
            } else {
                // Stocker l'erreur en session pour l'afficher dans le formulaire
                $_SESSION['login_error'] = $result['error'];
                header("Location: index.php");
                exit();
            }
        }
        
        // Sécurité : tous les autres POST nécessitent d'être admin connecté
        if (!isset($_SESSION['nickname'])) {
            header('Content-Type: application/json');
            echo json_encode(['succes' => false, 'message' => 'Non autorisé']);
            exit();
        }
        
        // Supprimer une recette
        if (isset($_POST['DeletedId'])) {
            $id = intval($_POST['DeletedId']); // cast int
            $resultat = $addition->deleteRecette($id);
            header('Content-Type: application/json');
            echo json_encode($resultat);
            exit();
        }
        
        // Ajouter un tag 
        if (isset($_POST['newTags']) && !isset($_POST['newTitle'])) {
            $nom = htmlspecialchars($_POST['newTags']);
            $resultat = $addition->addTag($nom);
            header('Content-Type: application/json');
            echo json_encode($resultat);
            exit();
        }
        
        // Supprimer un tag 
        if (isset($_POST['DeletedTags'])) {
            $nom = htmlspecialchars($_POST['DeletedTags']);
            $resultat = $addition->deleteTag($nom);
            header('Content-Type: application/json');
            echo json_encode($resultat);
            exit();
        }
        
        // Ajouter un ingrédient
        if (isset($_POST['NewIng'])) {
            $nom      = htmlspecialchars($_POST['NewIng']);
            $photo    = $addition->uploadPhoto('imgInputIng');
            // DEBUG temporaire : renvoie ce que PHP reçoit directement dans le JSON
            header('Content-Type: application/json');
            echo json_encode([
                'debug_post'  => $_POST,
                'debug_files' => $_FILES,
                'photo'       => $photo
            ]);
            exit();
        }
        
        // Ajouter / Modifier une recette
        if (isset($_POST['newTitle'])) {
            $nom = htmlspecialchars($_POST['newTitle'] ?? '');
            $texte = htmlspecialchars($_POST['newIngredients'] ?? '');
            $idRecette = trim($_POST['newId'] ?? '');
            $photo = $addition->uploadPhoto('imgFileInput');
            if (!empty($idRecette)) {
                // Modification d'une recette existante
                $resultat = $addition->modifierRecette($idRecette, $nom, $texte, $photo);
            } else {
                // Nouvelle recette
                $resultat = $addition->addRecette($nom, $texte, $photo);
            }
            header('Content-Type: application/json');
            echo json_encode($resultat);
            exit();
        }
        
        // POST non reconnu
        header('Content-Type: application/json');
        echo json_encode(['succes' => false, 'message' => 'Action inconnue']);
        exit();
    }
    
    // Récupérer l'erreur de login pour l'afficher si elle existe
    $login_error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : null;
    unset($_SESSION['login_error']); // Supprimer l'erreur après l'avoir récupérée
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
            <div class="filterIng">
                <?php $recherche->generateIngredientForm()?>
            </div>

            <!-- Filtre tag -->
            <div class="filterIng">
                <?php $recherche->generateTagForm()?>
            </div>
        </div>
        <hr>

        <!-- Partie admin d'ajout et suppression tag et ing-->

        <div class="filterContent" id="IngTagCrud">
            <?php if(isset($_SESSION['nickname'])):?>

            <!-- Partie Tag -->
            <div id="CrudTag">
                <div id="DeleteTagPart">
                    <?php 
                        $addition->generateTagDeleteForm();

                    ?>
                </div>
                <br>
                <div id="AddTagPart">
                    <?php 
                       
                        $addition->generateTagAdditionForm();
                    ?>
                </div>
            </div>
            <br>
            <!-- Partie ingrédient -->
            <div id="CrudIng">
                <?php $addition->generateIngredientAddForm(); ?>
                <br>
                <div>
                    <button class="btn btn-secondary" id="AddRecetteForm">Add recette</button>
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
            <div class="displayFil">Tags:
                <div id="filterDisplayTag" class="displayFil"></div>
            </div>
            <div class="displayFil">Ingrédients:
                <div id="filterDisplayIng" class="displayFil"></div>
            </div>
        </div>
        <!-- Montre les résultats -->
        <div class="showResult">


            <?php $addition->generateRecetteAddForm() ?>

            <div class="card">
                <div class="adminButton">
                    <button class="ModifRecette btn-outline-warning">Modifier</button>
                    <button class="DeleteRecette btn-outline-danger">Supprimer</button>

                </div>
                <!-- LIGNE HAUTE -->
                <div class="card__top">






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
                                <li><img class="IngPicture" src="../image/lasagne.jpg" alt=""></span>
                                    Ing1</li>

                                <li><img class="IngPicture" src="../image/lasagne.jpg" alt=""></span>
                                    Ing1</li>
                                <li><img class="IngPicture" src="../image/lasagne.jpg" alt=""></span>
                                    Ing1</li>
                                <li><img class="IngPicture" src="../image/lasagne.jpg" alt=""></span>
                                    Ing1</li>
                                <li><img class="IngPicture" src="../image/lasagne.jpg" alt=""></span>
                                    Ing1</li>
                            </ul>
                        </div>

                    </div>
                </div>

                <!-- LIGNE BASSE : DESCRIPTION -->
                <div class="card__desc">
                    <h3>Description</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas at sollicitudin eros, vitae
                        ultrices tellus. Nullam diam sem, tempus at hendrerit suscipit, aliquet sit amet arcu. Nulla vel
                        metus eu justo malesuada posuere eget ut orci. Praesent mi tellus, accumsan vel congue sit amet,
                        sodales lobortis nulla. Nunc ex odio, sodales eu arcu a, fermentum bibendum lectus. In congue
                        sed nibh pharetra sodales. Vivamus mollis purus massa, non sagittis quam finibus sed.

                        Duis quis diam at urna gravida pretium ut id purus. Donec a egestas est. Donec libero sapien,
                        molestie ut tristique vel, placerat eu nulla. Vivamus ac neque magna. Etiam malesuada elit
                        massa, vitae ornare dui egestas quis. Nulla ac quam eu nisi posuere condimentum. Sed faucibus ut
                        tellus quis cursus. Aliquam a lacus vestibulum, viverra velit non, varius justo. Donec quis
                        augue ornare, luctus lacus non, mattis risus. Etiam posuere faucibus metus. Interdum et
                        malesuada fames ac ante ipsum primis in faucibus. Nam pharetra ullamcorper arcu sed cursus.
                        Maecenas volutpat lacinia lobortis. Vestibulum ullamcorper, orci a varius placerat, dui eros
                        pharetra diam, non consectetur lorem nibh vel felis. Suspendisse fringilla risus quam, eu
                        porttitor ex volutpat quis. Nam porttitor diam gravida ex consectetur bibendum.

                        Suspendisse tellus orci, vulputate in fermentum ac, efficitur eget dolor. Sed nec nisi eu purus
                        posuere pellentesque efficitur blandit urna. Nam eros dui, scelerisque at velit a, commodo
                        suscipit sapien. Etiam erat odio, porttitor vel quam malesuada, lacinia suscipit purus. Cras
                        mattis ornare dui, nec vulputate lacus commodo ac. Suspendisse eget quam at mi hendrerit
                        vestibulum. Sed pellentesque imperdiet orci a imperdiet. Maecenas elementum dapibus elit id
                        placerat. Nam feugiat et ex accumsan pretium. Nam finibus, tellus in auctor malesuada, est odio
                        vehicula dolor, sed luctus dolor enim sed magna. Sed malesuada lobortis ligula sed venenatis. In
                        at purus nulla. Donec rutrum odio enim.
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