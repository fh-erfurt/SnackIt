<link rel='stylesheet' type='text/css' href='assets/css/snacks.css'>

<head>
    <title><?= isset($title) ? 'SnackIt: ' . $title : 'SnackIt' ?></title>
</head>

<section class='filter'>
    <? include(__DIR__ . '/../viewparts/filter.php');?>
</section>
<!--search by proptype-->
<label>Nach Geschmacksrichtung suchen:</label>
<br>
<form method='post'>
    <input type='submit' name='all' class='add' value='Alles' /><br />
</form>
<form method='post'>
    <input type='submit' name='salty' class='add' value='Herzhaft' /><br />
</form>
<form method='post'>
    <input type='submit' name='sweet' class='add' value='Süß' /><br />
</form>

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