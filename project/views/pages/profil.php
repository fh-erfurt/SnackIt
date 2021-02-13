<link rel='stylesheet' type='text/css' href='assets/css/profil.css'>

<head>
<title><?=isset($title)? 'SnackIt: '. $title : 'SnackIt'?></title>
</head>

<div class="profile">
    <br>
    <h1>Profil</h1>
        <? if(isset($message)): ?>
            <section class='message <?=$messageType?>'>
                <?=$message?>
            </section>
        <? endif; ?>

        <br>
        <br>

    <form method=post>
        
		
		
		
		
		
		
		<? if(isset($changeEmail) && $changeEmail === true):?>
            <section class=Email>
                <h2>Email ändern</h2> <br>

                        <label>Neue Email</label> <br>
                        <input type=email name=NewEmail> <br>
                        
            </section>
            <br>
		<? elseif(isset($changePassword) && $changePassword === true):?>
            <section class=password>
                <h2>Passwort ändern</h2> <br>

                        <label>Altes Passwort</label> <br>
                        <input type=password name=oldPassword> <br>
                        <br>
                        <label>Neues Passwort</label> <br>
                        <input type=password name=newPassword> <br>
                        <br>
                        <label>Neues Passwort wiederholen</label> <br>                        
                        <input type=password name=newPassword2>
            </section>
            <br>
        <? else:?>
            <section class=person>
                <h2>Personendaten</h2> <br>

                    <label>Name: </label><label class="label2"><?=$Account['FirstName'] . ' ' . $Account['LastName']?></label> <br>
                    <label>E-mail: </label><label class="label2"><?=$Account['Email']?></label>
            </section>
            <br>    
            <section class=address>
                <h2>Adresse</h2> <br>

                <label class="label2"><?=$Account['Street'] . ' ' . $Account['Number']?></label><br>
                <label class="label2"><?=$Account['Zipcode'] . ' ' . $Account['City']?></label><br>
                <label class="label2"><?=$Account['Country']?></label>
            </section>
            <br>
        <? endif; ?>
        
		
		
		<section class=change>
		
		<? if(isset($changeEmail) && $changeEmail === true):?>
                <input class='button' type=submit name=confirmEmail value='Email aktualisieren'> <br>
                <input class='backButton' type=submit name=cancel value='Zurück'>
            <? elseif(isset($changePassword) && $changePassword === true):?>
                <input class='button' type=submit name=confirmPassword value='Passwort aktualisieren'> <br>
                <input class='backButton' type=submit name=cancel value='Zurück'>
            <? else: ?>
                <input class='button' type=submit name=changePassword value='Passwort ändern'>
				<input class='button' type=submit name=changeEmail value='Email ändern'>
            <? endif; ?>
        </section>
    </form>
</div>