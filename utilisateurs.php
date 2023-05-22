<?php

require 'import.php';

$erreurCreation = "";
$succesCreation = "";

$NomSaisi = isset($_POST["nom"]) ? $_POST["nom"] : "";
$PrenomSaisi = isset($_POST["prenom"]) ? $_POST["prenom"] : "";
$MotDePasseSaisi = isset($_POST["creer_mot_de_passe"]) ? $_POST["creer_mot_de_passe"] : "";
$EmailSaisi = isset($_POST["creer_mail"]) ? $_POST["creer_mail"] : "";
$RoleSaisi = isset($_POST["role"]) ? $_POST["role"] : "";

if (isset($_POST["AJOUTER"])) {
    $password_encrypted = password_hash($MotDePasseSaisi, PASSWORD_ARGON2I, ["cost" => 15]);
    $sqlUtilisateur = "SELECT * FROM utilisateurs WHERE Email like '%$EmailSaisi%'";
    $resultUtilisateur = mysqli_query($db_handle, $sqlUtilisateur);
    if (mysqli_num_rows($resultUtilisateur) != 0) {
        $erreurCreation =  "Cet username ou adresse mail est déjà utilisé";
    } else {
        $sqlAjoutUtilisateur = "INSERT INTO utilisateurs(`Nom`,`Prenom`,`Email`,`MotDePasse`,`Role`) VALUES ('$NomSaisi','$PrenomSaisi','$EmailSaisi','$password_encrypted','$RoleSaisi')";
        $resultAjoutUtilisateur = mysqli_query($db_handle, $sqlAjoutUtilisateur);
        if ($resultAjoutUtilisateur) {
            $succesCreation =  "Votre compte a bien été créé !";
        } else {
            $succesCreation = "La création du compte a échouée";
        }
    }
}
?>

<html>

<body>

    <?php include 'navbar.php'; ?>

    <div class="wrapper">

        <div class="milieuSite">

            <form class="form" action="utilisateurs.php" method="POST">
                <h1>Créer un utilisateur</h1>
                <label class="messageSucces"><?php echo $succesCreation ?></label>
                <label class="messageErreur"><?php echo $erreurCreation ?></label><br>

                <input type="text" placeholder="Nom" name="nom" required><br>

                <input type="text" placeholder="Prénom" name="prenom" required><br>

                <input type="password" placeholder="Entrer le mot de passe" name="creer_mot_de_passe" required><br>

                <input type="text" placeholder="Adresse mail" name="creer_mail" required><br>

                <select name="role" id="role" required>
                    <option value=1>Elève</option>
                    <option value=2>Professeur</option>
                    <option value=3>Administrateur</option>
                </select><br>

                <input type="submit" class="button" name='AJOUTER' value='AJOUTER'><br>
            </form>
        </div>
    </div>

</body>

</html>