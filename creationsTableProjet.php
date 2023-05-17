<?php

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "projetomnesmyskill";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Suppression des tables existantes
$sql = "DROP TABLE IF EXISTS auto_evaluation, classe_prof_matiere, competence, adminpro,admin, professeur, matiere, etudiant, classe";
$conn->query($sql);

// Création de la table "classe"
$sql = "CREATE TABLE classe (
    id_classe INT PRIMARY KEY,
    annee_promo INT
)";

$conn->query($sql);

// Création de la table "etudiant"
$sql = "CREATE TABLE etudiant (
    id_etudiant INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    email VARCHAR(50),
    mdp VARCHAR(50),
    id_classe INT,
    FOREIGN KEY (id_classe) REFERENCES classe(id_classe)
)";

$conn->query($sql);

// Création de la table "matiere"
$sql = "CREATE TABLE matiere (
    id_matiere INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50),
    volume_horaires INT
)";

$conn->query($sql);

// Création de la table "professeur"
$sql = "CREATE TABLE professeur (
    id_prof INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    email VARCHAR(50),
    mdp VARCHAR(50),
    id_matiere INT,
    FOREIGN KEY (id_matiere) REFERENCES matiere(id_matiere)
)";

$conn->query($sql);

// Création de la table "classe_prof_matiere"
$sql = "CREATE TABLE classe_prof_matiere (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_prof INT,
    id_classe INT,
    id_matiere INT,
    FOREIGN KEY (id_prof) REFERENCES professeur(id_prof),
    FOREIGN KEY (id_classe) REFERENCES classe(id_classe),
    FOREIGN KEY (id_matiere) REFERENCES matiere(id_matiere)
)";

$conn->query($sql);

// Création de la table "admin"
$sql = "CREATE TABLE adminpro (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    email VARCHAR(50),
    mdp VARCHAR(50)
)";

$conn->query($sql);

// Création de la table "competence"
$sql = "CREATE TABLE competence (
    id_comp INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50),
    deadline DATE,
    id_matiere INT,
    id_classe INT,
    id_prof INT,
    FOREIGN KEY (id_matiere) REFERENCES matiere(id_matiere),
    FOREIGN KEY (id_classe) REFERENCES classe(id_classe),
    FOREIGN KEY (id_prof) REFERENCES professeur(id_prof)
)";

$conn->query($sql);

// Création de la table "auto_evaluation"
$sql = "CREATE TABLE auto_evaluation (
    id_auto INT AUTO_INCREMENT PRIMARY KEY,
    id_prof INT,
    id_etudiant INT,
    id_competences INT,
    niveau VARCHAR(20),
    FOREIGN KEY (id_prof) REFERENCES professeur(id_prof),
    FOREIGN KEY (id_etudiant) REFERENCES etudiant(id_etudiant),
    FOREIGN KEY (id_competences) REFERENCES competence(id_comp)
)";

$conn->query($sql);

// Fermeture de la connexion à la base de données
$conn->close();

echo "Les tables ont été supprimées et recréées avec succès.";
?>

