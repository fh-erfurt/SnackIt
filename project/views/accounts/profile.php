<h3>Profil</h3>
    <? if(isset($message)): ?>
        <section class='message <?=$messageType?>'>
            <?=$message?>
        </section>
    <? endif; ?>
<form method=post>
    <? if(isset($changePassword) && $changePassword === true):?>
        <section class=password>
            <h4>Passwortänderung</h4>
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
                <? if(isset($changeData) && $changeData === true):?>
                    <div class=row>
                        <div class=col>Vorname: </div>
                        <div class=col><input type=text name=firstname value='<?=$user->firstname?>'></div>
                    </div>
                    <div class=row>
                        <div class=col>Nachname: </div>
                        <div class=col><input type=text name=lastname value='<?=$user->lastname?>'></div>
                    </div>
                    <div class=row>
                        <div class=col>E-Mail: </div>
                        <div class=col><input type=email name=email value='<?=$user->email?>'></div>
                    </div>
                <? else: ?>
                    <div class=row>
                        <div class=col>Name: </div>
                        <div class=col><?=$user->firstname . ' ' . $user->lastname?></div>
                    </div>
                    <div class=row>
                        <div class=col>E-Mail: </div>
                        <div class=col><?=$user->email?></div>
                    </div>
                <? endif; ?>
            </div>
        </section>
        <section class=address>
            <h4>Adresse</h4>
            <div class=table>
                <? if(isset($changeData) && $changeData === true):?>
                    <div class=row>
                        <div class=col><input type=text name=street placeholder=Straße value='<?=$address->street?>'></div>
                        <div class=col><input type=text name=number placeholder=Hausnummer value='<?=$address->number?>'></div>
                    </div>
                    <div class=row>
                        <div class=col><input type=text name=zipcode placeholder=Postleitzahl value='<?=$address->zipcode?>'></div>
                        <div class=col><input type=text name=city placeholder=Stadt value='<?=$address->city?>'></div>
                    </div>
                    <div class=row>
                        <div class=col><input type=text name=state placeholder=Bundesland value='<?=$address->state?>'></div>
                        <div class=col><input type=text name=country placeholder=Land value='<?=$address->country?>'></div>
                    </div>
                <? else: ?>
                    <div class=row>
                        <div class=col><?=$address->street . ' ' . $address->number?></div>
                    </div>
                    <div class=row>
                        <div class=col><?=$address->zipcode . ' ' . $address->city?></div>
                    </div>
                    <div class=row>
                        <div class=col><?=$address->state . ', ' . $address->country?></div>
                    </div>
                <? endif; ?>
            </div>
        </section>
    <? endif; ?>
    <section class=change>
        <? if(isset($changePassword) && $changePassword === true):?>
            <input type=submit name=confirmPassword value='Passwort aktualisieren'>
            <input type=submit name=cancel value='Zurück'>
        <? elseif(isset($changeData) && $changeData === true):?>
            <input type=submit name=confirmChange value='Änderungen speichern'>
            <input type=submit name=cancel value='Zurück'>
        <? else: ?>
            <input type=submit name=changeData value='Daten ändern'>
            <input type=submit name=changePassword value='Passwort ändern'>
        <? endif; ?>
    </section>
</form>
