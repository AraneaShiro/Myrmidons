DROP TABLE IF EXISTS recetteIngredient;
DROP TABLE IF EXISTS recetteTag;
DROP TABLE IF EXISTS recette;
DROP TABLE IF EXISTS ingredient;
DROP TABLE IF EXISTS tag;

CREATE TABLE recette (
    recetteID int PRIMARY KEY AUTO_INCREMENT,
    nom varchar(255),
    texte text,
    photo varchar(255)
);

CREATE TABLE ingredient (
    ingredientID int PRIMARY KEY AUTO_INCREMENT,
    nom varchar(255) UNIQUE, -- on le mettra en unique pour éviter des doublons
    photo varchar(255)
);

CREATE TABLE tag (
    nom varchar(255) PRIMARY KEY 
);

-- liaison entre recette & ingredient
CREATE TABLE recetteIngredient (

    recetteIngredientID int PRIMARY KEY AUTO_INCREMENT,

    recetteID int,
    FOREIGN KEY (recetteID)
    REFERENCES recette(recetteID),

    ingredientID int,
    FOREIGN KEY (ingredientID)
    REFERENCES ingredient(ingredientID)

);

-- liaison entre recette & tag
CREATE TABLE recetteTag (

    recetteTagID int PRIMARY KEY AUTO_INCREMENT,

    recetteID int,
    FOREIGN KEY (recetteID)
    REFERENCES recette(recetteID),

    tagNom varchar(255), 
    FOREIGN KEY (tagNom)
    REFERENCES tag(nom) 

);


/* implementation test */

INSERT INTO recette (nom, texte, photo) VALUES 
("Pate bolo", "Ceci est une recette de pate bolo", "../image/bolo.jpg"),
("Sushi", "Ceci est une recette de Sushi", "../image/sushi.jpg");


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
