<link rel='stylesheet' type='text/css' href='assets/css/profil.css'>

<head>
    <title><?= isset($title) ? 'SnackIt: ' . $title : 'SnackIt' ?></title>
</head>

<div class="profile">
    <br>
    <h1>Profil</h1>


    <br>
    <br>

    <form method=post>
<!-- The Profile Page with all its options -->
        <? if(isset($changeEmail) && $changeEmail === true):?>
        <section>
            <h2>Email ändern</h2> <br>

            <label>Neue Email</label> <br>
            <input type=email name=NewEmail> <br>

        </section>
        <br>
		<!-- If the right button is set the menue of the option opens -->
        <? elseif(isset($changePassword) && $changePassword === true):?>
        <section>
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
        <section>
            <h2>Personendaten</h2> <br>

            <label>Name: </label><label><?= $Account['FirstName'] . ' ' . $Account['LastName'] ?></label> <br>
            <label>E-mail: </label><label><?= $Account['Email'] ?></label>
        </section>
        <br>
        <section>
            <h2>Adresse</h2> <br>

            <label><?= $Account['Street'] . ' ' . $Account['Number'] ?></label><br>
            <label><?= $Account['Zipcode'] . ' ' . $Account['City'] ?></label><br>
            <label><?= $Account['Country'] ?></label>
        </section>
        <br>
        <? endif; ?>



        <section>
<!-- all the buttons -->
            <? if(isset($changeEmail) && $changeEmail === true):?>
            <input class='button' type=submit name=confirmEmail value='Email aktualisieren'> <br>
            <br>
            <? if(isset($message)): ?>
            <p class='message <?= $messageType ?>'><?= $message ?></p> <br>
            <? endif; ?>
            <input class='backButton' type=submit name=cancel value='Zurück'>
            <? elseif(isset($changePassword) && $changePassword === true):?>
            <input class='button' type=submit name=confirmPassword value='Passwort aktualisieren'> <br>
            <br>
            <? if(isset($message)): ?>
            <p class='message <?= $messageType ?>'><?= $message ?></p> <br>
            <? endif; ?>
            <input class='backButton' type=submit name=cancel value='Zurück'>
            <? else: ?>
            <input class='button' type=submit name=changePassword value='Passwort ändern'> <br>
            <br>
            <input class='button' type=submit name=changeEmail value='Email ändern'><br>
            <br>
            <? endif; ?>
        </section>
    </form>
</div>