<?php
$host = "localhost"; 
$dbname = "projetomnesmyskill";
$username = "root";
$password = "root";
$errorMessage = "";

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $adresse_email = $_POST["adresse_email"];
        $mot_passe = $_POST["mot_passe"];

        $query = "SELECT * FROM professeur WHERE email = :email AND mdp = :password";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":email", $adresse_email);
        $stmt->bindParam(":password", $mot_passe);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result) {
            header('Location: accueil.php');
        } else {
            $errorMessage = "ID d'utilisateur ou mot de passe incorrect. Entrez l'ID d'utilisateur et le mot de passe corrects et réessayez.";
        }
    }
} catch (PDOException $e) {
    echo "Une erreur s'est produite : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Page divisée verticalement en deux</title>
    <link rel="stylesheet" type="text/css" href="etudiant.css">
</head>

<body>

    <div class="container">
        <div class="left">
            <div class="text">La plus belle ville du monde<br>LYON</div>
            <div class="section">
                <div class="slider">
                    <div class="slide active">
                        <img src="image/lyon.jpg" alt="">
                    </div>
                    <div class="slide">
                        <img src="image/paris.jpg" alt="">
                    </div>
                    <div class="slide">
                        <img src="image/La-Saone-lyon.jpg" alt="">
                    </div>
                    <div class="slide">
                        <img src="image/lyon.jpg" alt="">
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
        <img src="image\logo.png" alt="Logo" class="logo">
        <p class="titre">Connexion avec votre compte professionnel</p>
        <form method="post">
            <label for="adresse_email"></label>
            <input type="text" name="adresse_email" required value="<?php if (isset($_COOKIE['adresse_email'])) {
                                                                        echo $_COOKIE['adresse_email'];
                                                                    } ?>">
            <label for="mot_passe"></label>
            <input type="password" name="mot_passe" required value="<?php if (isset($_COOKIE['mot_passe'])) {
                                                                        echo $_COOKIE['mot_passe'];
                                                                    } ?>">
            <input type="submit" value="Enregistrer">
            <br>
            <?php if (!empty($errorMessage) && isset($_POST["adresse_email"]) && isset($_POST["mot_passe"])) : ?>
                <div class="error-message"><?php echo $errorMessage ?></div>
            <?php endif; ?>
        </form>
        <label>
            <input type="checkbox" name="maintenir_connexion" onchange="if(this.checked){ setCookie('adresse_email', document.getElementsByName('adresse_email')[0].value); setCookie('mot_passe', document.getElementsByName('mot_passe')[0].value); } else { setCookie('adresse_email', '', -1); setCookie('mot_passe', '', -1); }">
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