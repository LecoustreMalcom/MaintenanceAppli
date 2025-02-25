<?php
include 'header.php';
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>MiniAPP - Maintenance applicative</title>
    </head>

    <body>
        <h1>BONJOUR</h1>

        <?php
            // Vérifie si un utilisateur est connecté
            if (isset($_SESSION['utilisateur'])) {
                $utilisateur = $_SESSION['utilisateur'];
        ?>
                <p><?php echo $utilisateur;?> est connecté</p>
        <?php
            } else {
        ?>
                <p>Personne est connecté</p>
        <?php
            }
        ?>
    </body>

    <?php include './footer.php' ?>
</html>
