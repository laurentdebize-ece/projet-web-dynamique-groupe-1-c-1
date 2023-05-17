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

// Création de la table "classe"
$sql = "CREATE TABLE classe (
    id_classe INT PRIMARY KEY,
    annee_promo INT
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'classe' créée avec succès.<br>";
} else {
    echo "Erreur lors de la création de la table 'classe': " . $conn->error;
}

// Création de la table "etudiant"
$sql = "CREATE TABLE etudiant (
    id_etudiant INT PRIMARY KEY,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    email VARCHAR(50),
    mdp VARCHAR(50),
    id_classe INT,
    FOREIGN KEY (id_classe) REFERENCES classe(id_classe)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'etudiant' créée avec succès.<br>";
} else {
    echo "Erreur lors de la création de la table 'etudiant': " . $conn->error;
}

// Création de la table "matiere"
$sql = "CREATE TABLE matiere (
    id_matiere INT PRIMARY KEY,
    nom VARCHAR(50),
    volume_horaires INT
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'matiere' créée avec succès.<br>";
} else {
    echo "Erreur lors de la création de la table 'matiere': " . $conn->error;
}


// Création de la table "professeur"
$sql = "CREATE TABLE professeur (
    id_prof INT PRIMARY KEY,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    email VARCHAR(50),
    mdp VARCHAR(50),
    id_matiere INT,
    FOREIGN KEY (id_matiere) REFERENCES matiere(id_matiere)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'professeur' créée avec succès.<br>";
} else {
    echo "Erreur lors de la création de la table 'professeur': " . $conn->error;
}

// Création de la table "classe_prof_matiere"
$sql = "CREATE TABLE classe_prof_matiere (
    id INT PRIMARY KEY,
    id_prof INT,
    id_classe INT,
    id_matiere INT,
    FOREIGN KEY (id_prof) REFERENCES professeur(id_prof),
    FOREIGN KEY (id_classe) REFERENCES classe(id_classe),
    FOREIGN KEY (id_matiere) REFERENCES matiere(id_matiere)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'classe_prof_matiere' créée avec succès.<br>";
} else {
    echo "Erreur lors de la création de la table 'classe_prof_matiere': " . $conn->error;
}

// Création de la table "admin"
$sql = "CREATE TABLE admin (
    nom VARCHAR(50),
    prenom VARCHAR(50),
    email VARCHAR(50),
    mdp VARCHAR(50)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'admin' créée avec succès.<br>";
} else {
    echo "Erreur lors de la création de la table 'admin': " . $conn->error;
}

// Création de la table "competence"
$sql = "CREATE TABLE competence (
    id_comp INT PRIMARY KEY,
    nom VARCHAR(50),
    deadline DATE,
    id_matiere INT,
    id_classe INT,
    id_prof INT,
    FOREIGN KEY (id_matiere) REFERENCES matiere(id_matiere),
    FOREIGN KEY (id_classe) REFERENCES classe(id_classe),
    FOREIGN KEY (id_prof) REFERENCES professeur(id_prof)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'competence' créée avec succès.<br>";
} else {
    echo "Erreur lors de la création de la table 'competence': " . $conn->error;
}

// Création de la table "Auto-Evaluation"
$sql = "CREATE TABLE auto_evaluation (
    id_auto INT PRIMARY KEY,
    id_prof INT,
    id_etudiant INT,
    id_competences INT,
    niveau VARCHAR(20),
    FOREIGN KEY (id_prof) REFERENCES professeur(id_prof),
    FOREIGN KEY (id_etudiant) REFERENCES etudiant(id_etudiant),
    FOREIGN KEY (id_competences) REFERENCES competence(id_comp)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'auto_evaluation' créée avec succès.<br>";
} else {
    echo "Erreur lors de la création de la table 'auto_evaluation': " . $conn->error;
}

// Fermeture de la connexion à la base de données
$conn->close();
?>

