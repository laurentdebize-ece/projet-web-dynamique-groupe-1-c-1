<?php

require 'import.php';

$listeClasse = "";
$listeEleve = "";
$erreurBdd = "";
$succesBdd = "";
$erreurSuppressionBdd = "";
$succesSuppressionBdd = "";
$listeSuppressionEleve = "";

$sql = "select Nom from classe";
$result = mysqli_query($db_handle, $sql);
if (!mysqli_num_rows($result)) {
  $erreurBdd =  "pas de classe";
} else {
  while ($data = mysqli_fetch_assoc($result)) {
    $listeClasse .= "<option value= " . '"' . $data['Nom'] . '"' . '>' . $data['Nom'] . "</option>";
  }
}

$sql2 = "select * from utilisateurs where Role=1";
$result2 = mysqli_query($db_handle, $sql2);
if (!mysqli_num_rows($result2)) {
  $erreurBdd =  "pas d'eleve";
} else {
  while ($data = mysqli_fetch_assoc($result2)) {
    $listeEleve .= "<option value=" . '"' . $data['Email'] . '"' . '>' . $data['Nom'] . ' ' . $data['Prenom'] . "</option>";
  }
}

if (isset($_POST["CREERCLASSE"])) {

  $NomClasse = isset($_POST['NomClasse']) ? $_POST['NomClasse'] : "";
  $Promotion = isset($_POST['Promotion']) ? $_POST['Promotion'] : "";

  $sqlUtilisateur = "SELECT * FROM classe WHERE Nom like '%$NomClasse%'";
  $resultUtilisateur = mysqli_query($db_handle, $sqlUtilisateur);
  if (mysqli_num_rows($resultUtilisateur) != 0) {
    $erreurBdd =  "Cette classe existe déjà";
  } else {
    $sqlAjoutCoursUtilisateurs = "INSERT INTO classe VALUES ('$NomClasse','$Promotion')";
    $resultAjoutCoursUtilisateurs = mysqli_query($db_handle, $sqlAjoutCoursUtilisateurs);
    if ($resultAjoutCoursUtilisateurs) {
      $succesBdd =  "La classe $NomClasse à bien été créée";
    } else {
      $erreurBdd = "La classe $NomClasse n'a pas pu être créée";
    }
  }
}

if (isset($_POST["ajouter"])) {

  $eleveSelectionne = isset($_POST['choixEleve']) ? $_POST['choixEleve'] : "";
  $classeSelectionne = isset($_POST['choixClasse']) ? $_POST['choixClasse'] : "";

  $sqlUtilisateur = "SELECT * FROM classeeleve WHERE Eleve like '%$eleveSelectionne%' and Classe like '%$classeSelectionne'";
  $resultUtilisateur = mysqli_query($db_handle, $sqlUtilisateur);
  if (mysqli_num_rows($resultUtilisateur) != 0) {
    $erreurBdd =  "Cet eleve est deja dans cette classe";
  } else {
    $sqlAjoutCoursUtilisateurs = "INSERT INTO classeeleve VALUES ('$classeSelectionne','$eleveSelectionne')";
    $resultAjoutCoursUtilisateurs = mysqli_query($db_handle, $sqlAjoutCoursUtilisateurs);
    if ($resultAjoutCoursUtilisateurs) {
      $succesBdd =  "$eleveSelectionne a bien été intégré à la classe $classeSelectionne";
    } else {
      $erreurBdd = "$eleveSelectionne n'a pas pu être intégré à la classe $classeSelectionne";
    }
  }
}

if (isset($_POST["supprimer"])) {

  $eleveSelectionne = isset($_POST['choixEleveSuppression']) ? $_POST['choixEleveSuppression'] : "";
  $classeSelectionne = isset($_POST['choixClasseSuppression']) ? $_POST['choixClasseSuppression'] : "";

  $sqlUtilisateur2 = "SELECT * FROM classeeleve WHERE Eleve like '%$eleveSelectionne%' and Classe like '%$classeSelectionne'";
  $resultUtilisateur2 = mysqli_query($db_handle, $sqlUtilisateur2);
  if (mysqli_num_rows($resultUtilisateur2) == 0) {
    $erreurSuppressionBdd =  "Cet eleve n'est pas dans cette classe";
  } else {
    $sqlSuppressionClasse = "DELETE from classeeleve where Classe like '%$classeSelectionne%' and Eleve like '%$eleveSelectionne%'";
    if (mysqli_query($db_handle, $sqlSuppressionClasse)) {
      $succesBdd =  "$eleveSelectionne a bien été supprimé de la classe $classeSelectionne";
    } else {
      $erreurBdd = "$eleveSelectionne n'a pas pu être supprimé de la classe $classeSelectionne";
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

      <form class="form" action="classe.php" method="POST">
        <h1>Créer une nouvelle classe</h1><br>

        <input type="text" placeholder="Nom de la classe" name="NomClasse" required><br>

        <label>Choisissez la promotion:</label>
        <select name="Promotion" id="Promotion">
          <option value=1>ING 1</option>
          <option value=2>ING 2</option>
          <option value=3>ING 3</option>
          <option value=4>ING 4</option>
          <option value=5>ING 5</option>
        </select><br>

        <input type="submit" class="button" name='CREERCLASSE' value='CREER UNE CLASSE'><br>
      </form>

      <form class="form" action="classe.php" method="POST">
        <h1>Ajouter un élève dans une classe</h1><br>

        <label for="choixClasse">Choisissez un classe:</label>
        <select name="choixClasse" id="choixClasse">
          <?php echo $listeClasse ?>
        </select><br>

        <label for="choixEleve">Choisissez un élève:</label>
        <select name="choixEleve" id="choixEleve">
          <?php echo $listeEleve ?>
        </select><br>

        <input type="submit" class="button" name='ajouter' value='AJOUTER'><br>
      </form>

      <form class="form" action="classe.php" method="POST">
        <h1>Supprimer un élève d'une classe</h1><br>

        <label for="choixClasseSuppression">Choisissez un cours:</label>
        <select name="choixClasseSuppression" id="choixClasseSuppression">
          <?php echo $listeClasse ?>
        </select><br>


        <label for="choixEleveSuppression">Choisissez un élève:</label>
        <select name="choixEleveSuppression" id="choixEleveSuppression">
          <?php echo $listeEleve ?>
        </select><br>

        <input type="submit" class="button" name='supprimer' value='SUPPRIMER'><br>
      </form>
    </div>
  </div>

</body>

</html>