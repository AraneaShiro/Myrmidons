use myrmidonsBDD;

DELETE FROM recetteIngredient;
DELETE FROM recetteTag;
DELETE FROM recette;
DELETE FROM ingredient;
DELETE FROM tag;

/* implementation test */

INSERT INTO recette VALUES (1, "Pate bolo", "Ceci est une recette de pate bolo", "../images/bolo.jpg");

INSERT INTO ingredient VALUES (1, "pate", "/");
INSERT INTO ingredient VALUES (2, "tomate", "/");

INSERT INTO tag VALUES (1, "excellent");

INSERT INTO recetteIngredient VALUES (1,1);
INSERT INTO recetteIngredient VALUES (1,2);

INSERT INTO recetteTag VALUES (1,1);
