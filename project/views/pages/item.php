<link rel='stylesheet' type='text/css' href='assets/css/item.css'>

<head>
<title><?=isset($title)? 'SnackIt: '. $title : 'SnackIt'?></title>
</head>

<section class='product'>
        <span><img  class='img' src='assets/pictures/products/<?=$product->ProdName;?>.png'></span><br>
            <span class="description">
                <h1><?=$product->ProdName?></h1>
                <br>
                Preis: <?=$product->Price?>€ <br>
                Es sind <?=$product->OnStock?> Stück verfügbar <br>
                <br>
                <label>Bitte wähle die Stückzahl aus</label>
                <form method='post' class='addToCart'>
            <span>Anzahl </span>
            <input type='number' name='count' class='input' value=1 min=1 max=<?=$product->OnStock?> step=1 ><br/>
            <input type='submit' name='addToCart' class='button' value='In den Einkaufswagen' /><br />
        </form>
            </span>

</section>
