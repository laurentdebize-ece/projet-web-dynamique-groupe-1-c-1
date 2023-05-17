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

if ($action == 'ajout') {
  $nom = $_POST['nom'];
  $prenom = $_POST['prenom'];
  $mdp = $_POST['mdp'];
  $email = $_POST['email'];
  $matiere = $_POST['matiere'];

  // Vérifier si la matière existe dans la table matiere
  $sql = "SELECT id_matiere FROM matiere WHERE nom = '$matiere'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // La matière existe, récupérer son ID
    $row = $result->fetch_assoc();
    $idMatiere = $row['id_matiere'];
  } else {
    // La matière n'existe pas, l'ajouter à la table matiere
    $sql = "INSERT INTO matiere (nom, volume_horaires) VALUES ('$matiere', 2023)";
    if ($conn->query($sql) === TRUE) {
      $idMatiere = $conn->insert_id;
    } else {
      echo "Erreur lors de l'ajout de la matière : " . $conn->error;
      exit;
    }
  }

  // Insérer le professeur dans la table professeur
  $sql = "INSERT INTO professeur (nom, prenom, email, mdp, id_matiere) VALUES ('$nom', '$prenom', '$email', '$mdp', $idMatiere)";
  if ($conn->query($sql) === TRUE) {
    $idProfesseur = $conn->insert_id;

    // Vérifier si des classes ont été fournies
    if (isset($_POST['classe']) && isset($_POST['promo'])) {
      $classes = $_POST['classe'];
      $promos = $_POST['promo'];

      // Parcourir les classes et promos pour les ajouter à la table classe si elles n'existent pas
      for ($i = 0; $i < count($classes); $i++) {
        $classe = $classes[$i];
        $promo = $promos[$i];

        $sql = "SELECT id_classe FROM classe WHERE id_classe = '$classe'";
        $result = $conn->query($sql);

        if ($result->num_rows == 0) {
          $sql = "INSERT INTO classe (id_classe, promo) VALUES ('$classe', '$promo')";
          if ($conn->query($sql) !== TRUE) {
            echo "Erreur lors de l'ajout de la classe : " . $conn->error;
            exit;
          }
        }

        // Lier le professeur à la classe et à la matière dans la table classe_prof_matiere
        $sql = "INSERT INTO classe_prof_matiere (id_classe, id_professeur, id_matiere) VALUES ('$classe', '$idProfesseur', '$idMatiere')";
        if ($conn->query($sql) !== TRUE) {
          echo "Erreur lors de l'ajout du lien entre la classe, le professeur et la matière : " . $conn->error;
          exit;
        }
      }
    }

    echo "Le professeur a été ajouté avec succès à la base de données.";
  } else {
    echo "Erreur lors de l'ajout du professeur : " . $conn->error;
  }
} elseif ($action === "supp") {
  // Récupérer les valeurs du formulaire de suppression
  $nom = $_POST['nom'];
  $prenom = $_POST['prenom'];

  // Préparer et exécuter la requête SQL pour la suppression du professeur
  $sql = "DELETE FROM professeur WHERE nom = '$nom' AND prenom = '$prenom'";

  if ($conn->query($sql) === TRUE) {
    echo "Le professeur a été supprimé avec succès de la base de données.";
  } else {
    echo "Erreur lors de la suppression du professeur : " . $conn->error;
  }
}

// Fermer la connexion à la base de données
$conn->close();
?>
