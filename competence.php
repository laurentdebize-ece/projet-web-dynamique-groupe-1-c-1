<?php

require 'import.php';

$Email2 = $_SESSION['Email'];

$listeCours = "";
$errreurBdd = "";
$succesBdd = "";
$erreurSuppressionBdd = "";
$succesSuppressionBdd = "";

$cours = isset($_POST["cours"]) ? $_POST["cours"] : "";
$titreCompetence = isset($_POST["titreCompetence"]) ? $_POST["titreCompetence"] : "";
$importance = isset($_POST["niveauImportance"]) ? $_POST["niveauImportance"] : "";

if ($Role == 2) {
    $sql = "select * from cours where Prof LIKE '%$Email2%'";
    $result = mysqli_query($db_handle, $sql);
    if (!mysqli_num_rows($result)) {
        $errreurBdd =  "Vous n'avez aucun cours";
    } else {
        while ($data = mysqli_fetch_assoc($result)) {
            $listeCours .= "<option value=" . '"' . $data['Nom'] . '"' . '>' . $data['Nom'] . "</option>";
        }
    }
} else {
    $sql = "select * from cours";
    $result = mysqli_query($db_handle, $sql);
    if (!mysqli_num_rows($result)) {
        $errreurBdd =  "Il n'y a aucun cours";
    } else {
        while ($data = mysqli_fetch_assoc($result)) {
            $listeCours .= "<option value=" . '"' . $data['Nom'] . '"' . '>' . $data['Nom'] . "</option>";
        }
    }
}

if (isset($_POST["ajouterCompetence"])) {
    $sqlcoursCompetence = "SELECT * FROM competence WHERE Titre LIKE '%$titreCompetence%' and Cours like '%$cours%'";
    if (mysqli_num_rows(mysqli_query($db_handle, $sqlcoursCompetence)) != 0) {
        $errreurBdd = "Cette compétence existe déjà pour ce cours";
    } else {
        $sqleleve = "SELECT Eleve FROM classeeleve inner join coursclasse on (classeeleve.Classe = coursclasse.Classe) WHERE coursclasse.Cours LIKE '%$cours%'";
        $resultEleve = mysqli_query($db_handle, $sqleleve);
        if (mysqli_num_rows($resultEleve) == 0) {
            $errreurBdd = "Aucun élève n'assiste à ce cours";
        } else {
            $sqlAjoutCompetence = "INSERT INTO competence VALUES ('$titreCompetence','$cours','$importance')";
            $resultCompetence = mysqli_query($db_handle, $sqlAjoutCompetence);
            if ($resultEleve) {
                while ($data = mysqli_fetch_assoc($resultEleve)) { // tant qu'il y a des eleves qui assiste au cours correspondant a la competence, on lui ajoute la competence en vue d'etre evalué
                    $eleve = $data['Eleve'];
                    $sqlAjoutCompetenceEleve = "INSERT INTO competenceeleve VALUES ('$titreCompetence','$eleve','0','0','2099-12-31')";
                    $resultAjoutCompetenceEleve = mysqli_query($db_handle, $sqlAjoutCompetenceEleve);
                }
                $succesBdd = "La compétence à été ajoutée";
            } else {
                $errreurBdd = "L'ajout de la compétence a échouée";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="competence.css">
</head>

<head>
    <title>Ajouter une compétence</title>
    <link rel="stylesheet" href="competence.css">
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="wrapper">
        <div class="milieuSite">

            <label class="messageErreur"><?php echo $errreurBdd ?></label>
            <label class="messageSucces"><?php echo $succesBdd ?></label>

            <form class="form" action="competence.php" method="post">
                <h1>Créer une nouvelle compétence</h1>

                <input type="text" placeholder="Titre de la compétence" name="titreCompetence" required>

                <label>Cours correspondant</label>
                <select name="cours" id="cours" required>
                    <?php echo $listeCours ?>
                </select>

                <label>Niveau d'importance</label>
                <select name="niveauImportance" id="niveauImportance" required>
                    <option value='1'>1</option>
                    <option value='2'>2</option>
                    <option value='3'>3</option>
                    <option value='4'>4</option>
                    <option value='5'>5</option>
                </select><br>

                <input type="submit" class="button" name='ajouterCompetence' value='Ajouter une Compétence'>
            </form><br>
        </div>
    </div>

</body>

</html>
