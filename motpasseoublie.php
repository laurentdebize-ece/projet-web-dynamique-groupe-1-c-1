<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $caractere = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+{}[];:,.<>?";
    $longueur_mot_passe = 10;
    $mot_de_passe = "";
    for ($i = 0; $i < $longueur_mot_passe; $i++) {
        $mot_de_passe .= $caractere[rand(0, strlen($caractere) - 1)];
    }
    echo "<script>alert('Votre nouveau mot de passe est: " . $mot_de_passe . "');</script>";
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="motpasseoublie.css">
    <title>Mot de passe oublié</title>
</head>

<body>
    <div class="box">
       
        <div class="text">
            <p>
                Veuillez saisir votre adresse email afin que l'administrateur puisse vous attribuer un nouveau mot de passe :
            </p>
            
            <div class="adressemail">
                <input type="email" id="email" name="email" required>
            </div>
            <div class="envoyer">
                <button type="button" id="envoyerBtn">Envoyer</button>
            </div>
        </div>
    </div>
    <script>
        const emailInput = document.getElementById("email");
        const envoyerBtn = document.getElementById("envoyerBtn");

        envoyerBtn.addEventListener("click", function() {
            const email = emailInput.value.trim();
            const validEmail = validateEmail(email);

            if (validEmail) {
                alert("Votre demande a été envoyée à l'administrateur.");
            } else {
                alert("Veuillez saisir une adresse email valide.");
            }
        });

        function validateEmail(email) {
            if (email === "") {
                return false;
            }

            const atPos = email.indexOf("@");
            const dotPos = email.lastIndexOf(".");
            return (atPos > 0 && dotPos > atPos && dotPos < email.length - 1);
        }
    </script>
</body>

</html>