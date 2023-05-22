<?php

require 'import.php';
$erreurBdd = "";
$succesBdd = "";

$listeClasse = "";

$Email2 = $_SESSION['Email'];

$sql = "select classe.Nom, classe.Promotion from classe inner join classeeleve on (classe.Nom = classeeleve.Classe) where classeeleve.Eleve like '%$Email2%'";
$result = mysqli_query($db_handle, $sql);
if (!mysqli_num_rows($result)) {
    $erreurBdd =  "Vous n'appartenez a aucune classe";
} else {
    while ($data = mysqli_fetch_assoc($result)) {
        $classe = $data['Nom'];
        $promotion = $data['Promotion'];
        $sql2 = "Select utilisateurs.Nom,utilisateurs.Prenom,utilisateurs.Email from utilisateurs inner join classeeleve on (utilisateurs.Email = classeeleve.Eleve) inner join classe on (classeeleve.Classe = classe.Nom) where classe.Nom like '%$classe%' and classe.Promotion like '%$promotion%'";
        $result2 = mysqli_query($db_handle, $sql2);
        if (!mysqli_num_rows($result2)) {
            $erreurBdd =  "Il n'y a personne d'autre dans votre classe";
        } else {
            while ($data = mysqli_fetch_assoc($result2)) {
                $listeClasse .= "<tr>
                <td>" . $data['Nom'] . "</td>
                <td>" . $data['Prenom'] . "</td>
                <td>" . $data['Email'] . "</td>
                </tr>";
            }
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
                    <h2>Ma Classe</h2>
                </caption>
                <tr>
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