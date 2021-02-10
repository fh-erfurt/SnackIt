<link rel='stylesheet' type='text/css' href='assets/css/register.css'>

<head>
<title><?=isset($title)? 'SnackIt: '. $title : 'SnackIt'?></title>
</head>

<div class = "register">

	<h1>Registriere dich jetzt</h1>

	<? if(isset($error)): ?>
		<p class='errorMessage'><?=$error?></p>
	<? endif;?>
	<br />
	<section class=registerStyle>

	<form method='POST'>
		<label for='firstname'>Vorname</label> <br />
		<input type='text' name='firstname' id='firstname' value=<?=isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : '';?> ><br />
		<br />
		<label for='lastname'>Nachname</label> <br />
		<input type='text' name='lastname' id='lastname' value=<?=isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : '';?> ><br />
		<br />
		<label for='email'>E-Mail</label> <br />
		<input type='email' name='email' id='email' value=<?=isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';?> ><br />
		<br />
		<label for='password'>Passwort</label> <br />
		<input type='password' name='password' id='password' /><br />
		<br />
		<label for='password2'>Passwort wiederholen</label> <br />
		<input type='password' name='password2' id='password2' /><br />
		<br />
		<label for='country'>Land</label> <br />
		<input type='text' name='country' id='country' value=<?=isset($_POST['country']) ? htmlspecialchars($_POST['country']) : '';?> ><br />
		<br />
		<label for='state'>Bundesland</label> <br />
		<input type='text' name='state' id='state' value=<?=isset($_POST['state']) ? htmlspecialchars($_POST['state']) : '';?> ><br />
		<br />
		<label for='city'>Stadt</label> <br />
		<input type='text' name='city' id='city' value=<?=isset($_POST['city']) ? htmlspecialchars($_POST['city']) : '';?> ><br />
		<br />
		<label for='street'>Straße</label> <br />
		<input type='text' name='street' id='street' value=<?=isset($_POST['street']) ? htmlspecialchars($_POST['street']) : '';?> ><br />
		<br />
		<label for='zipcode'>PLZ</label> <br />
		<input type='text' name='zipcode' id='zipcode' value=<?=isset($_POST['zipcode']) ? htmlspecialchars($_POST['zipcode']) : '';?> ><br />
		<br />
		<label for='number'>Hausnummer</label> <br />
		<input type='text' name='number' id='number' value=<?=isset($_POST['number']) ? htmlspecialchars($_POST['number']) : '';?> ><br />
		<br />
		<input type='submit' name='submit' value='Registrieren' class='registerButton'><br/>
		<label class='accExists' for='Register'>Schon Registriert?</label> <a class='loginNow' href='index.php?c=pages&a=login'> Jetzt einloggen</a> <br />
	</form>
	<br>
</div>
</section>

