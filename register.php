<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

$err = "";

// Fonction pour gérer l'inscription d'un utilisateur
function inscription(string $pass, string $usr): bool{
    global $err;

    $db = require 'bdd.php';
    $sql = "SELECT * FROM utilisateur WHERE identifiant='$usr'";

    // Exécute la requête SQL
    $result = $db->query($sql);
    $data = $result->fetch();

    // Vérifie si l'identifiant existe déjà
    if($data){
        // Si l'identifiant existe, définit un message d'erreur
        $err = "Username already taken";
        return false;
    } else{
        // Si l'identifiant n'existe pas, insère le nouvel utilisateur dans la base de données
        $sql = "INSERT INTO utilisateur (identifiant, mot_de_passe) VALUES ('$usr', '$pass')";
        $db->query($sql);

        // Initialise la session utilisateur
        $_SESSION['utilisateur'] = $usr;
        $_SESSION['est_admin'] = false;
        return true;
    }
}

// Vérifie si le formulaire d'inscription a été soumis
if (isset($_POST['inscription'])){
    $usrname = $_POST["usrname"];
    $pass = $_POST["pass"];

    // Tente d'inscrire l'utilisateur
    $acces = inscription($pass, $usrname);

    // Si l'inscription est réussie, redirige vers la page d'accueil ou une page spécifiée
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
