<?php
include('header.php');

if(!empty($error)) {
    echo '<ul class="error">'.$error.'</ul>';
}
?>
<form action="/" method="POST">
    <input type="hidden" name="action" value="login" />
    <label for="email">Identifiant :</label> <input type="text" id="email" name="email" value="<?php echo IsSet($email)?$email:''; ?>" /><br />
    <label for="password">Mot de passe :</label> <input type="password" id="password" name="password" /><br />
    <input type="submit" value="Connexion" />
</form>
<?php include('footer.php'); ?>