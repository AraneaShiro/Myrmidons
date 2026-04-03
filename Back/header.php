<?php
require_once 'AdminLogger.php';
$logger = new AdminLogger();
$logged = isset($_SESSION['nickname']);
$login_error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : null;

?>
<header class="main-header">
    <nav class="bg-light navbar fixed-top">
        <div class="d-flex flex-row">
            <a class="logo mr-4 flex flex-row" href="index.php">
                <img class="mx-auto" src="../image/myrmidons_logo.png" alt="logo" width="60" height="60" />
                <span class="logo-text mt-auto font-weight-bold"> Myrmidons </span>
            </a>
            <div class="ml-4 mt-auto">
                <a href="index.php" class="navbar-brand">Home</a>
                <a href="AboutUs.php" class="navbar-brand">A propos</a>
            </div>
        </div>

        <div class="mt-auto">
            <?php if ($logged): ?>
                <div class="d-flex flex-row">
                    <span class="mb-2 mt-auto mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                            <path fill-rule="evenodd"
                                d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                        </svg>
                        <?php echo htmlspecialchars($_SESSION['nickname']); ?>
                    </span>
                    <button onclick="location.href='logout.php'" class="btn mx-2 btn-secondary">Logout</button>
                </div>
            <?php else: ?>
                <?php
                if (!isset($result)) {
                    $logger->generateLoginForm("index.php");
                } else {
                    $logger->generateLoginForm("index.php");
                    echo "<div id='error'>" . $result['error'] . "</div>";
                }
                ?>
            <?php endif; ?>
        </div>
    </nav>
</header>