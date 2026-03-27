<?php
require_once "Back/Recette.php";
use Recette;
class Card{
    public Recette $recette;
    public function __construct($recette) { 
        $this->recette = $recette; 
    }

    public function getTitreRecette(): string{ 
        return $this->recette->getName();
    }
    
    public function listeIngredients(): void{
        foreach($this->recette->getTabIngredient() as $tab){
            echo '<li><span class="dot"></span>'. $tab .'</li>';
        }
    }

    public function getDescriptionRecette(): string{
        return $this->recette->getTexte();
    }

    public function listeTags(): void{
        foreach($this->recette->getTabTag() as $tag){
            echo '<li><span class="dot"></span>'. $tag .'</li>';
        }
    }

    public function generatePic(string $pic): void{
        echo '<img src="'.$pic.'" alt="'.$this->getTitreRecette().'" />';
    }
}