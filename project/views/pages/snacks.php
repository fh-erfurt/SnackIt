<h1>Snacks</h1>
<head>
<title><?=isset($title)? 'SnackIt: '. $title : 'SnackIt'?></title>
</head>

<? foreach($products as $name => $product): ?>
             <article class='product'>
             <a href='index.php?c=pages&a=snacks&id=<?=$product->productId?>'>
                        <span class='productTitle'><?=$product->name?></span><br>
                        <span class='productPrice'><?=$product->price?> €</span><br>
                    </a>
                </article><!--
         --><? endforeach; ?>