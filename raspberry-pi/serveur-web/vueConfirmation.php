<html>
<head><h1><center>Confirmation de votre consigne</center> </h1></head>
<body>
<p>
<form method="POST" action="index.php">
<?php 
echo
(
"Votre nouvelle consigne est : 
<input type='number' name='newConsigne' required value =".$Consigne.">"
);
 ?>
</form></p>
<p><center>&copy; OmidPresident</center> </p>
</body>
</html>
