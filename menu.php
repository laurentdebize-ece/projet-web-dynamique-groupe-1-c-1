<?php include 'import.php' ?>

<html>

<head>
  <title>Dashboard</title>
</head>

<body>
  <?php include 'navbar.php' ?>
  <div class="container-fluid text-center">
    <div class="row content">
      <div class="col-sm-2 gauche"></div>
      <div class="col-sm-8 milieu"><br><br><br>
        <table id='tableau'>
          <caption style=text-align:center><h2>Liste des Livres</h2></caption>
          <tr>
            <th>Titre</th>
            <th>Date de publication</th>
            <th>Editeur</th>
            <th>Nom de l'auteur</th>
            <th>Prénom de l'auteur</th>
            <th>Supprimer</th>
          </tr>
        </table>
      </div>
      <div class="col-sm-2 droite"></div>
    </div>
  </div>
</body>

</html>