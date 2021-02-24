<link rel='stylesheet' type='text/css' href='assets/css/snacks.css'>

<head>
    <title><?= isset($title) ? 'SnackIt: ' . $title : 'SnackIt sweet' ?></title>
</head>

<section class='filter'>
    <? include(__DIR__ . '/../viewparts/filter.php');?>
</section>

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