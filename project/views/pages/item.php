<head>
<title><?=isset($title)? 'SnackIt: '. $title : 'SnackIt'?></title>
</head>
<section class='product'>
    <div>
        <span><img  class='img' src='assets/pictures/products/<?=$product->ProdName;?>.png'></span><br>
    </div>
    <article class=product>
            <div>    
            <h1><?=$product->ProdName?></h1>
            </div>
            <div>
                <span>Preis: <?=$product->Price?> </span>
                
            </div>
</section>
