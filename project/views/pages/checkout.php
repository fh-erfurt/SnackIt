<link rel='stylesheet' type='text/css' href='assets/css/checkout.css'>

<head>
<title><?=isset($title)? 'SnackIt: '. $title : 'SnackIt'?></title>
</head>

</br>

<div class=checkout>
    <? if(isset($error)): ?>
        <p class='errorMessage'><?=$error?></p>
    <? endif;?>
    <form method=Post>
        <section class=delivery>
            <h3>1. Versandadresse</h3>
            <? if(!isset($_POST['changeDeliveryAddress'])): ?>
                <div class=address>
                    <span class=name><?=$firstname . ' ' . $lastname?></span></br>
                    <span class=street><?=$street . ' ' . $number?></span></br>
                    <span class=city><?=$city . ', ' . $state . ' (' . $country . ') ' . $zipcode?></span></br>
                    <input class=addressbutton type=submit name=changeDeliveryAddress value='Andere Lieferadresse'>
                </div>
                <input type=hidden name=firstname value='<?=$firstname?>'>
                <input type=hidden name=lastname value='<?=$lastname?>'>
                <input type=hidden name=country value='<?=$country?>'>
                <input type=hidden name=state value='<?=$state?>'>
                <input type=hidden name=city value='<?=$city?>'>
                <input type=hidden name=zipcode value='<?=$zipcode?>'>
                <input type=hidden name=street value='<?=$street?>'>
                <input type=hidden name=number value='<?=$number?>'>
            <? else: ?>
                <div class=address>
                    <label>
                    Vorname: <input type=text name=firstname value='<?=isset($firstname) ? $firstname : ''?>'>
                    </label></br>
                    <label>
                    Nachname: <input type=text name=lastname value='<?=isset($lastname) ? $lastname : ''?>'>
                    </label></br>
                    <label>
                    Land: <input type=text name=country value='<?=isset($country) ? $country : ''?>'>
                    </label></br>
                    <label>
                    Bundesland: <input type=text name=state value='<?=isset($state) ? $state : ''?>'>
                    </label></br>
                    <label>
                    Stadt: <input type=text name=city value='<?=isset($city) ? $city : ''?>'>
                    </label></br>
                    <label>
                    Postleitzahl: <input type=text name=zipcode value='<?=isset($zipcode) ? $zipcode : ''?>'>
                    </label></br>
                    <label>
                    Straße: <input type=text name=street value='<?=isset($street) ? $street : ''?>'>
                    </label></br>
                    <label>
                    Hausnummer: <input type=text name=number value='<?=isset($number) ? $number : ''?>'>
                    </label></br>
                    <input class=addressbutton type=submit name=saveAddressTemp value='Nur für diese Bestellung ändern'>
                    <input class=addressbutton type=submit name=saveAddressPerm value='Als neue Lieferadresse speichern'>
                    <input class=addressbutton type=submit name=cancelChangeAddress value='Abbrechen'>
                </div>
            <? endif; ?>
        </section>
        
        </br>

        <section class=paymentMethod>
            <h3>2. Bezahlmethode</h3>
            <input type=hidden name=payment value='<?= isset($payment) ? $payment : 'creditcard' ?>'>
            <button class=paymentbutton type=submit name=changePayment value=creditcard> Kreditkarte</button>
            <button class=paymentbutton type=submit name=changePayment value=paypal> PayPal</button><br>
            <span>Ausgewählte Bezahlmethode: <?= isset($payment) ? ($payment == 'creditcard' ? 'Kreditkarte' : 'PayPal') : 'Kreditkarte' ?></span><br>
            <? if(!isset($payment) || $payment == 'creditcard'): ?>
                <label>
                    Kreditkartennummer: 
                    <input type=text name=creditcardNumber value='<?=isset($creditcardNumber) ? $creditcardNumber : ''?>'></br>
                </label>
                <label>
                    Ablaufdatum: 
                    <input class=expireMonth type=number name=creditcardMonth placeholder='MM' min=1 max=12 value='<?=isset($creditcardMonth) ? $creditcardMonth : ''?>'> / 
                    <input class=expireYear type=number name=creditcardYear placeholder='YY' value='<?=isset($creditcardYear) ? $creditcardYear : ''?>'></br>
                </label>
                <label>
                    Sicherheitszahl: 
                    <input class=secretNumber type=text name=creditcardSecureNumber value='<?=isset($creditcardSecureNumber) ? $creditcardSecureNumber : ''?>'></br>
                </label>
            <? endif; ?>
        </section>
        </br>
        </br>
        <section class=products>
            <h3>3. Produkt(e) überprüfen</h3>
            </br>
            <? include(__DIR__ . '/../viewparts/productTable.php');?>
        </section>
        <section class=pay>
            <input class=paymentbutton type=submit name=pay value='Jetzt kaufen'>
            <span> Gesamtbetrag: <?=$totalPrice?> €</span></br>
        </section>
    </form>
</div>