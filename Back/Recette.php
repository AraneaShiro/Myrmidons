<?php

class Recette{
     public string $nom;
     public string $texte;
     //tableau des ingrédients de la recette
     public array $tabIngredient;
     // tableau contenant les tags de la recette
    public array $tabTag;
    //path pour accès photo
    public string $photo;
    /**
     * Constructeur Ingredient
     * @param $nom
     */
    public function __construct($nom, $texte, $tabIngredient, $tabTag, $photo){
        $this->nom = $nom;
        $this->texte = $texte;
        $this->tabIngredient = $tabIngredient;
        $this->tabTag = $tabTag;
        $this->photo = $photo;
    }

    /**
     * @return string
     */
    public function getName(): string{
        return $this->nom;
    }

    /**
     * @return string
     */
    public function getTexte(): string{
        return $this->texte;
    }

    /**
     * @return array
     */
    public function getTabIngredient(): array{
        return $this->tabIngredient;
    }

    /**
     * @return array
     */
    public function getTabTag(): array{
        return $this->tabTag;
    }

    public function getPhoto(): string{
        return $this->photo;
    }
    /**
     * @return string
     */
    public function __toString() : string{
        return ucwords($this->nom);
    }

}