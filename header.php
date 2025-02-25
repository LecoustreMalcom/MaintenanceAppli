<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (isset($_GET['deconnexion'])){
    $_SESSION = array();
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<head>
    <meta charset="UTF-8">
</head>

<header>
    <div>
        <?php
            if (isset($_SESSION['utilisateur'])) {
                $utilisateur = $_SESSION['utilisateur'];
        ?>
                <script src="./script/script.js"></script>
                <a class="lien" id="connexion" href="#" onclick="verifDeconnexion()">Deconnexion</a>
        <?php 
            } else {
        ?>
                <a class="lien" href="login.php" id="connexion">Connexion</a><br>
        <?php
            }
        ?>
    </div>
</header>
