<?php
include 'import.php';

$affichageAdmin = "";

if ($Role == "3") {
  $affichageAdmin .= " <li><a class=\"navbar-brand\" href=\"utilisateurs.php\"><strong>Utilisateurs</strong></a></li>
      <li><a class=\"navbar-brand\" href=\"classe.php\"><strong>Classes</strong></a></li>
      <li><a class=\"navbar-brand\" href=\"cours.php\"><strong>Cours</strong></a></li>
      <li><a class=\"navbar-brand\" href=\"competence.php\"><strong>Competences</strong></a></li>";
} else if ($Role == "2") {
  $affichageAdmin .= "<li><a class=\"navbar-brand\" href=\"mesEleves.php\"><strong>Mes Eleves</strong></a></li>
  <li><a class=\"navbar-brand\" href=\"competence.php\"><strong>Competences</strong></a></li>
  <li><a class=\"navbar-brand\" href=\"evaluationProf.php\"><strong>Evaluations</strong></a></li>";
} else {
  $affichageAdmin .= "<li><a class=\"navbar-brand\" href=\"maClasse.php\"><strong>Ma Classe</strong></a></li>
  <li><a class=\"navbar-brand\" href=\"mesCours.php\"><strong>Mes Cours</strong></a></li>
  <li><a class=\"navbar-brand\" href=\"evaluationEleve.php\"><strong>Evaluer mes compétences</strong></a></li>
  <li><a class=\"navbar-brand\" href=\"mesNotes.php\"><strong>Relevé de notes</strong></a></li>";
}
?>

<html>

<head>
  <link rel="stylesheet" type="text/css" href="navbar.css">

</head>

<body>
  <div class="navbar">

    <nav class="navbar content navbar-inverse navbar-fixed-top">

      <div class="container-fluid">
        <div class="navbar-header">

        </div>
        <ul class="nav navbar-nav">
          <li><a class="navbar-brand" href="menu.php"><strong> MENU </strong></a></li>
          <?php echo $affichageAdmin ?>

        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a class="nav-link disabled" href="monCompte.php"> <?php echo $Nom ?> <?php echo $Prenom ?> </a></li>
          <li><a class="navbar-brand" href="connexion.php"><strong> DECONNEXION </strong></a></li>

        </ul>
      </div>
  </div>

  </nav>
  </nav>
</body>