<link rel='stylesheet' type='text/css' href='assets/css/item.css'>

<head>
    <title><?= isset($title) ? 'SnackIt: ' . $title : 'SnackIt' ?></title>
</head>

<section class='product'>
    <span><img class='img' src='assets/pictures/products/<?= $product->ProdName; ?>.png'></span><br>
    <span class="description">
        <h1><?= $product->ProdName ?></h1>
        <br>
        Preis: <?= $product->Price ?>€ <br>
        Es sind <?= $product->OnStock ?> Stück verfügbar <br>
        <br>
        <label>Bitte wähle die Stückzahl aus</label>
        <form method='post'>
            <br>
            <div class="number-input">
                <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">-</button>
                <input min="0" max=<?= $product->OnStock ?> name="count" value="1" type="number">
                <button type="button" content onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus">+</button>
            </div>
            <br>
            <br>
            <input type='submit' name='addToCart' class='add' value='In den Einkaufswagen' /><br />
        </form>
        <br>

        <noscript>sry buttons only function if javascript is enabled</noscript>
    </span>

</section>