<?php

// CONTROLLER

session_start();

include_once "vueConfig.php";

if(isset($_POST['Suivant']))
{
$Consigne = $_POST["Consigne"];

include_once "vueConfirmation.php";

}
?>
