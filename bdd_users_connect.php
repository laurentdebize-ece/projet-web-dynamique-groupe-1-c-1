<?php

$database = "omnesmyskills";
$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);

try{
    $db_found;
}
catch(PDOException $e){
    print ("Erreur : " . $e->getMessage() . "<br>");
    die();
}

?> 