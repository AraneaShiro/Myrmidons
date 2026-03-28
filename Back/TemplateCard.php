<?php
class TemplateCard{
    public static function render(string $content) : void{?>
<link rel="stylesheet" href="../Front/css/carte.css">
<div class="card">

    <!-- LIGNE HAUTE -->
    <div class="card__top">
        <button class="ModifRecette" class="btn btn-warning">Modifier</button>
        <button class="DeleteRecette" class="btn btn-danger">Supprimer</button>

        <!-- IMAGE -->
        <div class="card__image">
            <img src="../image/pateCarbo.jpg" alt="Image du plat" />
        </div>

        <!-- TITRE + LISTE -->
        <div class="card__right">

            <div class="card__title">
                <h2>Nom recette</h2>

            </div>
            <div class="tags-section">
                <label>Tags :</label>
                <div class="tags-row" id="tagsRowRecette">
                    <p class="tag">test</p>
                    <p class="tag">test2</p>
                </div>


            </div>
            <div class="card__list">
                <h3>Liste Ingrédients</h3>
                <ul>
                    <li><img class="IngPicture" src="../image/lasagne.jpg" alt=""></span>
                        Ing1</li>

                    <li><img class="IngPicture" src="../image/lasagne.jpg" alt=""></span>
                        Ing1</li>
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
    <!-- ID n'apparait que en mode admin-->
    <h6 class="IdRecette">55248</h6>
</div>
<?php
    }
}