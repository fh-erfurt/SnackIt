<h1>Snacks</h1>
<head>
<title><?=isset($title)? 'SnackIt: '. $title : 'SnackIt'?></title>
</head>

<?

foreach($products as $id => $product): ?>
             <article class='product'>
             <a href='index.php?c=pages&a=snacks&id=<?=$product->ProductID?>'>
                        <div class=img-container>
                            <span class=helper><img src='assets/pictures/products/<?=$product->ProdName;?>.jpg'width="150" height="150"></span><br>
                        </div>
             
                        <span class='ProdName'><?=$product->ProdName?></span><br>
                        <span class='productPrice'><?=$product->Price?> €</span><br><br><br>
                    </a>
                </article>
         <? endforeach; ?>