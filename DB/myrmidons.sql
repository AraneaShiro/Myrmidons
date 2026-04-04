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
("Pate bolognaise", 
"Ingrédients :\n- 400g de spaghetti\n- 300g de boeuf haché\n- 1 oignon\n- 2 gousses d'ail\n- 800g de tomates pelées\n- 1 carotte\n- 
1 branche de céleri\n- Huile d'olive\n- Sel, poivre\n- Parmesan râpé\n\nPréparation :\n1. Émincez l'oignon, l'ail, la carotte et le céleri.
 Faites-les revenir dans une grande poêle avec de l'huile d'olive.\n2. Ajoutez la viande hachée et faites-la colorer.\n3. Incorporez les
  tomates pelées en les écrasant. Salez, poivrez.\n4. Laissez mijoter à feu doux pendant 1h30.\n5. Pendant ce temps, faites cuire les spaghetti 
  dans une grande casserole d'eau bouillante salée.\n6. Servez les pâtes avec la sauce bolognaise et parsemez de parmesan.", 
"../image/bolo.jpg"),

("Sushi", 
"Ingrédients :\n- 500g de riz à sushi\n- 600ml d'eau\n- 100ml de vinaigre de riz\n- 2 cuillères à soupe de sucre\n- 1 
cuillère à café de sel\n- 200g de saumon frais\n- 200g de thon rouge\n- 1 concombre\n- 2 avocats\n- 4 feuilles de nori\n- 
Sauce soja\n- Wasabi\n- Gari (gingembre mariné)\n\nPréparation :\n1. Lavez le riz jusqu'à ce que l'eau soit claire. 
uisez-le avec l'eau.\n2. Mélangez le vinaigre, le sucre et le sel. Incorporez au riz chaud.\n3. Laissez refroidir le riz à
 température ambiante.\n4. Coupez le poisson, le concombre et l'avocat en bâtonnets.\n5. Pour les maki : déposez une feuille de nori sur 
une natte en bambou, étalez du riz, ajoutez les garnitures et roulez.\n6. Coupez en tronçons de 2cm.\n7. Servez avec sauce soja, 
wasabi et gari.", "../image/sushi.jpg"),

("Pate carbonara", 
"Ingrédients :\n- 400g de spaghetti ou pâtes longues\n- 200g de guanciale (ou lardons)\n- 4 œufs frais\n- 150g 
de pecorino romano râpé\n- Poivre noir\n- Sel\n\nPréparation :\n1. Faites cuire les pâtes dans une grande casserole d'eau 
bouillante salée.\n2. Pendant ce temps, coupez le guanciale en petits dés. Faites-le revenir dans une poêle sans matière grasse 
jusqu'à ce qu'il soit croustillant.\n3. Dans un bol, battez les œufs avec le pecorino râpé et une généreuse quantité de poivre noir.\n4.
 Égouttez les pâtes en réservant un peu d'eau de cuisson.\n5. Versez les pâtes chaudes dans la poêle avec le guanciale. Mélangez.\n6. Hors du feu,
  ajoutez le mélange œufs-fromage. Mélangez rapidement - la chaleur des pâtes va créer une sauce crémeuse.\n7. 
Ajoutez un peu d'eau de cuisson si nécessaire.\n8. Servez immédiatement avec du pecorino supplémentaire.", 
"../image/pateCarbo.jpg"),

("Lasagne à la bolognaise", 
"Ingrédients :\nPour la sauce bolognaise :\n- 500g de boeuf haché\n- 1 oignon\n- 2 carottes\n- 2 branches de céleri\n- 800g de tomates concassées\n- 1 verre de vin rouge\n- Huile d'olive\n\nPour la béchamel :\n- 50g de beurre\n- 50g de farine\n- 500ml de lait\n- Muscade\n\nPour le montage :\n- 12 plaques de lasagne\n- 150g de parmesan râpé\n- 150g de mozzarella\n\nPréparation :\n1. Préparez la bolognaise : faites revenir oignon, carotte, céleri. Ajoutez la viande, puis le vin. Laissez évaporer. Ajoutez les tomates et laissez mijoter 2h.\n2. Préparez la béchamel : faites fondre le beurre, ajoutez la farine, puis le lait chaud. Remuez jusqu'à épaississement. Salez, poivrez, muscade.\n3. Préchauffez le four à 180°C.\n4. Dans un plat à lasagne, altermez : bolognaise, béchamel, parmesan, plaques de lasagne.\n5. Terminez par de la béchamel,
du parmesan et la mozzarella.\n6. Enfournez pour 30-40 minutes jusqu'à ce que le dessus soit doré et gratiné.", 
 "../image/lasagne.jpg"),

("Pizza saumon", 
"Ingrédients :\nPour la pâte :\n- 250g de farine\n- 150ml d'eau tiède\n- 10g de levure de boulanger\n- 2 cuillères à soupe d'huile d'olive\n- 1 pincée de sel\n\nPour la garniture :\n- 200g de crème fraîche épaisse\n- 200g de saumon fumé\n- 1 citron\n- Aneth frais\n- Poivre\n- Câpres (optionnel)\n\nPréparation :\n1. Préparez la pâte : délayez la levure dans l'eau tiède. Mélangez avec la farine, l'huile et le sel. Pétrissez 10 minutes. Laissez lever 1h.\n2. Préchauffez le four à 240°C.\n3. Étalez la pâte en cercle sur une plaque farinée.\n4. Tartinez de crème fraîche.\n5. Coupez le saumon en fines lamelles et disposez-les sur la crème.\n6. Poivrez généreusement (ne salez pas, le saumon l'est déjà).\n7. Enfournez pour 10-12 minutes.\n8. À la sortie du four, ajoutez un filet de citron, l'aneth ciselé et quelques câpres.\n9. Servez immédiatement.",
 "../image/pizza_saumon.jpg"),

("Poulet curry", 
"Ingrédients :\n- 4 blancs de poulet (environ 600g)\n- 1 oignon\n- 2 gousses d'ail\n- 2 cuillères à soupe de pâte de curry (vert ou jaune)\n- 400ml de lait de coco\n- 200ml de bouillon de volaille\n- 2 cuillères à soupe d'huile de coco\n- 1 cuillère à café de curcuma\n- 1 poivron rouge\n- 1 courgette\n- Sel, poivre\n- Coriandre fraîche\n- 300g de riz basmati\n\nPréparation :\n1. Coupez le poulet en morceaux. Faites-le dorer dans l'huile de coco dans une grande sauteuse.\n2. Retirez le poulet. Dans la même sauteuse, faites revenir l'oignon émincé et l'ail.\n3. Ajoutez la pâte de curry, le curcuma. Faites cuire 1 minute.\n4. Remettez le poulet. Ajoutez le lait de coco et le bouillon.\n5. Laissez mijoter 15 minutes.\n6. Ajoutez le poivron et la courgette coupés en morceaux. Cuisez 5 minutes supplémentaires.\n7. Pendant ce temps, faites cuire le riz basmati dans de l'eau bouillante salée (15 minutes).\n8. Servez le curry bien chaud sur le riz basmati, parsemé de coriandre fraîche.", 
"../image/poulet_curry.jpg");


INSERT INTO ingredient (nom, photo) VALUES 
("spaguetti", "../image/spag.jpg"),
("boeuf", "../image/boeuf.jpg"),
("tomate", "../image/tomate.jpg"),
("saumon", "../image/saumon.jpg"),
("riz", "../image/riz.jpg"),
("lardons", "../image/lardons.jpg"),
("creme", "../image/creme.jpg"),
("parmesan", "../image/parmesan.jpg"),
("pate a lasagne", "../image/pate_lasagne.jpg"),
("poulet", "../image/poulet.jpg"),
("pate a pizza", "../image/pate_pizza.jpg");

INSERT INTO tag (nom) VALUES 
("italien"),
("japonais"),
("rapide"),
("exotique"),
("difficile");

INSERT INTO recetteIngredient (recetteID, ingredientID) 
SELECT 1, ingredientID FROM ingredient WHERE nom IN ('spaguetti', 'tomate', 'boeuf');

INSERT INTO recetteIngredient (recetteID, ingredientID) 
SELECT 2, ingredientID FROM ingredient WHERE nom IN ('riz', 'saumon');

INSERT INTO recetteIngredient (recetteID, ingredientID) 
SELECT 3, ingredientID FROM ingredient WHERE nom IN ('spaguetti', 'lardons', 'creme', 'parmesan');

INSERT INTO recetteIngredient (recetteID, ingredientID) 
SELECT 4, ingredientID FROM ingredient WHERE nom IN ('pate a lasagne', 'boeuf', 'tomate', 'parmesan');

INSERT INTO recetteIngredient (recetteID, ingredientID) 
SELECT 5, ingredientID FROM ingredient WHERE nom IN ('pate a pizza', 'creme', 'saumon');

INSERT INTO recetteIngredient (recetteID, ingredientID) 
SELECT 6, ingredientID FROM ingredient WHERE nom IN ('poulet','riz');



INSERT INTO recetteTag (recetteID, tagNom) 
SELECT 1, nom FROM tag WHERE nom IN ('italien', 'rapide');

INSERT INTO recetteTag (recetteID, tagNom) 
SELECT 2, nom FROM tag WHERE nom IN ('japonais', 'difficile', 'exotique');

INSERT INTO recetteTag (recetteID, tagNom) 
SELECT 3, nom FROM tag WHERE nom IN ('italien', 'rapide');

INSERT INTO recetteTag (recetteID, tagNom) 
SELECT 4, nom FROM tag WHERE nom IN ('italien', 'difficile');

INSERT INTO recetteTag (recetteID, tagNom) 
SELECT 5, nom FROM tag WHERE nom IN ('japonais', 'rapide');

INSERT INTO recetteTag (recetteID, tagNom) 
SELECT 6, nom FROM tag WHERE nom IN ('rapide', 'exotique');
