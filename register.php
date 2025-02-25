<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

$err = "";

function inscription(string $pass, string $usr): bool{
    global $err;

    $db = require 'bdd.php';
    $sql = "SELECT * FROM utilisateur WHERE identifiant=:usr";

    $result = $db->prepare($sql);
    $result->execute(["usr" => $usr]);

    $data = $result->fetch();

    if($data){
        $err = "Username already taken";
        return false;
    } else{
        $sql = "INSERT INTO utilisateur (identifiant, mot_de_passe) VALUES (:usr, :pass)";
        $statement = $db->prepare($sql);
        $statement->execute(["usr" => $usr, "pass" => $pass]);
        $_SESSION['utilisateur'] = $usr;
        $_SESSION['est_admin'] = false;
        return true;
    }
}

if (isset($_POST['inscription'])){
    $usrname = $_POST["usrname"];
    $pass = $_POST["pass"];
    $acces = inscription($pass, $usrname);

    if($acces){
        if (isset($_GET['redirect']) && !empty($_GET['redirect'])){
            $redirection = urldecode($_GET['redirect']);
            header("Location: $redirection");
        } else {
            header('Location: index.php');
        }
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Connexion - Maintenance applicative</title>
        <link rel="stylesheet" type="text/css" href="./style/connexion.css">
    </head>

    <body>
        <h1>
            <a href="./index.php">
                Page d'accueil
            </a>
        </h1>
        
        <div class="form-connexion">
            <form class="zone-inscription" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <h2>Inscription</h2>
                <input type="text" placeholder="Identifiant" name="usrname"/>
                <input type="password" placeholder="Mot de passe" name="pass"/>
                <span class="erreur"><?php echo $err?></span>
                <button type="submit" name="inscription">S'inscrire</button>

                <a href="./login.php">J'ai déjà un compte</a>
            </form>
        </div>
    </body>
</html>
