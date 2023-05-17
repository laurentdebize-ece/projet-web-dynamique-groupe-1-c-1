<!DOCTYPE html>
<html>

<head>
    <title>Page divisée verticalement en deux</title>
    <link rel="stylesheet" type="text/css" href="administration.css">
</head>

<body>
    <div class="container">
        <div class="left">
            <img src="paris.jpg" alt="image">
            <div class="text">La plus belle ville du monde<br>LYON</div>

        </div>
        <div class="right">
            <img src="logo.png" alt="Logo" class="logo">

            <p class="titre">Connexion avec votre compte professionnel</p>
            <form method="post">
                <label for="adresse_email"></label>
                <input type="text" name="adresse_email" required>

                <label for="mot_passe"></label>
                <input type="password" name="mot_passe" required>

                <input type="submit" value="Enregistrer">
            </form>
            <footer><p> © 2023 projet_web_dynamique</p></footer>

        </div>
    </div>

</body>

</html>








<?php
// Informations de connexion à la base de données
$host = "localhost"; // ou l'adresse IP du serveur MySQL
$dbname = "nom_de_la_base_de_donnees";
$username = "root";
$password = "root";

// Connexion à la base de données avec PDO
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $adresse_email = $_POST["adresse_email"];
        $mot_passe = $_POST["mot_passe"];

        // Requête SQL pour chercher l'utilisateur correspondant à l'email et au mot de passe donnés
        $query = "SELECT * FROM utilisateurs WHERE adresse_email = :email AND mot_passe = :password";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":email", $adresse_email);
        $stmt->bindParam(":password", $mot_passe);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result) {
            // Les identifiants sont corrects, on peut autoriser la connexion
            echo "Connexion autorisée !";
        } else {
            // Les identifiants sont incorrects, on ne peut pas autoriser la connexion
            echo "Email ou mot de passe incorrect.";
        }
    }
} catch (PDOException $e) {
    echo "Une erreur s'est produite : " . $e->getMessage();
}


?>