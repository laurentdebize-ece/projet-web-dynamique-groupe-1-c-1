<?php
require 'import.php';
$dateActuelle = date('Y-m-d');
$erreurBdd = "";
$succesBdd = "";
$listeCompetences = "";

$Email2 = $_SESSION['Email'];

$sql = "SELECT competence.Titre, cours.Nom, cours.Prof, competenceeleve.Date, competenceeleve.Note FROM competenceeleve INNER JOIN competence ON (competenceeleve.Competence = competence.Titre) INNER JOIN cours ON (competence.Cours = Cours.Nom) WHERE competenceeleve.Eleve LIKE '%$Email2%' AND competenceeleve.Valide = '1'";
$result = mysqli_query($db_handle, $sql);

if (!mysqli_num_rows($result)) {
    $erreurBdd = "Pas d'auto évaluation en attente";
} else {
    while ($data = mysqli_fetch_assoc($result)) {
        $listeCompetences .= "<tr>
    <td>" . $data['Titre'] . "</td>
    <td>" . $data['Nom'] . "</td>
    <td>" . $data['Prof'] . "</td>
    <td>" . $data['Date'] . "</td>
    <td>" . $data['Note'] . "</td>
    <td>
        <form action='evaluationEleve.php' method='post'>
            <select name='note' id='note'>
                <option value='0'>0</option>
                <option value='1'>1</option>
                <option value='2'>2</option>
                <option value='3'>3</option>
                <option value='4'>4</option>
                <option value='5'>5</option>
                <option value='6'>6</option>
                <option value='7'>7</option>
                <option value='8'>8</option>
                <option value='9'>9</option>
                <option value='10'>10</option>
                <option value='11'>11</option>
                <option value='12'>12</option>
                <option value='13'>13</option>
                <option value='14'>14</option>
                <option value='15'>15</option>
                <option value='16'>16</option>
                <option value='17'>17</option>
                <option value='18'>18</option>
                <option value='19'>19</option>
                <option value='20'>20</option>
            </select>
            <input type='hidden' value='" . $data['Titre'] . "' name='competence'>
            <input type='submit' class='button' name='autoEvaluation' value='Auto-évaluation'>
        </form>
    </td>
</tr>";
    }
}

if (isset($_POST["autoEvaluation"])) {
    $competence = $_POST["competence"];
    $note = $_POST["note"];

    $sqlEvaluer = "UPDATE competenceeleve SET Note='$note', Valide='2' WHERE Competence LIKE '%$competence%' AND Eleve LIKE '%$Email2%'";
    $resultEvaluer = mysqli_query($db_handle, $sqlEvaluer);

    if ($resultEvaluer) {
        $succesBdd = "L'auto-évaluation a bien été transmise";
    } else {
        $erreurBdd = "L'auto-évaluation n'a pas pu être transmise";
    }
}
?>

<html>

<head><link rel="stylesheet" href="evaluationEleve.css"></head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="wrapper">
        <div class="milieuSite">
            <label class="messageErreur"><?php echo $erreurBdd ?></label><br>
            <label class="messageSucces"><?php echo $succesBdd ?></label><br>
            <table>
                <caption style="text-align:center">
                    <h2>Liste des compétences non évaluées</h2>
                </caption>
                <tr>
                    <th>Compétence</th>
                    <th>Cours</th>
                    <th>Enseignant</th>
                    <th>Date butoire</th>
                    <th>Note</th>
                    <th>Soumettre son auto-évaluation</th>
                </tr>
                <?php echo $listeCompetences ?>
            </table><br>
        </div>
    </div>
</body>
</html>
