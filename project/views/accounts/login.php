<link rel='stylesheet' type='text/css' href='assets/css/login.css'>

<h1>Login</h1>
<section  class=loginstyle>
<? if(isset($error)): ?>
	<p class='errorMessage' id=phpError><?=$error?></p>
<? endif;?>



<br />
<br />
<br />
<br />


<form method='post' name='loginForm' id=login-form>
	<label for='Email'>E-Mail</label> <br />
	<input type='Email' name='Email' id='Email' value=<?=isset($_POST['Email']) ? htmlspecialchars($_POST['Email']) : '';?> ><br />>
	<span id='emailError'></span><br />
	<br />
	<label for='Password'>Passwort</label> <br />
	<input type='Password' name='Password' id='Password' /><br />
	<span id='passwordError'></span><br />
	<input type='submit' name='submitBtn' value='Anmelden' class='loginButton'><br />
</form>
</section>