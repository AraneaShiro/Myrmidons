use myrmidonsBDD;

DELETE FROM recetteIngredient;
DELETE FROM recetteTag;
DELETE FROM recette;
DELETE FROM ingredient;
DELETE FROM tag;

/* implementation test */

INSERT INTO recette (nom, texte, photo) VALUES ("Pate bolo", "Ceci est une recette de pate bolo", "../images/bolo.jpg");

INSERT INTO ingredient (nom, photo) VALUES ("pate", "/");
INSERT INTO ingredient (nom, photo) VALUES ("tomate", "/");

INSERT INTO tag (nom) VALUES ("excellent");

INSERT INTO recetteIngredient (recetteID, ingredientID) VALUES (1,1);
INSERT INTO recetteIngredient (recetteID, ingredientID) VALUES (1,2);

INSERT INTO recetteTag (recetteID, tagID) VALUES (1,1);
