<?php
class Template{
    public static function render(string $content) : void{?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Myrmidons</title>
            <link rel="stylesheet" href="../Front/css/main.css">
        </head>
        <body>
            <?php include "header.php"?>
            <div id="injected-content">
                <?php echo $content ?> <!-- Injection du contenu-->
            </div>
            <?php include "footer.php"?>
            <script src="../Front/script/filter.js"></script>
        </body>
        </html>
    <?php
    }
}
