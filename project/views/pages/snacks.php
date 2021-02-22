<link rel='stylesheet' type='text/css' href='assets/css/snacks.css'>

<head>
    <title><?= isset($title) ? 'SnackIt: ' . $title : 'SnackIt' ?></title>
</head>

<section class='searchColumn'>
    <? include(__DIR__ . '/../viewparts/filter.php');?>
</section>

<form method='get'>
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
    </div>

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
    </div>

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
    </div>

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
    </div>
</form>