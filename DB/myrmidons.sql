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
    tagID int PRIMARY KEY AUTO_INCREMENT,
    nom varchar(255) UNIQUE-- on le mettra en unique pour éviter des doublons
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

    tagID int,
    FOREIGN KEY (tagID)
    REFERENCES tag(tagID)

);



