<?php
session_start();
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
    }
}
$logged = isset($_SESSION['nickname']) ;

?>
<header class="mainHeader">
    <div class="navBar">
        <a href="index.php">SearchPage</a>
        <a href="index.php">Edit</a>
    </div>
    <div class="title">Myrmidons</div>
    <div class="LogIn">
        <?php if ($logged):?>
            <div>
                <?php echo htmlspecialchars($_SESSION['nickname']) ; ?>
                <div>
                    <a href="logout.php">Logout</a>
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
 