<section class='productView'>
    <div class='images'>
        <? foreach($images as $image): ?>
            <img src='assets/pictures/products/<?=$image?>' alt='<?=$product->name?>'>
        <? endforeach; ?>
    </div>
    <article class=product>
        <div class='productDescription'>    
            <h1><?=$product->name?></h1>
            <div class='price row'>
                <span class='col'>Preis:</span>
                <span class='col'><?=$product->price?> €</span>
            </div>
            
            <div class='onStock row'>
                <span class='col'>Verfügbarkeit:</span>
                <? if(isset($onStockState)):?>
                    <? if($onStockState == 'available'):?>
                        <span class='available col'>auf Lager</span>
                    <? elseif ($onStockState == 'lowOnStock'):?>
                        <span class='lowOnStock col'>nur noch <?=$product->onStock?> auf Lager</span>
                    <? else:?>
                        <span class='outOfStock col'>derzeit nicht auf Lager</span>
                    <? endif; ?>
                <? endif; ?>
            </div>
        </div>
        <div class='productProperties'>
            <h3>Artikelinformationen</h3> 
            <? foreach($properties as $name => $value): ?>
                <div class='row property'>
                    <span class='col propertyName'><?=$name?></span>
                    <span class='col propertyValue'><?=$value?></span>
                </div>
            <? endforeach; ?>
        </div>
    
        <form method='post' class='addToCart'>
            <span>Anzahl </span>
            <input type=number name=count class='input' value=1 min=1 step=1><br/>
            <input type='submit' name='addToCart' class='button' value='In den Einkaufskorb' /><br />
        </form>
    </article>
</section>
