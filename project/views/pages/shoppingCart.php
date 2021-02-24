<link rel="stylesheet" href="assets/css/shoppingCart.css">


<head>
    <title><?= isset($title) ? 'SnackIt: ' . $title : 'SnackIt' ?></title>
</head>

<br>
</br>
<h1>Ihr Einkaufswagen</h1><br>
<br>
<br>

<? if(isset($order->products[0])): ?>
</br>
<section class=shoppingtable>
    <section class='productTable'>
        <div class='tableHeader row'>
            <span class='col'></span>
            <span class='col'></span>
            <span class='col'>Produktname</span>
            <span class='col'>Einzelpreis</span>
            <span class='col'>Menge</span>
            <span class='col'>Gesamtpreis</span>
            <span class='col'>Entfernen</span>
        </div>
        <div class='tableBody'>
            <? foreach($order->products as $productEntry):
            $product = $productEntry['product'];
            $count = $productEntry['count'];?>
            <article class='row'>
                <a href='index.php?c=pages&a=item&id=<?= $product->productId ?>'>
                    <div class='imageContainer col'><img class='img' src='assets/pictures/products/<?= $product->ProdName; ?>.png'>
                </a>
        </div>
        <span class='col'><a href='index.php?c=pages&a=item&id=<?= $product->productId ?>'><?= $product->ProdName ?></a></span>
        <span class='col'><?= $product->Price ?>€</span>
        <span class='col'>
            <div class="number-input col">
                <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">-</button>
                <input class="col" min="0" max=<?= $product->OnStock ?> name="count" value="<?= $count ?>" type="number">
                <button type="button" content onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus">+</button>
            </div>
        </span>
        <span class='col'><?= number_format(floatval($product->Price) * intval($count), 2) ?>€</span>
        <form method='post'>
            <input type='submit' name='delete' class='delete' value='x' />
			<input type="hidden" name="productId" value= <?=$product->productId?> >
        </form>
        </article>
        <? endforeach;?>
        </div>
    </section>
</section>
<?elseif( isset($products)):?>
</br>
<section class=shoppingtable>
    <section class='productTable'>
        <div class='tableHeader row'>
            <span class='col'></span>
            <span class='col'></span>
            <span class='col'>Produktname</span>
            <span class='col'>Einzelpreis</span>
            <span class='col'>Menge</span>
            <span class='col'>Gesamtpreis</span>
            <span class='col'>Entfernen</span>
        </div>
        <div class='tableBody'>
            <? foreach($products as $productEntry):
            $product = $productEntry['product'];
            $count = $productEntry['count'];?>
            <article class='row'>
                <a href='index.php?c=pages&a=item&id=<?= $product->productId ?>'>
                    <div class='imageContainer col'><img class='img' src='assets/pictures/products/<?= $product->ProdName; ?>.png'>
                </a>
        </div>
        <span class='col'><a href='index.php?c=pages&a=item&id=<?= $product->productId ?>'><?= $product->ProdName ?></a></span>
        <span class='col'><?= $product->Price ?>€</span>
        <span class='col'>
            <div class="number-input col">
                <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">-</button>
                <input class="col" min="0" max=<?= $product->OnStock ?> name="count" value="<?= $count ?>" type="number">
                <button type="button" content onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus">+</button>
            </div>
        </span>
        <span class='col'><?= number_format(floatval($product->Price) * intval($count), 2) ?>€</span>
        <span class='col'><button class="delete" type="button">x</button></span>
        </article>
        <br>
        <br>
        <? endforeach;?>
        </div>
    </section>

    <? else:?>
    <div class="empty">Ihr Einkaufswagen ist leer!</div>
    <? endif;?>

    <? if(isset($order->products[0]) ||  isset($products)): ?>

</section>
</br>
<section class=summary>
    <form method=post>
        <span class=totalPrice> Gesamtpreis: <?= $totalPrice ?>€</span></br>
        <br>
        <input type=submit name=pay value='Zur Kasse gehen' class='payButton'><a href='index.php?c=pages&a=Checkout'></a></br>
    </form>
</section>

<?endif?>