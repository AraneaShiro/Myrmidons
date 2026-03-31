<?php
// template pour la page d'index
class Template{
    public static function render(string $content) : void{?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="icon" type="image/x-icon" href="../image/favicon.png">
            <title>Myrmidons</title>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Lugrasimo&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="css/main.css">
            <link rel="stylesheet" href="css/inputRecette.css">
            <link rel="stylesheet" href="css/carte.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        </head>
        <body>
            <?php include "header.php"?>
            <div id="injected-content">
                <?php echo $content ?> <!-- Injection du contenu-->
            </div>
            <?php include "footer.php"?>
        </body>
        </html>
    <?php
    }
}
