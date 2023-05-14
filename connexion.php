<?php

// On crée deux variables pour les messages a afficher
$ConnexionEchec = "";

// On a besoin de la connexion à la BDD utilisateurs
require "bdd_users_connect.php";
require "import.php";

$UtilisateurSaisi = isset($_POST["Email"]) ? $_POST["Email"] : "";
$MdpSaisi = isset($_POST["MotDePasse"]) ? $_POST["MotDePasse"] : "";

if (isset($_POST["LOGIN"])) {
    $SqlUtilisateurs = "SELECT * from utilisateurs where Email like '%$UtilisateurSaisi%'";
    $ResultatSql = mysqli_query($db_handle, $SqlUtilisateurs);
    if (mysqli_num_rows($ResultatSql) != 0) {
        $row = mysqli_fetch_array($ResultatSql);
        $hash = $row['MotDePasse'];
        $EmailSql = $row['Email'];
        $NomSql = $row['Nom'];
        $PrenomSql = $row['Prenom'];
        $RoleSql = $row['Role'];
    
        if (password_verify($MdpSaisi, $hash)){
            $_SESSION['Nom']= $NomSql;
            $_SESSION['Prenom']= $PrenomSql;
            $_SESSION['Email']= $EmailSql;
            $_SESSION['Role']= $RoleSql;
            header('Location: menu.php');
        } else {
            $ConnexionEchec = "Mot de passe incorrect";
        }
    }
    else {
        $ConnexionEchec = "Utilisateur inconnu";
    }
}


$NomSaisi = isset($_POST["nom"]) ? $_POST["nom"] : "";
$PrenomSaisi = isset($_POST["prenom"]) ? $_POST["prenom"] : "";
$MotDePasseSaisi = isset($_POST["creer_mot_de_passe"]) ? $_POST["creer_mot_de_passe"] : "";
$EmailSaisi = isset($_POST["creer_mail"]) ? $_POST["creer_mail"] : "";

if (isset($_POST["SIGNIN"])) {
    $password_encrypted = password_hash($MotDePasseSaisi, PASSWORD_ARGON2I, ["cost" => 15]);
    $sqlUtilisateur = "SELECT * FROM utilisateurs WHERE Email like '%$EmailSaisi%'";
    $resultUtilisateur = mysqli_query($db_handle, $sqlUtilisateur);
    if (mysqli_num_rows($resultUtilisateur) != 0) {
        $erreurCreation =  "Cet username ou adresse mail est déjà utilisé";
    } else {
        $sqlAjoutUtilisateur = "INSERT INTO utilisateurs(`Nom`,`Prenom`,`Email`,`MotDePasse`,`Role`) VALUES ('$NomSaisi','$PrenomSaisi','$EmailSaisi','$password_encrypted','')";
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

<head>
    <title>Connexion</title>
</head>

<body> 

    <div class="wrapper">

        <div class="milieuConnexion">

            <form class="form" action="connexion.php" method="POST"> <!--Formulaire de connexion-->
                <h1>Connexion</h1> 
                
                <label class = "messageErreur"><?php echo $ConnexionEchec ?></label><br><br>   <!--Ligne pour les messages d'erreur - le texte est une variable définie et modifiée dans index.php-->
        
                <label>Nom d'utilisateur</label><br>
                <input type="text" placeholder="Entrer le nom d'utilisateur" name="Email" required><br><br>
        
                <label>Mot de passe</label>
                <input type="password" placeholder="Entrer le mot de passe" name="MotDePasse" required><br>
        
                <input type="submit" class="button" name='LOGIN' value='LOGIN'> <!-- On soumet le formulaire avec ce bouton-->
            </form>

            <form class="form" action="index.php" method="POST">
                <h1>Créer un compte</h1><br>
            
                <label>Nom</label>
                <input type="text" placeholder="Nom" name="nom" required><br>
            
                <label>Prenom</label>
                <input type="text" placeholder="Prénom" name="prenom" required><br>
            
                <label>Mot de passe</label>
                <input type="password" placeholder="Entrer le mot de passe" name="creer_mot_de_passe" required><br>
            
                <label>Adresse E-mail</label>
                <input type="text" placeholder="Adresse mail" name="creer_mail" required><br>
            
                <input type="submit" class="button" name='SIGNIN' value='SIGNIN'><br>
            </form>

        </div>

    </div>

</body>
</html>