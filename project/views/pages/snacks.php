<link rel='stylesheet' type='text/css' href='assets/css/snacks.css'>

<head>
    <title><?= isset($title) ? 'SnackIt: ' . $title : 'SnackIt' ?></title>
</head>

<section class='filter'>
    <? include(__DIR__ . '/../viewparts/filter.php');?>
    <!--search by proptype-->

    <form class="taste-wrap" method='post'>
        <label>Nach Geschmacksrichtung suchen:</label><br>
        <input class="taste" type='submit' name='all' class='add' value='Alles' /><br />

        <input class="taste" type='submit' name='salty' class='add' value='Herzhaft' /><br />

        <input class="taste" type='submit' name='sweet' class='add' value='Süß' /><br />
    </form>
</section>

<br>


<div class="products">
    <?foreach($products as $id => $product): ?>
    <article class='product'>
        <a href='index.php?c=pages&a=item&id=<?= $product->productId ?>'>
            <div>
                <span><img class='img' src='assets/pictures/products/<?= $product->ProdName; ?>.png'></span><br>
            </div>
            <span><?= $product->ProdName ?></span><br>
            <span class='prodPrice'><?= $product->Price ?>€</span>
        </a>
    </article>
    <? endforeach; ?>

    <?//redundant loop just to show more products
    
    foreach($products as $id => $product): ?>
    <article class='product'>
        <a href='index.php?c=pages&a=item&id=<?= $product->productId ?>'>
            <div>
                <span><img class='img' src='assets/pictures/products/<?= $product->ProdName; ?>.png'></span><br>
            </div>
            <span><?= $product->ProdName ?></span><br>
            <span class='prodPrice'><?= $product->Price ?>€</span>
        </a>
    </article>
    <? endforeach; ?>
    <?foreach($products as $id => $product): ?>
    <article class='product'>
        <a href='index.php?c=pages&a=item&id=<?= $product->productId ?>'>
            <div>
                <span><img class='img' src='assets/pictures/products/<?= $product->ProdName; ?>.png'></span><br>
            </div>
            <span><?= $product->ProdName ?></span><br>
            <span class='prodPrice'><?= $product->Price ?>€</span>
        </a>
    </article>
    <? endforeach; ?>
    <?foreach($products as $id => $product): ?>
    <article class='product'>
        <a href='index.php?c=pages&a=item&id=<?= $product->productId ?>'>
            <div>
                <span><img class='img' src='assets/pictures/products/<?= $product->ProdName; ?>.png'></span><br>
            </div>
            <span><?= $product->ProdName ?></span><br>
            <span class='prodPrice'><?= $product->Price ?>€</span>
        </a>
    </article>
    <? endforeach; ?>
    <?foreach($products as $id => $product): ?>
    <article class='product'>
        <a href='index.php?c=pages&a=item&id=<?= $product->productId ?>'>
            <div>
                <span><img class='img' src='assets/pictures/products/<?= $product->ProdName; ?>.png'></span><br>
            </div>
            <span><?= $product->ProdName ?></span><br>
            <span class='prodPrice'><?= $product->Price ?>€</span>
        </a>
    </article>
    <? endforeach; ?>
    <?foreach($products as $id => $product): ?>
    <article class='product'>
        <a href='index.php?c=pages&a=item&id=<?= $product->productId ?>'>
            <div>
                <span><img class='img' src='assets/pictures/products/<?= $product->ProdName; ?>.png'></span><br>
            </div>
            <span><?= $product->ProdName ?></span><br>
            <span class='prodPrice'><?= $product->Price ?>€</span>
        </a>
    </article>
    <? endforeach; ?>

</div>