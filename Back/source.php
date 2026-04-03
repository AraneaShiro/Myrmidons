<?php
ob_start(); // capture tout output (warnings, erreurs) avant les headers JSON
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'Template.php';
require_once "AdminLogger.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    ob_clean(); // vide le buffer avant d'envoyer le JSON

    // Traitement du login (username + password)
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $logger = new AdminLogger();
        $result = $logger->log($_POST['username'], $_POST['password']);
        if ($result['granted']) {
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

}

// Récupérer l'erreur de login pour l'afficher si elle existe
$login_error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : null;
unset($_SESSION['login_error']); // Supprimer l'erreur après l'avoir récupérée
?>
<?php ob_start() ?>
<!-- Barre de recherche en haut-->
<link rel="stylesheet" href="css/sourceUsed.css">
<div class="SourcePage">
    <div class="categorie">
        <h1>Source des images libre de droit:</h1>
        <span>pateCarbo.jpg :
            https://www.pexels.com/fr-fr/photo/nourriture-aliments-pates-spaghetti-4698505/</span>
        <span>lasagne.jpg :
            https://www.pexels.com/fr-fr/photo/plat-photo-de-nourriture-photographie-de-nourriture-patisse-5949901/</span>
        <span>sushi.jpg :
            https://www.pexels.com/fr-fr/photo/36317038/</span>
        <span> Les autres images proviennent de https://www.pexels.com/fr-fr/</span>
    </div>
    <hr>
    <div class="categorie"> <span>L'icone et le logo du site sont fait à la main par Elizabeth Kartodimedgo</span></div>
    <div class="categorie"> <span>Les images de profil de chaque personne viennent de diverses sources</span></div>
</div>




<?php $content = ob_get_clean() ?>
<?php Template::render($content) ?>