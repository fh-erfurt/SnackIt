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
                <div class='imageContainer col'>
                    <img src='assets/pictures/products/<?=($product->getProperty('mainPicture') !== null) ? $product->getProperty('mainPicture')->value : 'placeholder.png'?>' alt='<?=$product->name?>'>
                </div>
                <a class='productTitle col' href='index.php?c=products&a=item&id=<?=$product->productId?>'><?=$product->name?></a>
                <span class='productPrice col'><?=$product->price?></span>
                <span class='count col'><?=$count?></span>
                <span class='totalProductPrice col noRightBorder'><?=floatval($product->price)*intval($count)?></span>
            </article>
        <? endforeach;?>
    </div>
</section>