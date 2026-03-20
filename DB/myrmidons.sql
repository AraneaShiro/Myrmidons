CREATE TABLE recette (
    recetteID int PRIMARY KEY,
    nom varchar(255),
    texte varchar(255)
);

CREATE TABLE ingredient (
    ingredientID int PRIMARY KEY,
    nom varchar(255)
);

CREATE TABLE tag (
    tagID int PRIMARY KEY,
    nom varchar(255)
);

CREATE TABLE recetteIngredient (

    CONSTRAINT fk_recette
    FOREIGN KEY (recetteID)
    REFERENCES recette(recetteID),

    CONSTRAINT fk_recette
    FOREIGN KEY (ingredientID)
    REFERENCES recette(recetteID)

);

CREATE TABLE recetteTag (

    CONSTRAINT fk_recette
    FOREIGN KEY (recetteID)
    REFERENCES recette(recetteID),

    CONSTRAINT fk_tag
    FOREIGN KEY (tagtID)
    REFERENCES tag(tagID)
    
);

