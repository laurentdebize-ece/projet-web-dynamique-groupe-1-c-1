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
$classe = $_POST['classe'];

$sql = "SELECT * FROM classe WHERE id_classe = $classe";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // La classe existe, ajouter l'étudiant à la table "etudiant"
    $sql = "INSERT INTO etudiant (nom, prenom, email, mdp, id_classe) VALUES ('$nom', '$prenom', '$email', '$mdp', $classe)";
    
    if ($conn->query($sql) === TRUE) {
        echo "Étudiant ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout de l'étudiant : " . $conn->error;
    }
} else {
    // La classe n'existe pas, ajouter la classe à la table "classe" et ensuite ajouter l'étudiant à la table "etudiant"
    $sql = "INSERT INTO classe (id_classe, annee_promo) VALUES ($classe, 2023)";
    
    if ($conn->query($sql) === TRUE) {
        // Classe ajoutée avec succès, ajouter l'étudiant à la table "etudiant"
        $sql = "INSERT INTO etudiant (nom, prenom, email, mdp, id_classe) VALUES ('$nom', '$prenom', '$email', '$mdp', $classe)";
        
        if ($conn->query($sql) === TRUE) {
            echo "Étudiant ajouté avec succès.";
        } else {
            echo "Erreur lors de l'ajout de l'étudiant : " . $conn->error;
        }
    } else {
        echo "Erreur lors de l'ajout de la classe : " . $conn->error;
    }
}

}



// Fermer la connexion à la base de données
$conn->close();
?>
