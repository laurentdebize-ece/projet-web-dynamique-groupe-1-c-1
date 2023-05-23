<?php

require 'import.php';
$dateActuelle = date('Y-m-d');
$erreurBdd = "";
$succesBdd = "";
$listeCompetenceNonEvaluee = "";
$listeCompetenceAutoEvaluee = "";

$Email2 = $_SESSION['Email'];


$sql = "select distinct competence.Titre, cours.Nom, cours.Prof from competenceeleve inner join competence on (competenceeleve.Competence = competence.Titre) inner join cours on (competence.Cours = Cours.Nom) where competenceeleve.Valide = '0' and cours.Prof like '%$Email2%'";
$result = mysqli_query($db_handle, $sql);
if (!mysqli_num_rows($result)) {
    $erreurBdd =  "Pas de compétence à evaluer";
} else {
    while ($data = mysqli_fetch_assoc($result)) {
        $listeCompetenceNonEvaluee .= "<tr>
    <td>" . $data['Titre'] . "</td>
    <td>" . $data['Nom'] . "</td>
    <form action='evaluationProf.php' method='post'>
    <td><input type = 'date' name = 'date'></td>
    <input type='hidden' value='" . $data['Titre'] . "' name='competence'>
    <td><input type='submit' class='button' name='demanderEvaluation' value='Demander une Evaluation'></td>
    </form></tr>";
    }
}

$sql2 = "select competenceeleve.Eleve, competenceeleve.Note, competence.Titre, cours.Nom from competenceeleve inner join competence on (competenceeleve.Competence = competence.Titre) inner join cours on (competence.Cours = Cours.Nom) where competenceeleve.Valide = '2' and  cours.Prof like '%$Email2%'";
$result2 = mysqli_query($db_handle, $sql2);
if (!mysqli_num_rows($result2)) {
    $erreurBdd =  "Pas d'auto evaluation à controler'";
} else {
    while ($data = mysqli_fetch_assoc($result2)) {
        $note = $data['Note'];
        $listeCompetenceAutoEvaluee .= "<tr>
    <td>" . $data['Eleve'] . "</td>
    <td>" . $data['Titre'] . "</td>
    <td>" . $data['Nom'] . "</td>
    <td>" . $data['Note'] . "</td>
    <td><form action='evaluationProf.php' method='post'>
    <select name='note' id='note'>
        <option default value = '%$note%'>$note</option>
        <option value = '0'>0</option>
        <option value = '1'>1</option>
        <option value = '2'>2</option>
        <option value = '3'>3</option>
        <option value = '4'>4</option>
        <option value = '5'>5</option>
        <option value = '6'>6</option>
        <option value = '7'>7</option>
        <option value = '8'>8</option>
        <option value = '9'>9</option>
        <option value = '10'>10</option>
        <option value = '11'>11</option>
        <option value = '12'>12</option>
        <option value = '13'>13</option>
        <option value = '14'>14</option>
        <option value = '15'>15</option>
        <option value = '16'>16</option>
        <option value = '17'>17</option>
        <option value = '18'>18</option>
        <option value = '19'>19</option>
        <option value = '20'>20</option>
    <input type='hidden' value='" . $data['Titre'] . "' name='competence'>
    <input type='hidden' value='" . $data['Eleve'] . "' name='eleve'></td>
    <td><input type='submit' class='button' name='confirmerEvaluation' value='Confirmer une Evaluation'></td>
    </form></tr>";
    }
}

if (isset($_POST["demanderEvaluation"])) {
    $date = $_POST["date"];
    $competence = $_POST["competence"];

    $sqlEvaluer = "update competenceeleve set date='$date', Valide='1' where Competence like '%$competence%'";
    $resultEvaluer = mysqli_query($db_handle, $sqlEvaluer);
    if ($resultEvaluer) {
        $succesBdd = "La demande d'auto évaluation a bien été transmise";
    } else {
        $erreurBdd = "La demande d'auto évaluation n'a pas pu etre transmise";
    }
}

if (isset($_POST["confirmerEvaluation"])) {
    $note = $_POST["note"];
    $competence = $_POST["competence"];
    $eleve = $_POST["eleve"];


    $sqlEvaluer = "update competenceeleve set Valide='3', Note ='%$note%' where Competence like '%$competence%' and Eleve like '%$eleve%'";
    $resultEvaluer = mysqli_query($db_handle, $sqlEvaluer);
    if ($resultEvaluer) {
        $succesBdd = "L'auto evaluation a été accptée";
    } else {
        $erreurBdd = "La demande d'auto évaluation a été renvoyée";
    }
}


?>

<html>
    <head><link rel="stylesheet" href="evaluationsProf.css"></head>

<body>

    <?php include 'navbar.php'; ?>
    
    
    <div class="wrapper">

        <div class="milieuSite">

            <label class="messageErreur"><?php echo $erreurBdd ?></label><br>
            <label class="messageSucces"><?php echo $succesBdd ?></label><br>

            <table>
                <caption style=text-align:center>
                    <h2>Liste des compétences non évaluées</h2>
                </caption>
                <tr>
                    <th>Competence</th>
                    <th>Cours</th>
                    <th>Date butoire</th>
                    <th>Evaluer</th>
                </tr>
                <?php echo $listeCompetenceNonEvaluee ?>
            </table><br>

            <table>
                <caption style=text-align:center>
                    <h2>Liste des compétences non évaluées</h2>
                </caption>
                <tr>
                    <th>Eleve</th>
                    <th>Competence</th>
                    <th>Cours</th>
                    <th>Auto Evaluation</th>
                    <th>Evaluer</th>
                    <th></th>
                </tr>
                <?php echo $listeCompetenceAutoEvaluee ?>
            </table><br>
        </div>
    </div>

</body>

</html>