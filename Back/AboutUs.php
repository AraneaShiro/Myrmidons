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
<link rel="stylesheet" href="css/About.css">
<div class="AboutUsPageDisplay">
    <div class="profil">
        <div><img src="../image/profile/Arthur.jpg" class="profileImg Arthur" alt=""></div>

        <div class="textProfile">
            <p>"Les gens timides vous vous bridez tellement vous allez mourir sans rien avoir accompli vous êtes
                les
                png en
                fond dans les films" -- Je suis peut-être timide mais moi, je sais faire la différence entre un PNJ
                et
                un
                PNG. --

            </p>
            <p>Le responsable du PHP (Arthur)</p>
        </div>


    </div>

    <div class="profil">
        <div><img src="../image/profile/diamond.gif" class="profileImg " alt=""></div>

        <div class="textProfile">
            <p>
                💗 ✨Je m’adresse à tous les otakus✨💗
                <br>
                🌍 ✨Un jour on quittera ce monde✨ 🌍
                <br>
                🌸✨Et on vivra dans le monde des animés✨ 🌸
                <br>
                💔✨On nous a dit d’arrêter de rêver...✨ 💔
                <br>
                🖇️✨Mais on abandonnera jamais ✨🖇️
                <br>
                💖✨Parce qu’on est des FAN D’ANIMÉS !!✨💖
            </p>
            <p>Le responsable de la Base de données (Maxence)</p>
        </div>


    </div>

    <div class="profil">
        <div><img src="../image/profile/image.png" class="profileImg plan" alt=""></div>

        <div class="textProfile">
            <p>
                Donner un rein, on est un héros. En donner 54 et ils appellent la police.
                Une lecon apprise à mes dépens.
            </p>
            <p>Le responsable du Front (Jules)</p>
        </div>


    </div>

</div>




<?php $content = ob_get_clean() ?>
<?php Template::render($content) ?>