<?php

/**
 * C'est ici que je vais tester les fonctions de SQLtest 
 */

require_once 'SQLfct.php';

$db = new SQLfct();

$recettes = $db->rechercherRecettesAll();
foreach ($recettes as $recette) {
    echo $recette['nom'] . "\n";
}


$nouvelId = $db->ajouterRecette(
    "A", 
    "repas A", 
    "A.jpg"
);
echo "<p>✓ ajouterRecette : " . $nouvelId . "</p>";