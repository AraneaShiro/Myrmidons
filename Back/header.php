<?php
require_once 'AdminLogger.php';
$logger = new AdminLogger();
$username = null;
$password = null;
if(isset($_POST['username']) && isset($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $result = $logger->log($username, $password);
    if($result['granted']){
        $_SESSION['nickname'] = $result['username'];
        header("Location: login_admin.php");
    }
}
$logged = isset($_SESSION['nickname']) ;

?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<header class="mainHeader">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lugrasimo&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/inputRecette.css">
    <link rel="stylesheet" href="css/carte.css">
    <div class="navBar navbar navbar-expand-lg navbar-light ">
        <a href="index.php" class="navbar-brand">Home</a>
        <a href="index.php" class="navbar-brand">A propos</a>
    </div>
    <div class="title">Myrmidons</div>
    <div class="LogIn">
        <?php if ($logged):?>
        <div>
            <?php echo htmlspecialchars($_SESSION['nickname']) ; ?>
            <div>
                <a href="logout.php" class="btn btn-dark">Logout</a>
            </div>
        </div>
        <?php else: ?>
        <?php 
                    if(!isset($result)){
                        $logger->generateLoginForm("index.php");
                    }else{
                        $logger->generateLoginForm("index.php");
                        echo "<div id='error'>". $result['error'] . "</div>";
                    }
                ?>
        <?php endif; ?>
    </div>

</header>