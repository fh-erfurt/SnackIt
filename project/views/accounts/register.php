<h1>Registriere dich jetzt</h1>
<? if(isset($error)): ?>
	<p class='errorMessage'><?=$error?></p>
<? endif;?>
<br />
<section class=registrationform>

<form method='POST'>
	<label for='Firstname'>Vorname</label> <br />
	<input type='text' name='Firstname' id='Firstname' value=<?=isset($_POST['Firstname']) ? htmlspecialchars($_POST['Firstname']) : '';?> ><br />

	<label for='Lastname'>Nachname</label> <br />
	<input type='text' name='Lastname' id='Lastname' value=<?=isset($_POST['Lastname']) ? htmlspecialchars($_POST['Lastname']) : '';?> ><br />
	<br />

	<label for='Email'>E-Mail</label> <br />
	<input type='Email' name='Email' id='Email' value=<?=isset($_POST['Email']) ? htmlspecialchars($_POST['Email']) : '';?> ><br />

	<label for='Password'>Passwort</label> <br />
	<input type='Password' name='Password' id='Password' /><br />

	<label for='Password2'>Passwort wiederholen</label> <br />
	<input type='Password' name='Password2' id='Password2' /><br />
    <br />
	<label for='Country'>Land</label> <br />
	<input type='text' name='Country' id='Country' value=<?=isset($_POST['Country']) ? htmlspecialchars($_POST['Country']) : '';?> ><br />

	<label for='State'>Bundesland</label> <br />
	<input type='text' name='State' id='State' value=<?=isset($_POST['State']) ? htmlspecialchars($_POST['State']) : '';?> ><br />

	<label for='City'>Stadt</label> <br />
	<input type='text' name='City' id='City' value=<?=isset($_POST['City']) ? htmlspecialchars($_POST['City']) : '';?> ><br />

	<label for='Street'>Straße</label> <br />
	<input type='text' name='Street' id='Street' value=<?=isset($_POST['Street']) ? htmlspecialchars($_POST['Street']) : '';?> ><br />

	<label for='Zipcode'>PLZ</label> <br />
	<input type='text' name='Zipcode' id='Zipcode' value=<?=isset($_POST['Zipcode']) ? htmlspecialchars($_POST['Zipcode']) : '';?> ><br />

	<label for='Number'>Hausnummer</label> <br />
	<input type='text' name='Number' id='Number' value=<?=isset($_POST['Number']) ? htmlspecialchars($_POST['Number']) : '';?> ><br />
	<br />
	<input type='submit' name='submit' value='Registrieren' class='registerButton'><br/>
</form>
</section>