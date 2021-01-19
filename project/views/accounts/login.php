<link rel='stylesheet' type='text/css' href='assets/css/login.css'>


<div class="login">
	<h1>Login</h1>
	<section  class=loginstyle>
	<? if(isset($error)): ?>
		<p class='errorMessage' id=phpError><?=$error?></p>
	<? endif;?>
 
	<br />
	<br />

	<form method='post' name='loginForm' id=login-form>
		<label class="email" for='email'>E-Mail</label> <br />
		<input type='email' name='email' id='email' value=<?=isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';?> ><br />
		<span id='emailError'></span><br />
		<br />
		<label for='password'>Passwort</label> <br />
		<input type='password' name='password' id='password' /><br />
		<span id='passwordError'></span><br />
		<input type='submit' name='submitBtn' value='Anmelden' class='loginButton'><br />
	</form>
</div>	
</section>