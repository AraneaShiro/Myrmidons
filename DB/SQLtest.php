<?php

/**
 * C'est ici que je vais tester les fonctions de SQLtest 
 */

require_once 'SQLfct.php';

$db = new SQLfct();




echo "<h2> rechercherRecettesAll() : </h2>";
$recettes = $db->rechercherRecettesAll();
foreach ($recettes as $recette) {
    echo $recette['nom'] . " ID=" . $recette['recetteID'] . "<br>";
}
echo "<br>";





echo "<h2> rechercherTagAll() : </h2>";
$tags = $db->rechercherTagAll();
foreach ($tags as $tag) {
    echo $tag['nom'] . " ID=" . $tag['tagID'] . "<br>";
}
echo "<br>";




echo "<h2> rechercherIngredientAll() : </h2>";
$tags = $db->rechercherIngredientAll();
foreach ($tags as $tag) {
    echo $tag['nom'] . " ID=" . $tag['ingredientID'] . "<br>";
}
echo "<br>";




echo "<h2> ajouterRecette() : </h2>";
$db->ajouterRecette(
    "nouvelleRecette", 
    "repas A", 
    "A.jpg"
);

$recettes = $db->rechercherRecettesAll();
foreach ($recettes as $recette) {
    echo $recette['nom'] . "<br>";
}
echo "<br>";




echo "<h2> ajouterIngredient() : </h2>";
$db->ajouterIngredient(
    "nouveauIngredient", 
    "ingredient3.jpg"
);


$tags = $db->rechercherIngredientAll();
foreach ($tags as $tag) {
    echo $tag['nom'] . " ID=" . $tag['ingredientID'] . "<br>";
}
echo "<br>";




echo "<h2> ajouterTag() : </h2>";
$db->ajouterTag(
    "nouveauTag"
);


$tags = $db->rechercherTagAll();
foreach ($tags as $tag) {
    echo $tag['nom'] . " ID=" . $tag['tagID'] . "<br>";
}
echo "<br>";

echo "<h2> rechercherRecettes('pat') : </h2>";
$pat = $db->rechercherRecettes("pat");
foreach ($pat as $recherche) {
    echo $recherche['nom'] . "<br>";
}
echo "<br>";



echo "<h2> rechercherRecettesParTag(1) : </h2>";
$recettespartag = $db->rechercherRecettesParTag(1);
foreach ($recettespartag as $recette) {
    echo $recette['nom'] . "<br>";
}

echo "<h2> rechercherRecettesParIngredient(1) : </h2>";
$recettes = $db->rechercherRecettesParIngredient(1);
foreach ($recettes as $recette) {
    echo $recette['nom'] . "<br>";
}

echo "<h2> rechercherIngredientsDansRecette(1) : </h2>";
$ingredients = $db->rechercherIngredientsDansRecette(1);
foreach ($ingredients as $ingredient) {
    echo $ingredient['nom'] . "<br>";
}

echo "<h2> rechercherTagsDansRecette(1) : </h2>";
$ingredients = $db->rechercherTagsDansRecette(1);
foreach ($ingredients as $ingredient) {
    echo $ingredient['nom'] . "<br>";
}

echo "<h2> rechercherRecetteParID(2) : </h2>";
$recette = $db->rechercherRecetteParID(2);
echo $recette['nom'] . "<br>";

echo "<h2> rechercherIngredientParID(2) : </h2>";
$recette = $db->rechercherIngredientParID(2);
echo $recette['nom'] . "<br>";

echo "<h2> rechercherTagParID(1) : </h2>";
$recette = $db->rechercherTagParID(1);
echo $recette['nom'] . "<br>";

echo "<h2> delierRecetteTag(1,1) & delierRecetteIngredient(1,2) & delierRecetteIngredient(1,1) & supprimerRecette(1) : </h2>";
$db->delierRecetteTag(1,1);
$db->delierRecetteIngredient(1,1);
$db->delierRecetteIngredient(1,2);
$db->supprimerRecette(1);
$tags = $db->rechercherRecettesAll();
foreach ($tags as $tag) {
    echo $tag['nom'] . " ID=" . $tag['recetteID'] . "<br>";
}
echo "<br>";

echo "<h2> lierRecetteIngredient(2,1) & lierRecetteTag(2,1) </h2>";
$db->lierRecetteTag(2,1);
$db->lierRecetteIngredient(2,1);

echo "<h2> modifierRecette(2, 'modifRecette', 'modif texte', '../image') : </h2>";
$db->modifierRecette(2, 'modifRecette', 'modif texte', '../image');
$tags = $db->rechercherRecettesAll();
foreach ($tags as $tag) {
    echo $tag['nom'] . " ID=" . $tag['recetteID'] . " " . $tag['texte'] . " " . $tag['photo'] . "<br>";
}

