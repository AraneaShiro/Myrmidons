<?php
    ob_start(); // capture tout output (warnings, erreurs) avant les headers JSON
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once 'Template.php';
    require_once "AdminLogger.php";
    require_once "RechercheForm.php";
    require_once "AddContent.php";
    require_once "Recette.php";
    session_start();
    
    $recherche = new RechercheForm();
    $addition = new AddContent();
    $recette = new Recette();
    // Récupération des paramètres GET de recherche
    $search      = isset($_GET['search'])      ? trim($_GET['search'])      : '';
    $ingredients = isset($_GET['ingredients']) ? trim($_GET['ingredients']) : '';
    $tags        = isset($_GET['tags'])        ? trim($_GET['tags'])        : '';

    // Récupération des recettes selon la recherche par nom
    if (!empty($search)) {
        $recettesFiltre = $recette->db->rechercherRecettes($search);
    } else {
        $recettesFiltre = $recette->db->rechercherRecettesAll();
    }

    // Filtre par tags
    if (!empty($tags)) {
        $tabTags = explode(',', $tags);
        $recettesGarder = [];
        foreach ($recettesFiltre as $r) {
            $tagsRecette = $recette->db->rechercherTagsDansRecette($r['recetteID']);
            $nomsTagsRecette = [];
            foreach ($tagsRecette as $t) {
                $nomsTagsRecette[] = $t['nom'];
            }
            $ok = true;
            foreach ($tabTags as $tagCherche) {
                if (!in_array($tagCherche, $nomsTagsRecette)) {
                    $ok = false;
                    break;
                }
            }
            if ($ok) $recettesGarder[] = $r;
        }
        $recettesFiltre = $recettesGarder;
    }

    // Filtre par ingrédients
    if (!empty($ingredients)) {
        $tabIngs = explode(',', $ingredients);
        $recettesGarder = [];
        foreach ($recettesFiltre as $r) {
            $ingsRecette = $recette->db->rechercherIngredientsDansRecette($r['recetteID']);
            $nomsIngsRecette = [];
            foreach ($ingsRecette as $i) {
                $nomsIngsRecette[] = $i['nom'];
            }
            $ok = true;
            foreach ($tabIngs as $ingCherche) {
                if (!in_array($ingCherche, $nomsIngsRecette)) {
                    $ok = false;
                    break;
                }
            }
            if ($ok) $recettesGarder[] = $r;
        }
        $recettesFiltre = $recettesGarder;
    }
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
                'photo' => $photo
            ]);
            exit();
        }
        
        // Ajouter / Modifier une recette
        if (isset($_POST['newTitle'])) {
            $nom = htmlspecialchars($_POST['newTitle'] ?? '');
            $texte = htmlspecialchars($_POST['newDesc'] ?? '');
            $idRecette = trim($_POST['newId'] ?? '');
            $photo = $addition->uploadPhoto('imgFileInput');
            $ingredients = $_POST['newIngredients'];
            $tags = $_POST['newTags'];
            if (!empty($idRecette)) {
                // Modification d'une recette existante
                $resultat = $addition->modifierRecette($idRecette, $nom, $texte, $photo, $ingredients, $tags);
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
            <?php 
                foreach($recettesFiltre as $recettes) {
                    $id = $recettes['recetteID'];
                    $recette->generateRecetteCard($id);
                }
            ?>
        </div>
    </div>
</div>

<script src="../script/filter.js"></script>
<script src="../script/CRUD.js"></script>
<?php $content=ob_get_clean() ?>
<?php Template::render($content) ?>