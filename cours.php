<?php

require 'import.php';

$listeClasse = "";
$listeProf = "";
$listeCours = "";
$erreurBdd = "";
$succesBdd = "";
$erreurSuppressionBdd = "";
$succesSuppressionBdd = "";
$listeSuppressionEleve = "";


$sql = "select * from classe";
$result = mysqli_query($db_handle, $sql);
if (!mysqli_num_rows($result)) {
    $erreurBdd =  "pas de classe";
} else {
    while ($data = mysqli_fetch_assoc($result)) {
        $listeClasse .= "<option value= " . '"' . $data['Nom'] . '"' . '>' . $data['Nom'] . " ING" . $data['Promotion'] . "</option>";
    }
}

$sql2 = "select * from utilisateurs where Role=2";
$result2 = mysqli_query($db_handle, $sql2);
if (!mysqli_num_rows($result2)) {
    $erreurBdd =  "pas de professeur";
} else {
    while ($data = mysqli_fetch_assoc($result2)) {
        $listeProf .= "<option value=" . '"' . $data['Email'] . '"' . '>' . $data['Nom'] . ' ' . $data['Prenom'] . "</option>";
    }
}

$sql3 = "select * from cours";
$result3 = mysqli_query($db_handle, $sql3);
if (!mysqli_num_rows($result3)) {
    $erreurBdd =  "pas de cours";
} else {
    while ($data = mysqli_fetch_assoc($result3)) {
        $listeCours .= "<option value=" . '"' . $data['Nom'] . '"' . '>' . $data['Nom'] . "</option>";
    }
}


if (isset($_POST["ajouter"])) {

    $nomCours = isset($_POST['nomCours']) ? $_POST['nomCours'] : "";
    $profSelectionne = isset($_POST['choixProf']) ? $_POST['choixProf'] : "";

    $sqlUtilisateur = "SELECT * FROM cours WHERE Nom like '%$nomCours%' and Prof like '%$profSelectionne'";
    $resultUtilisateur = mysqli_query($db_handle, $sqlUtilisateur);
    if (mysqli_num_rows($resultUtilisateur) != 0) {
        $erreurBdd =  "Ce cours existe déjà";
    } else {
        $sqlAjoutCoursUtilisateurs = "INSERT INTO cours VALUES ('$nomCours','$profSelectionne')";
        $resultAjoutCoursUtilisateurs = mysqli_query($db_handle, $sqlAjoutCoursUtilisateurs);
        if ($resultAjoutCoursUtilisateurs) {
            $succesBdd =  "Le cours $nomCours enseigné par $profSelectionne à  bien été créé";
        } else {
            $erreurBdd = "Le cours $nomCours enseigné par $profSelectionne n'a pas pu être créé";
        }
    }
}

if (isset($_POST["ajoutercoursclasse"])) {

    $choixClasse = isset($_POST['choixClasse']) ? $_POST['choixClasse'] : "";
    $choixCours = isset($_POST['choixCours']) ? $_POST['choixCours'] : "";

    $sqlCoursClasse = "SELECT * FROM coursclasse WHERE Cours like '%$choixCours%' and Classe like '%$choixClasse'";
    $resultCoursClasse = mysqli_query($db_handle, $sqlCoursClasse);
    if (mysqli_num_rows($resultCoursClasse) != 0) {
        $erreurBdd =  "Ce cours est déjà enseigné à cette classe";
    } else {
        $sqlAjoutCoursClasse = "INSERT INTO coursclasse VALUES ('$choixCours','$choixClasse')";
        $resultAjoutCoursClasse = mysqli_query($db_handle, $sqlAjoutCoursClasse);
        if ($resultAjoutCoursClasse) {
            $succesBdd =  "Le cours $choixCours sera enseigné à la classe $choixClasse";
        } else {
            $erreurBdd = "Le cours $choixCours n'a pas pu être ajouté à la classe $choixClasse";
        }
    }
}

?>

<html>

<head>
    <link rel="stylesheet" type="text/css" href="mesCours.css">
    <link rel="stylesheet" type="text/css" href="competence.css">


</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="wrapper">

        <div class="milieuSite">

            <label class="messageErreur"><?php echo $erreurBdd ?></label>
            <label class="messageSucces"><?php echo $succesBdd ?></label><br>

            <form class="form" action="cours.php" method="POST">
                <h1>Créer un cours</h1><br>

                <input type="text" placeholder="Nom du cours" name="nomCours" required><br>

                <label for="choixProf">Choisissez un professeur:</label>
                <select name="choixProf" id="choixProf">
                    <?php echo $listeProf ?>
                </select><br>

                <input type="submit" class="button" name='ajouter' value='AJOUTER'><br>
            </form>

            <form class="form" action="cours.php" method="POST">
                <h1>Ajouter un cours à une classe</h1><br>

                <label for="choixClasse">Choisissez une classe:</label>
                <select name="choixClasse" id="choixClasse">
                    <?php echo $listeClasse ?>
                </select><br>

                <label for="choixProf">Choisissez un cours:</label>
                <select name="choixCours" id="choixCours">
                    <?php echo $listeCours ?>
                </select><br>

                <input type="submit" class="button" name='ajoutercoursclasse' value='AJOUTER'><br>
            </form>

        </div>
    </div>

</body>

</html>