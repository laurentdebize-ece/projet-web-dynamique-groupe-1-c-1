<?php


// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "projetomnesmyskill";

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

$sql = "INSERT INTO professeur (nom, prenom, mdp, email) VALUES ('$nom', '$prenom', '$mdp', '$email')";

if ($conn->query($sql) === TRUE) {
    echo "Le professeur a été ajouté avec succès à la base de données.";
} else {
    echo "Erreur lors de l'ajout du professeur : " . $conn->error;
}

}elseif ($action === "supp") {
    // Récupérer les valeurs du formulaire de suppression
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $matiere = $_POST['matiere'];
  
    // Préparer et exécuter la requête SQL pour la suppression du professeur
    $sql = "DELETE FROM professeur WHERE nom = '$nom' AND prenom = '$prenom' ";
  
    if ($conn->query($sql) === TRUE) {
      echo "Le professeur a été supprimé avec succès de la base de données.";
    } else {
      echo "Erreur lors de la suppression du professeur : " . $conn->error;
    }
}



// Fermer la connexion à la base de données
$conn->close();
?>
