<?php
// récupération de la session de l'utilisateur
session_start() ;

// destruction de la session (et donc du contenu de $_SESSION)
session_destroy() ;

header("Location: index.php");
exit();
?>