<?php
include('header.php');

if(!empty($error)) {
    echo '<ul class="error-login">'.$error.'</ul>';
}
?>

<div class="container">
	<form class="form-signin" action="/" method="POST">
		<h2 class="form-signin-heading">Please sign in</h2>

		<input type="hidden" name="action" value="login" />

		<label for="inputEmail" class="sr-only">Email address</label>
		<!-- <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus> -->
		<input type="email" id="email" class="form-control" name="email" value="<?php echo IsSet($email)?$email:'';?>" placeholder="Email address" required autofocus>
		
		<label for="inputPassword" class="sr-only">Password</label>
		<!-- <input type="password" id="inputPassword" class="form-control" placeholder="Password" required> -->
		<input type="password" id="password" class="form-control" name="password" placeholder="Password" required>
		
		<div class="checkbox">
			<label><input type="checkbox" value="remember-me"> Remember me</label>
		</div>

		<!-- <button class="btn btn-lg btn-primary btn-block" type="submit" >Sign in</button> -->
		<button class="btn btn-lg btn-primary btn-block" type="submit" value="Connexion" >Sign in</button>
	</form>
</div> 

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../js/ie10-viewport-bug-workaround.js"></script>
<?php include('footer.php'); ?> 