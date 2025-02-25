<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

$err = "";

function verify(string $pass, string $usr): bool{
    global $err;

    $db = require 'bdd.php';
    $sql = "SELECT * FROM utilisateur WHERE identifiant=:usr";

    $result = $db->prepare($sql);
    $result->execute(["usr" => $usr]);

    $data = $result->fetch();
    if($data && $pass == $data->mot_de_passe){
        $_SESSION['utilisateur'] = $usr;
        return true;
    }

    $err = "Identifiant ou mot de passe incorrect";
    return false;
}

if(isset($_POST['connexion'])){
    $usrname = $_POST["usrname"];
    $pass = $_POST["pass"];
    $acces = verify($pass, $usrname);

    if($acces){
        header('Location: index.php');
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
            <div class="zone-bienvenue">
                <h2>Bienvenue !</h2>
                <p >Vous n'avez toujours pas de compte ? Créez en un dès maintenant en 
                    <a href="./register.php">cliquant ici</a>
                </p>
            </div>

            <form class="zone-connexion" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <h2>Connexion</h2>
                <input type="text" placeholder="Identifiant" name="usrname"/>
                <input type="password" placeholder="Mot de passe" name="pass"/>
                <span class="erreur"><?php echo $err?></span>
                <button type="submit" name="connexion">Se connecter</button>
            </form>
        </div>
    </body>
</html>
