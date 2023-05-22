<?php

// On crée deux variables pour les messages a afficher
$ConnexionEchec = "";

// On a besoin de la connexion à la BDD utilisateurs
require "import.php";

$UtilisateurSaisi = isset($_POST["Email"]) ? $_POST["Email"] : ""; // on récupère les informations du formulaire
$MdpSaisi = isset($_POST["MotDePasse"]) ? $_POST["MotDePasse"] : "";

if (isset($_POST["LOGIN"])) {
    $SqlUtilisateurs = "SELECT * from utilisateurs where Email like '%$UtilisateurSaisi%'";
    $ResultatSql = mysqli_query($db_handle, $SqlUtilisateurs); // on se connecte à la bdd et on y fait la recherche $SqlUtilisateurs
    if (mysqli_num_rows($ResultatSql) != 0) { // si le nombre de lignes collectées est diff de 0 
        $row = mysqli_fetch_array($ResultatSql);
        $hash = $row['MotDePasse'];
        $EmailSql = $row['Email'];
        $NomSql = $row['Nom'];
        $PrenomSql = $row['Prenom'];
        $RoleSql = $row['Role'];

        if (password_verify($MdpSaisi, $hash)) {
            $_SESSION['Nom'] = $NomSql;
            $_SESSION['Prenom'] = $PrenomSql;
            $_SESSION['Email'] = $EmailSql;
            $_SESSION['Role'] = $RoleSql;
            header('Location: menu.php');
        } else {
            $ConnexionEchec = "Mot de passe incorrect";
        }
    } else {
        $ConnexionEchec = "Utilisateur inconnu";
    }
}

?>

<html>

<body>

    <div class="wrapper">

        <div class="milieuConnexion">

            <form class="form" action="connexion.php" method="POST"> <!--Formulaire de connexion-->
                <h1>Connexion</h1>

                <label class="messageErreur"><?php echo $ConnexionEchec ?></label><br><br> <!--Ligne pour les messages d'erreur - le texte est une variable définie et modifiée dans index.php-->

                <label>Nom d'utilisateur</label><br>
                <input type="text" placeholder="Entrer le nom d'utilisateur" name="Email" required><br><br>

                <label>Mot de passe</label>
                <input type="password" placeholder="Entrer le mot de passe" name="MotDePasse" required><br>

                <input type="submit" class="button" name='LOGIN' value='LOGIN'> <!-- On soumet le formulaire avec ce bouton-->
            </form>

        </div>

    </div>

</body>

</html>