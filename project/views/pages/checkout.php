<link rel='stylesheet' type='text/css' href='assets/css/checkout.css'>

<head>
    <title><?= isset($title) ? 'SnackIt: ' . $title : 'SnackIt' ?></title>
</head>

</br>
<div class=checkout>
    <form method=Post>
        <section class=delivery>
            <br>
            <h3>1. Versandadresse</h3><br>
            <? if(!isset($_POST['changeDeliveryAddress'])): ?>
            <div class=address>
                <label class=name><?= $account["FirstName"] . ' ' . $account["LastName"] ?></label></br>
                <label class=street><?= $account["Street"] . ' ' . $account["Number"] ?></label></br>
                <label class=city><?= $account["City"] . ', ' . $account["Country"] . ',' . $account["Zipcode"] ?></label></br>
                <br>
                <input class="button" type=submit name=changeDeliveryAddress value='Andere Lieferadresse'>
            </div>
            <input type=hidden name=firstname value='<?= $firstname ?>'>
            <input type=hidden name=lastname value='<?= $lastname ?>'>
            <input type=hidden name=country value='<?= $country ?>'>
            <input type=hidden name=state value='<?= $state ?>'>
            <input type=hidden name=city value='<?= $city ?>'>
            <input type=hidden name=zipcode value='<?= $zipcode ?>'>
            <input type=hidden name=street value='<?= $street ?>'>
            <input type=hidden name=number value='<?= $number ?>'>
            <? else: ?>
            <div class=address>
                <label>Vorname: </label></br>
                <input type=text name=firstname value='<?= isset($firstname) ? $firstname : '' ?>'><br><br>

                <label>Nachname: </label></br>
                <input type=text name=lastname value='<?= isset($lastname) ? $lastname : '' ?>'><br><br>

                <label>Land: </label></br>
                <input type=text name=country value='<?= isset($country) ? $country : '' ?>'><br><br>

                <label>Bundesland: </label>
                </br> <input type=text name=state value='<?= isset($state) ? $state : '' ?>'><br><br>

                <label>Stadt: </label></br>
                <input type=text name=city value='<?= isset($city) ? $city : '' ?>'><br><br>

                <label>Postleitzahl: </label>
                </br> <input type=text name=zipcode value='<?= isset($zipcode) ? $zipcode : '' ?>'><br><br>

                <label>Straße: </label></br>
                <input type=text name=street value='<?= isset($street) ? $street : '' ?>'><br><br>

                <label>Hausnummer: </label></br>
                <input type=text name=number value='<?= isset($number) ? $number : '' ?>'><br><br>

                <input class="button" type=submit name=saveAddressTemp value='Nur für diese Bestellung ändern'><br>
                <br>
                <input class="button" type=submit name=saveAddressPerm value='Als neue Lieferadresse speichern'><br>
                <br>
                <input class="button" type=submit name=cancelChangeAddress value='Abbrechen'><br>
                <br>
            </div>
            <? endif; ?>
        </section>

        </br>

        <section class=paymentMethod>
            <h3>2. Bezahlmethode</h3><br>
            <input type=hidden name=payment value='<?= isset($payment) ? $payment : 'creditcard' ?>'>
            <button class="button" type=submit name=changePayment value=creditcard> Kreditkarte</button>
            <button class="button" type=submit name=changePayment value=paypal> PayPal</button><br>
            <br>
            <span>Ausgewählte Bezahlmethode: <?= isset($payment) ? ($payment == 'creditcard' ? 'Kreditkarte' : 'PayPal') : 'Kreditkarte' ?></span><br>
            <? if(!isset($payment) || $payment == 'creditcard'): ?><br>
            <label>
                Kreditkartennummer:
                <input type=text name=creditcardNumber value='<?= isset($creditcardNumber) ? $creditcardNumber : '' ?>'></br>
            </label><br>
            <label>
                Ablaufdatum:
                <input class=expireMonth type=number name=creditcardMonth placeholder='MM' min=1 max=12 value='<?= isset($creditcardMonth) ? $creditcardMonth : '' ?>'><br>
                <br>
                <input class=expireYear type=number name=creditcardYear placeholder='YY' value='<?= isset($creditcardYear) ? $creditcardYear : '' ?>'></br>
            </label>
            <br>
            <label>
                Sicherheitszahl:
                <input class=secretNumber type=text name=creditcardSecureNumber value='<?= isset($creditcardSecureNumber) ? $creditcardSecureNumber : '' ?>'></br>
            </label>
            <br>
            <? endif; ?>
        </section>
        <section class=pay>
            <input class="button" type=submit name=pay value='Jetzt kaufen'><br>
            <br>
        </section>
    </form>
</div>