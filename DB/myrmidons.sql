DROP TABLE IF EXISTS recetteIngredient;
DROP TABLE IF EXISTS recetteTag;
DROP TABLE IF EXISTS recette;
DROP TABLE IF EXISTS ingredient;
DROP TABLE IF EXISTS tag;

CREATE TABLE recette (
    recetteID int PRIMARY KEY AUTO_INCREMENT,
    nom varchar(255),
    texte varchar(255),
    photo varchar(255)
);

CREATE TABLE ingredient (
    ingredientID int PRIMARY KEY AUTO_INCREMENT,
    nom varchar(255),
    photo varchar(255)
);

CREATE TABLE tag (
    tagID int PRIMARY KEY AUTO_INCREMENT,
    nom varchar(255)
);

CREATE TABLE recetteIngredient (

    recetteID int,
    FOREIGN KEY (recetteID)
    REFERENCES recette(recetteID),

    ingredientID int,
    FOREIGN KEY (ingredientID)
    REFERENCES ingredient(ingredientID)

);

CREATE TABLE recetteTag (

    recetteID int,
    FOREIGN KEY (recetteID)
    REFERENCES recette(recetteID),

    tagID int,
    FOREIGN KEY (tagID)
    REFERENCES tag(tagID)

);






/*
ALTER TABLE recette
UPDATE recetteID int NOT NULL AUTO_INCREMENT;
*/


