<?php

require 'import.php';
$erreurBdd = "";
$succesBdd = "";

$listeClasse = "";

$Email2 = $_SESSION['Email'];

$sql = "select distinct classe.Nom, classe.Promotion from classe inner join coursclasse on (coursclasse.Classe = classe.Nom) inner join cours on (coursclasse.Cours = cours.Nom) where cours.Prof like '%$Email2%'";
$result = mysqli_query($db_handle, $sql);
if (!mysqli_num_rows($result)) {
    $erreurBdd =  "Vous n'enseignez a aucune classe";
} else {
    while ($data = mysqli_fetch_assoc($result)) {
        $classe = $data['Nom'];
        $promotion = $data['Promotion'];
        $listeClasse .= "<tr><td>" . $classe . ", ING" . $promotion . "</td>";
        $sql2 = "Select utilisateurs.Nom from utilisateurs inner join classeeleve on (classeeleve.Eleve = utilisateurs.Email) inner join classe on (classeeleve.Classe = classe.Nom) where classe.Nom like '%$classe%' and classe.Promotion like '%$promotion%'";
        $result2 = mysqli_query($db_handle, $sql2);
        if (!mysqli_num_rows($result2)) {
            $erreurBdd =  "Aucun eleve assiste a ce cours";
        } else {
            $listeClasse .= "<td>";
            while ($data = mysqli_fetch_assoc($result2)) {
                $nom = $data['Nom'];
                $listeClasse .= $nom . "<br><br>";
            }
            $listeClasse .= "</td><td>";
            $sql3 = "Select utilisateurs.Prenom from utilisateurs inner join classeeleve on (classeeleve.Eleve = utilisateurs.Email) inner join classe on (classeeleve.Classe = classe.Nom) where classe.Nom like '%$classe%' and classe.Promotion like '%$promotion%'";
            $result3 = mysqli_query($db_handle, $sql3);
            while ($data = mysqli_fetch_assoc($result3)) {
                $prenom = $data['Prenom'];
                $listeClasse .= $prenom . "<br><br>";
            }
            $listeClasse .= "</td><td>";
            $sql4 = "Select utilisateurs.Email from utilisateurs inner join classeeleve on (classeeleve.Eleve = utilisateurs.Email) inner join classe on (classeeleve.Classe = classe.Nom) where classe.Nom like '%$classe%' and classe.Promotion like '%$promotion%'";
            $result4 = mysqli_query($db_handle, $sql4);
            while ($data = mysqli_fetch_assoc($result4)) {
                $email = $data['Email'];
                $listeClasse .= $email . "<br><br>";
            }
            $listeClasse .= "</td></tr>";
        }
    }
}

?>

<html>

<body>

    <?php include 'navbar.php'; ?>

    <div class="wrapper">

        <div class="milieuSite">

            <label class="messageErreur"><?php echo $erreurBdd ?></label><br>
            <label class="messageSucces"><?php echo $succesBdd ?></label><br>

            <table>
                <caption style=text-align:center>
                    <h2>Mes eleves </h2>
                </caption>
                <tr>
                    <th>Cours</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>adresse Email scolaire</th>
                </tr>
                <?php echo $listeClasse ?>
            </table><br>
        </div>
    </div>

</body>

</html>