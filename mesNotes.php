<?php

require 'import.php';
$erreurBdd = "";
$succesBdd = "";

$listeNotes = "";

$Email2 = $_SESSION['Email'];

$sql = "select distinct competence.Cours from competenceeleve inner join competence on (competenceeleve.Competence = competence.Titre) where competenceeleve.Eleve like '%$Email2%' and competenceeleve.Valide='3'";
$result = mysqli_query($db_handle, $sql);
if (!mysqli_num_rows($result)) {
    $erreurBdd =  "Vous n'avez aucune note";
} else {
    while ($data = mysqli_fetch_assoc($result)) {
        $cours = $data['Cours'];
        $listeNotes .= "<tr><td>" . $cours . "</td>";
        $sql2 = "Select competenceeleve.Competence from competenceeleve inner join competence on (competence.Titre = competenceeleve.Competence) where competenceeleve.Eleve like '%$Email2%' and competenceeleve.Valide = '3' and competence.cours like '%$cours%'";
        $result2 = mysqli_query($db_handle, $sql2);
        if (!mysqli_num_rows($result2)) {
            $erreurBdd =  "Vous n'avez aucune note";
        } else {
            $listeNotes .= "<td>";
            while ($data = mysqli_fetch_assoc($result2)) {
                $competence = $data['Competence'];
                $listeNotes .= $competence . "<br>";
            }
            $listeNotes .= "</td><td>";
            $sql3 = "Select competenceeleve.Note, competenceeleve.Competence from competenceeleve inner join competence on (competence.Titre = competenceeleve.Competence) where competenceeleve.Eleve like '%$Email2%' and competenceeleve.Valide = '3' and competence.cours like '%$cours%'";
            $result3 = mysqli_query($db_handle, $sql3);
            while ($data = mysqli_fetch_assoc($result3)) {
                $note = $data['Note'];
                $listeNotes .= $note . "<br>";
            }
            $listeNotes .= "</td></tr>";
        }
    }
}

?>

<html>

<head>
    <link rel="stylesheet" type="text/css" href="mesNotes.css">

</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="wrapper">

        <div class="milieuSite">

            <label class="messageErreur"><?php echo $erreurBdd ?></label><br>
            <label class="messageSucces"><?php echo $succesBdd ?></label><br>

            <table>
                <caption style=text-align:center>
                    <h2>" Mon relevé de notes "</h2>
                </caption>
                <tr>
                    <th>Matière</th>
                    <th>compétence</th>
                    <th>Note obtenue</th>
                </tr>
                <?php echo $listeNotes ?>
            </table><br>
        </div>
    </div>

</body>

</html>