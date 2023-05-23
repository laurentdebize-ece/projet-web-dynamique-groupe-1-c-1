<?php

$database = "omnesmyskills";
$db_handle = mysqli_connect('localhost', 'root', 'root');
$db_found = mysqli_select_db($db_handle, $database);

try {
  $db_found;
} catch (PDOException $e) {
  print("Erreur : " . $e->getMessage() . "<br>");
  die();
}

?>

<html>

<body>
  <style>
    <?php
    session_start();
    $Nom = $_SESSION['Nom'];
    $Prenom = $_SESSION['Prenom'];
    $Email = $_SESSION['Email'];
    $Role = $_SESSION['Role'];
    ?>
  </style>

  <title>OMNES MySkills</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="http://localhost/projet-web-dynamique-groupe-1-c-1/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="icon" type="image/png" sizes="16x16" href="http://localhost/projet-web-dynamique-groupe-1-c-1/images/logo.jpg">

</body>