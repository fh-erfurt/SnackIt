<link rel='stylesheet' type='text/css' href='assets/css/login.css'>


<div class="login">
	<h1 style="padding-top: 20px;">Login</h1>
	<section  class=loginstyle>
	<? if(isset($error)): ?>
		<p class='errorMessage' id=phpError><?=$error?></p>
	<? endif;?>
 
	<br />
	<br />

	<form method='post' name='loginForm' id=login-form>
		<label class="email" for='email' style="padding-right: 157px;">E-Mail</label> <br />
		<input type='email' name='email' style="margin-top: 10px;height: 20px;width: 200px;border: none;background-color: #212121;color: #FF6E00;" id='email' value=<?=isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';?> ><br />
		<span id='emailError'></span>
		<br />
		<label for='password' style="padding-right: 134px;" >Passwort</label> <br />
		<input type='password' name='password' style="margin-top: 10px;height: 20px;width: 200px;border: none;background-color: #212121;color: #FF6E00;" id='password' /><br />
		<span id='passwordError'></span><br />
		<input type='submit' name='submitBtn' value='Anmelden' class='loginButton'><br />
		<label for='Register' style="font-size: 13px;">Noch kein Konto?</label> <a href="index.php?c=accounts&a=register" style="color: #9E0000;font-size: 13px;"> Jetzt registrieren</a> <br />
	</form>
</div>	
</section>