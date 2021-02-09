<head>
<title><?=isset($title)? 'SnackIt: '. $title : 'SnackIt'?></title>
</head>

</br>
<h1 class=yourshoppingcart>Ihr Einkaufswagen</h1>
</br>
<section class=shoppingtable>
<? if(isset($products)): ?>
    <? include(__DIR__ . '/../viewparts/productTable.php');?>
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
