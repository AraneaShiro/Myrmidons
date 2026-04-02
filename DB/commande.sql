use myrmidonsBDD;

DELETE FROM recetteIngredient;
DELETE FROM recetteTag;
DELETE FROM recette;
DELETE FROM ingredient;
DELETE FROM tag;

/* implementation test */

INSERT INTO recette (nom, texte, photo) VALUES 
("Pate bolo", "Ceci est une recette de pate bolo", "../images/bolo.jpg"),
("Sushi", "Ceci est une recette de Sushi", "../images/sushi.jpg");


INSERT INTO ingredient (nom, photo) VALUES 
("spag", "../image/spag.jpg"),
("boeuf", "../image/boeuf.jpg"),
("tomate", "../image/tomate.jpg"),
("saumon", "../image/saumon.jpg"),
("riz", "../image/riz.jpg");

INSERT INTO tag (nom) VALUES 
("italien"),
("japonais"),
("rapide"),
("difficile");

INSERT INTO recetteIngredient (recetteID, ingredientID) 
SELECT 1, ingredientID FROM ingredient WHERE nom IN ('spag', 'tomate', 'boeuf');

INSERT INTO recetteIngredient (recetteID, ingredientID) 
SELECT 2, ingredientID FROM ingredient WHERE nom IN ('riz', 'saumon');



INSERT INTO recetteTag (recetteID, tagNom) 
SELECT 1, nom FROM tag WHERE nom IN ('italien', 'rapide');

INSERT INTO recetteTag (recetteID, tagNom) 
SELECT 2, nom FROM tag WHERE nom IN ('japonais', 'difficile');
