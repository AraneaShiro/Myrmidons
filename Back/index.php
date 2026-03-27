<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once 'Template.php';
    require_once "AdminLogger.php";
    $logged = isset($_SESSION['nickname']) ;
?>
<?php ob_start() ?>
<div id="searchBar"><input class="inputText" type="text" placeholder="Tartiflette"></div>
<div id="mainWrapper">
    <div id="filterContent">
        <div><label for="Ingredient">Ingredient</label>
            <select name="cars" id="cars">
                <option value="volvo">Volvo</option>
                <option value="saab">Saab</option>
                <option value="mercedes">Mercedes</option>
                <option value="audi">Audi</option>
            </select>
            <button id="AddIngredient" class="btn">Add Ingredient</button>
        </div>
        <div><label for="Tag">Tag</label>
            <select name="cars" id="cars">
                <option value="volvo">Volvo</option>
                <option value="saab">Saab</option>
                <option value="mercedes">Mercedes</option>
                <option value="audi">Audi</option>
            </select>
            <button id="AddTag" class="btn">Add Tag</button>
        </div>
    </div>
    <div class="mainContentWrapper">
        <div class="DisplayFilter">
            <p>tag:</p>
        </div>
        <div class="showResult">
            <?php include "../Front/carte.php" ?>
            <?php include "carte.php" ?>
            <?php include "carte.php" ?>
            <?php include "carte.php" ?>
            <?php include "carte.php" ?>
            <?php include "carte.php" ?>
            <?php include "carte.php" ?>
            <?php include "carte.php" ?>
        </div>
    </div>
</div>
<?php $content=ob_get_clean() ?>
<?php Template::render($content) ?>
