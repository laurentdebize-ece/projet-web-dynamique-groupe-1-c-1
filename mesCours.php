<?php

require 'import.php';
$erreurBdd = "";
$succesBdd = "";

$listeCours = "";

$Email2 = $_SESSION['Email'];

$sql = "select classe.Nom, classe.Promotion from classe inner join classeeleve on (classe.Nom = classeeleve.Classe) where classeeleve.Eleve like '%$Email2%'";
$result = mysqli_query($db_handle, $sql);
if (!mysqli_num_rows($result)) {
    $erreurBdd =  "Vous n'appartenez a aucune classe";
} else {
    while ($data = mysqli_fetch_assoc($result)) {
        $classe = $data['Nom'];
        $promotion = $data['Promotion'];
        $sql2 = "Select distinct cours.Nom, cours.Prof from classe inner join coursclasse on (coursclasse.Classe = classe.Nom) inner join cours on (coursclasse.Cours= cours.Nom) where classe.Nom like '%$classe%' and classe.Promotion like '%$promotion%'";
        $result2 = mysqli_query($db_handle, $sql2);
        if (!mysqli_num_rows($result2)) {
            $erreurBdd =  "Vous n'assistez a aucun cours";
        } else {
            while ($data = mysqli_fetch_assoc($result2)) {
                $cours = $data['Nom'];
                $listeCours .= "<tr>
                <td>" . $data['Nom'] . "</td>
                <td>" . $data['Prof'] . "</td>";
                $sql3 = "select Titre from competence where cours like '%$cours%'";
                $result3 = mysqli_query($db_handle, $sql3);
                if (!mysqli_num_rows($result2)) {
                    $listeCours .= "<td>Aucune compétence dans cette matiere<td></tr>";
                } else {
                    $listeCours .= "<td>";
                    while ($data = mysqli_fetch_assoc($result3)) {
                        $listeCours .=  $data['Titre'] . "<br>";
                    }
                    $listeCours .= "</td></tr>";
                }
            }
        }
    }
}

?>

<html>

<head>
    <link rel="stylesheet" type="text/css" href="mesCours.css">

</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="wrapper">

        <div class="milieuSite">

            <label class="messageErreur"><?php echo $erreurBdd ?></label><br>
            <label class="messageSucces"><?php echo $succesBdd ?></label><br>

            <table>
                <caption style=text-align:center>
                    <h2>" Mes cours "</h2>
                </caption>
                <tr>
                    <th>Matière</th>
                    <th>Professeur</th>
                    <th>Competences à acquerir</th>
                </tr>
                <?php echo $listeCours ?>
            </table><br>
        </div>
    </div>

</body>

</html>