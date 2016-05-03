<?php
include('header.php');

echo '<form class="form-signin" action="/" method="POST">';
if(!empty($error)) {
    echo '<div class="alert alert-danger" role="alert">';
    echo '<ul>'.$error.'</ul>';
    echo '</div>';
}
?>
		<h2 class="form-signin-heading">Veuillez vous identifier</h2>

		<input type="hidden" name="action" value="login" />

		<label for="inputEmail" class="sr-only">Email address</label>
		<!-- <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus> -->
		<input type="email" id="email" class="form-control" name="email" value="<?php echo IsSet($email)?$email:'';?>" placeholder="Email address" required autofocus>
		
		<label for="inputPassword" class="sr-only">Password</label>
		<!-- <input type="password" id="inputPassword" class="form-control" placeholder="Password" required> -->
		<input type="password" id="password" class="form-control" name="password" placeholder="Password" required>
		
		<!-- <button class="btn btn-lg btn-primary btn-block" type="submit" >Sign in</button> -->
		<button class="btn btn-lg btn-primary btn-block" type="submit" value="Connexion" ><i class="fa fa-sign-in"></i> Connexion</button>
	</form>
<?php include('footer.php'); ?>