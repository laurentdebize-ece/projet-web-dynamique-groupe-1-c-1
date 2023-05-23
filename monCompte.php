<?php

include 'import.php';

$Email2 = $_SESSION['Email'];
// On crée deux variables pour les messages a afficher
$ErreurSaisie = "";
$changementReussi = "";


if (isset($_POST["ChangerMotDePasse"])) {

    $sql = "select MotDePasse from utilisateurs where Email like '%$Email2%'";
    $resultat = mysqli_query($db_handle, $sql);
    if (!mysqli_num_rows($resultat)) {
        $ErreurSaisie =  "Une erreur est survenue";
    } else {
        while ($data = mysqli_fetch_assoc($resultat)) {
            $ancienMotDePasse = $data['MotDePasse'];
        }
    }

    if (password_verify($_POST["AncienMotDePasse"], $ancienMotDePasse)) {
        if ($_POST["NouveauMotDePasse"] == $_POST["NouveauMotDePasse2"]) {
            $nouveauMotDePasse = password_hash($_POST["NouveauMotDePasse"], PASSWORD_ARGON2I, ["cost" => 15]);
            $sqlUpdate = " update utilisateurs set MotDePasse='$nouveauMotDePasse' where Email like '%$Email2%'";
            $resultUpdate = mysqli_query($db_handle, $sqlUpdate);
            if ($resultUpdate) {
                $changementReussi = "Mot de passe changé avec succès";
            } else {
                echo "erreur update";
            }
        } else {
            $ErreurSaisie = "Les nouveaux mots de passe saisis sont différents";
        }
    } else {
        $ErreurSaisie = "Le mot de passe saisi est incorrect";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Update</title>
    <link rel="stylesheet" href="monCompte.css">
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="wrapper">
        <div class="milieuSite">
            <h3>Nom : <?php echo $Nom ?></h3>
            <h3>Prénom : <?php echo $Prenom ?></h3>
            <P>Email : <?php echo $Email ?></p>

            <form class="form" action="monCompte.php" method="POST">
                <h1>Changer le mot de passe</h1>

                <label class="messageSucces"><?php echo $changementReussi ?></label>
                <label class="messageErreur"><?php echo $ErreurSaisie ?></label>

                <input type="text" placeholder="Entrer le mot de passe actuel" name="AncienMotDePasse" required>

                <input type="password" placeholder="Entrer le nouveau mot de passe" name="NouveauMotDePasse" required>

                <input type="password" placeholder="Ressaisir le nouveau mot de passe" name="NouveauMotDePasse2" required>

                <input type="submit" class="button" name="ChangerMotDePasse" value="Changer le mot de passe">
            </form>

        </div>
    </div>

</body>

</html>
