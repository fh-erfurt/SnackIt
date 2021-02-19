<head>
<title><?=isset($title)? 'SnackIt: '. $title : 'SnackIt'?></title>
</head>

</br>
<h1 class=yourshoppingcart>Ihr Einkaufswagen</h1>
<? if(isset($order->products[0])): ?>
</br>
<section class=shoppingtable>
    <section class='products productTable'>
    <div class='tableHeader row'>
        <span class='head col noRightBorder'></span>
        <span class='head col'>Produktname</span>
        <span class='head col'>Einzelpreis</span>
        <span class='head col'>Menge</span>
        <span class='head col noRightBorder'>Gesamtpreis</span>
    </div>
    <div class='tableBody'>
        <? foreach($order->products as $productEntry):
            $product = $productEntry['product'];
            $count = $productEntry['count'];?>
            <article class='product row'>
            <a href='index.php?c=pages&a=item&id=<?=$product->productId?>'>
                <div class='imageContainer col'>
                <img  class='img' src='assets/pictures/products/<?=$product->ProdName;?>.png'>
                </div>
                <span class='productTitle col'><?=$product->ProdName?></span>
                </a> 
                <span class='productPrice col'><?=$product->Price?></span>
                <span class='count col'><?=$count?></span>
                <span class='totalProductPrice col noRightBorder'><?=floatval($product->Price)*intval($count)?></span>
            </article>
        <? endforeach;?>
    </div>
</section>

</section>
</br>
    <section class=summary>
        <form method=post>
            <span class=totalPrice> Gesamtpreis: <?=$totalPrice?> €</span></br>
            <input type=submit name=pay value='Zur Kasse gehen' class='payButton'></br>
        </form>
    </section>
<?elseif( isset($products)):?>
    </br>
<section class=shoppingtable>
    <section class='products productTable'>
    <div class='tableHeader row'>
        <span class='head col noRightBorder'></span>
        <span class='head col'>Produktname</span>
        <span class='head col'>Einzelpreis</span>
        <span class='head col'>Menge</span>
        <span class='head col noRightBorder'>Gesamtpreis</span>
    </div>
    <div class='tableBody'>
        <? foreach($products as $productEntry):
            $product = $productEntry['product'];
            $count = $productEntry['count'];?>
            <article class='product row'>
            <a href='index.php?c=pages&a=item&id=<?=$product->productId?>'>
                <div class='imageContainer col'>
                <img  class='img' src='assets/pictures/products/<?=$product->ProdName;?>.png'>
                </div>
                <span class='productTitle col'><?=$product->ProdName?></span>
                </a>
                <span class='productPrice col'><?=$product->Price?></span>
                <span class='count col'><?=$count?></span>
                <span class='totalProductPrice col noRightBorder'><?=floatval($product->Price)*intval($count)?></span>
            </article>
        <? endforeach;?>
    </div>
</section>

</section>
</br>
    <section class=summary>
        <form method=post>
            <span class=totalPrice> Gesamtpreis: <?=$totalPrice?> €</span></br>
            <input type=submit name=pay value='Zur Kasse gehen' class='payButton'></br>
        </form>
    </section>

<? else:?>
    <h3>Ihr Einkaufswagen ist leer!</h3>
<? endif;?>

