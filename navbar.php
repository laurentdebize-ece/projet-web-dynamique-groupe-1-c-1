<?php 
include 'import.php';
?>

<html>

<body>
  <nav class="navbar content navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
     
     </div>
         <ul class="nav navbar-nav">
            <li><a class="navbar-brand" href="#" id="BoutonMenu" onclick="myFunction()"><strong> MENU </strong></a></li>
            <?php echo $affichageAdmin ?>
            
          </ul>
         <ul class = "nav navbar-nav navbar-right">
         <li><a class="nav-link disabled" href="#" id="BoutonMonCompte" onclick="myFunction()"> <?php echo $Nom ?> <?php echo $Prenom ?> </a></li>
         <li><a class="navbar-brand" href="#" id="buttonDeco" onclick="myFunction()"><strong> DECONNEXION </strong></a></li>

          </ul>
    </div>
  </nav>
 
<script type="text/javascript">

    document.getElementById("BoutonMenu").onclick = function () {
        location.href = "menu.php";
    };
    document.getElementById("BoutonMonCompte").onclick = function () {
        location.href = "monCompte.php";
    };
    document.getElementById("buttonDeco").onclick = function () {
        location.href = "connexion.php"; 
    };


</script>
</body>