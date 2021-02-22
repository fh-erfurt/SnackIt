<link rel='stylesheet' type='text/css' href='assets/css/login.css'>

<head>
	<title><?= isset($title) ? 'SnackIt: ' . $title : 'SnackIt' ?></title>
</head>

<body>
	<div class="login">
		<br>
		<h1>Login</h1>
		<section class=loginstyle>
			<? if(isset($error)): ?>
			<p class='errorMessage' id=phpError><?= $error ?></p>
			<? endif;?>

			<br>
			<br>
			<!-- The Login Form -->
			<form method='post' name='loginForm' id=login-form>
				<label for='email'>E-Mail</label> <br>
				<input type='email' name='email' id='email' value=<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>><br>
				<br>
				<label for='password'>Passwort</label> <br>
				<input type='password' name='password' id='password' /><br>
				<br>
				<input type='submit' name='submitBtn' value='Anmelden' class='loginButton' id='submitBtn'><br>
				<br>
				<input class="check" type="checkbox" name="rememberMe" id="check" value="set" <?= isset($_POST['rememberMe']) ? 'checked' : '' ?>>
				<label for="check">angemeldet bleiben?</label><br>
				<br>
				<p class="error" id="errorfield">
					<?echo $errMsg;?>
				</p><br>
				<p class='noAcc' for='Register'>Noch kein Konto?<a class='registerNow' href='index.php?c=pages&a=register'> Jetzt registrieren</a></p> <br>


				<br>
			</form>
		</section>
	</div>
	<script src='assets/js/savePW.js'></script>
</body>