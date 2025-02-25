<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

$err = "";

// Fonction pour vérifier les informations de connexion
function verify(string $pass, string $usr): bool{
    global $err;

    $db = require 'bdd.php';
    
    // Prépare une requête SQL pour sélectionner l'utilisateur avec l'identifiant donné
    $sql = "SELECT * FROM utilisateur WHERE identifiant=:usr";

    $result = $db->prepare($sql);
    $result->execute(["usr" => $usr]);

    // Récupère les données de l'utilisateur
    $data = $result->fetch();
    
    // Vérifie si les données existent et si le mot de passe correspond
    if($data && $pass == $data->mot_de_passe){
        // Si les informations sont correctes, initialise la session utilisateur
        $_SESSION['utilisateur'] = $usr;
        return true;
    }

    // Message d'erreur
    $err = "Identifiant ou mot de passe incorrect";
    return false;
}

// Vérifie si le formulaire de connexion a été soumis
if(isset($_POST['connexion'])){
    $usrname = $_POST["usrname"];
    $pass = $_POST["pass"];
    
    // Vérifie les informations de connexion
    $acces = verify($pass, $usrname);

    // Si les informations sont correctes, redirige vers la page d'accueil
    if($acces){
        header('Location: accueil.php');
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
