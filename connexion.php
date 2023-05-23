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

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Page divisée verticalement en deux</title>
    <link rel="stylesheet" type="text/css" href="connexion.css">
</head>

<body>

    <div class="container">
        <div class="left">
            <div class="text">La plus belle ville du monde<br>LYON</div>
            <div class="section">
                <div class="slider">

                    <div class="slide active">
                        <img src="images/lyon.jpg" alt="">
                    </div>
                    <div class="slide">
                        <img src="images/paris.jpg" alt="">
                    </div>
                    <div class="slide">
                        <img src="images/La-Saone-lyon.jpg" alt="">
                    </div>
                    <div class="slide">
                        <img src="images/lyon.jpg" alt="">
                    </div>
                    <div class="nav-auto">
                        <div class="a-b1 active"></div>
                        <div class="a-b2"></div>
                        <div class="a-b3"></div>
                        <div class="a-b4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    </div>
    </div>
    </div>
    <div class="right">
        <img src="images\logo.png" alt="Logo" class="logo">
        <p class="titre">Connexion avec votre compte professionnel</p>

        <form class="form" action="connexion.php" method="POST"> <!--Formulaire de connexion-->
            <label class="messageErreur"><?php echo $ConnexionEchec ?></label> <!--Ligne pour les messages d'erreur - le texte est une variable définie et modifiée dans index.php-->
            <input type="text" placeholder="Entrer le nom d'utilisateur" name="Email" required>
            <input type="password" placeholder="Entrer le mot de passe" name="MotDePasse" required><br>
            <input type="submit" class="button" name='LOGIN' value='CONNEXION'> <!-- On soumet le formulaire avec ce bouton-->
        </form>
        <label>
            <input type="checkbox" name="maintenir_connexion" onchange="if(this.checked){ setCookie('Email', document.getElementsByName('Email')[0].value); setCookie('MotDePasse', document.getElementsByName('MotDePasse')[0].value); } else { setCookie('Email', '', -1); setCookie('MotDePasse', '', -1); }">
            <span>Maintenir la connexion ?</span>
        </label>
        <div class="mot-de-passe-oublie">
            <a href="motpasseoublie.php">Mot de passe oublié ?</a>

        </div>

        <footer>
            <p> © 2023 projet_web_dynamique</p>
        </footer>
    </div>
    </div>

    <script>
        function setCookie(name, value, expireDays) {
            var d = new Date();
            d.setTime(d.getTime() + (expireDays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = name + "=" + value + ";" + expires + ";path=/";
        }
    </script>
    <script>
        var slides = document.querySelectorAll('.slide');
        var navButtons = document.querySelectorAll('.nav-auto div');
        var currentSlide = 0;
        var slideInterval = setInterval(nextSlide, 5500);

        function nextSlide() {
            slides[currentSlide].classList.remove('active');
            navButtons[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add('active');
            navButtons[currentSlide].classList.add('active');
        }
    </script>
</body>

</html>