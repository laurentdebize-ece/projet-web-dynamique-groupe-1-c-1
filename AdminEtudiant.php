<?php


// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "formmulaire";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

$action = $_POST['action'];

if ( $action == 'ajout'){

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$mdp = $_POST['mdp'];
$email = $_POST['email'];

$sql = "INSERT INTO etudiant (nom, prenom, mdp ) VALUES ('$nom', '$prenom', '$mdp')";

if ($conn->query($sql) === TRUE) {
    echo "Le professeur a été ajouté avec succès à la base de données.";
} else {
    echo "Erreur lors de l'ajout du professeur : " . $conn->error;
}
}



// Fermer la connexion à la base de données
$conn->close();
?>
