<?php
/**
 * Created by PhpStorm.
 * User: 11210
 * Date: 03-03-16
 * Time: 10:04
 */
//controller
session_start();
if(isset($_POST['Suivant']))
{
    $Consigne = $_POST["Consigne"];
    include_once "vueConfirmation.php";
}
else
{
    include_once  "vueConfig.php";
}
?>
