<head>
<title><?=isset($title)? 'SnackIt: '. $title : 'SnackIt'?></title>
</head>

<h3>Profil</h3>
    <? if(isset($message)): ?>
        <section class='message <?=$messageType?>'>
            <?=$message?>
        </section>
    <? endif; ?>

<form method=post>
    <? if(isset($changePassword) && $changePassword === true):?>
        <section class=password>
            <h4>Passwort ändern</h4>
            <div class=table>
                <div class=row>
                    <div class=col>Altes Passwort: </div>
                    <div class=col><input type=text name=oldPassword></div>
                </div>
                <div class=row>
                    <div class=col>Neues Passwort: </div>
                    <div class=col><input type=password name=newPassword></div>
                </div>
                <div class=row>
                    <div class=col>Neues Passwort wiederholen: </div>
                    <div class=col><input type=password name=newPassword2></div>
                </div>
            </div>
        </section>
    <? else:?>
        <section class=person>
            <h4>Personendaten</h4>
            <div class=table>
                    <div class=row>
                        <div class=col>Name: </div>
                        <div class=col><?=$Account['FirstName'] . ' ' . $Account['LastName']?></div>
                    </div>
                    <div class=row>
                        <div class=col>E-Mail: </div>
                        <div class=col><?=$Account['Email']?></div>
                    </div>   
            </div>
        </section>
        <section class=address>
            <h4>Adresse</h4>
            <div class=table>
                    <div class=row>
                        <div class=col><?=$Account['Street'] . ' ' . $Account['Number']?></div>
                    </div>
                    <div class=row>
                        <div class=col><?=$Account['Zipcode'] . ' ' . $Account['City']?></div>
                    </div>
                    <div class=row>
                        <div class=col><?=$Account['Country']?></div>
                    </div>
            </div>
        </section>
    <? endif; ?>
    <section class=change>
        <? if(isset($changePassword) && $changePassword === true):?>
            <input type=submit name=confirmPassword value='Passwort aktualisieren'>
            <input type=submit name=cancel value='Zurück'>
        <? else: ?>
            <input type=submit name=changePassword value='Passwort ändern'>
        <? endif; ?>
    </section>
</form>
