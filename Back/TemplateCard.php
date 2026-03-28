<?php
class TemplateCard{
    public static function render(string $content) : void{?>
<link rel="stylesheet" href="../Front/css/carte.css">
<div class="card">
    <button class="ModifRecette">Modifier</button>
    <button class="DeleteRecette">Supprimer</button>
    <!-- LIGNE HAUTE -->
    <div class="card__top">
        <!-- IMAGE -->
        <div class="card__image">
            <img src="../image/pateCarbo.jpg" alt="Image du plat" />
        </div>
        <!-- TITRE + LISTE -->
        <div class="card__right">
            <div class="card__title">
                <h2>Nom recette</h2>
            </div>
            <div class="card__list">
                <h3>Liste Ingrédients</h3>
                <ul>
                    <li><span class="dot"></span> Ing1</li>
                    <li><span class="dot"></span> Ing1</li>
                    <li><span class="dot"></span> Ing1</li>
                    <li><span class="dot"></span> Ing1</li>
                    <li><span class="dot"></span> Ing1g</li>
                    <li><span class="dot"></span> Ing1</li>
                    <li><span class="dot"></span> Ing1</li>
                    <li><span class="dot"></span> Ing1</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- LIGNE BASSE : DESCRIPTION -->
    <div class="card__desc">
        <h3>Description</h3>
        <p>
            dsifjskldffgjnklgjfkldjgdfklgjdfklgjdfkljgdfklgjdfogjd[fkgjdo[hkndogjd[js[ejfs[ofgknsd[ofsd[ofjsokgdfnokgdfnokgldfngkldgdkfgkdfngkndkgdfngldnkglkfdgkldjnmgdklfgndflkjgdfokgjdfklgdfjgldkjgdklf]]]]]]]
        </p>
    </div>

</div>
<?php
    }
}