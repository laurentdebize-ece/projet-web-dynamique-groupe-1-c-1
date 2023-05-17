<!DOCTYPE html>
<html>
<head>
  <title>Omnes Skill</title>
  <link rel="stylesheet" type="text/css" href="admin.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="admin.js"></script>
</head>
<body>
  <header>
    <h1>Omnes Skill</h1>
  </header>
  <nav>
    <ul>
      <li><a href="#" onclick="loadSection('accueil')">Accueil</a></li>
      <li><a href="#" onclick="loadSection('professeur')">Professeur</a></li>
      <li><a href="#" onclick="loadSection('etudiant')">Étudiant</a></li>
    </ul>
  </nav>
  <section id="content">
    <!-- Contenu de la section chargé dynamiquement -->
  </section>
</body>
</html>
