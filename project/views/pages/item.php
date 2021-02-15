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
                <select name="amount" id="amount"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select>
                <br>
                <br>
                <br>
                <br>
                <input type="submit" class="add" value="+ in den Warenkorb">
            </span>

</section>
