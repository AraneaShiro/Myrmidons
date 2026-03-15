<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myrmidons</title>
    <link rel="stylesheet" href="css/main.css">
</head>

<body>

    <?php
require_once "header.php";
?>

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

                <?php include "carte.php" ?>
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

    <?php
require_once "footer.php";
?>

</body>
<script src="script/filter.js"></script>

</html>