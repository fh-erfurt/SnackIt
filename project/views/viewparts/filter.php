<? ?>

<form method=get>
    <? if(isset($_GET['c'])): ?>
        <input type=hidden name='c' value='<?=$_GET['c']?>'?>
    <? endif; ?>
    <? if(isset($_GET['a'])): ?>
        <input type=hidden name='a' value='<?=$_GET['a']?>'?>
    <? endif; ?>
    <? if(isset($_GET['t'])): ?>
        <input type=hidden name='t' value='<?=$_GET['t']?>'?>
    <? endif; ?>
    <!--search by name-->
    <label>
        Nach Namen Suchen:
        <input class=searchbyname type=search name='name' value='<?=isset($_GET['name']) ? $_GET['name'] : '';?>' placeholder='Suche...'>
    </label></br></br>
    <!--price-->
    <span>Preis:</span></br>
    <label>
        Min: <input class=searchbymin type=number name='minPrice' min='<?=isset($minPrice)? $minPrice : 0?>' <?=isset($maxPrice) ? "max='$maxPrice'" : '' ?> value='<?=isset($_GET['minPrice']) ? $_GET['minPrice'] : (isset($minPrice)? $minPrice : '')?>' placeholder='Minimum' step=any>
    </label></br>
    <label>
        Max: <input class=searchbymax type=number name='maxPrice' min='<?=isset($minPrice)? $minPrice : 0?>' <?=isset($maxPrice) ? "max='$maxPrice'" : '' ?> value='<?=isset($_GET['maxPrice']) ? $_GET['maxPrice'] : (isset($maxPrice)? $maxPrice : '')?>' placeholder='Maximum' step=any>
    </label></br></br>
    <!--onStock-->
    <label>
        <input type=checkbox name='onStock' <?=isset($_GET['onStock']) ? 'checked': ''?> > nur verfügbare Produkte anzeigen
    </label></br></br>
    <!--Custom Filter-->
    <? if(isset($filter)): ?>
        <? foreach($filter as $filterName => $filterProperties): ?>
            <div>
                <? if($filterName =='productType'): ?>
                    <label>
                        Produktkategorie*: 
                        <select name='productType[]' multiple>
                            <? foreach($filterProperties as $type => $name): ?>
                                <option value='<?=$type?>' <?=isset($_GET['productType']) && in_array($type, $_GET['productType']) ? 'selected' : ''?>><?=$name?></option>
                            <? endforeach; ?>
                        </select>
                    </label>
                <? else: ?>
                    <? if($filterProperties['filterType']=='checkbox'): ?>
                        <label>
                            <?=$filterProperties['name']?>: </br>
                            <? foreach($filterProperties['items'] as $id => $name): ?>
                                    <input type=checkbox name='<?=$filterProperties['type']?>[]' value='<?=$id?>' <?=isset($_GET[$filterProperties['type']]) && in_array($id, $_GET[$filterProperties['type']]) ? 'checked' : ''?>> <?=$name?>
                            <? endforeach; ?>
                        </label></br></br>
                    <? elseif($filterProperties['filterType']=='list'): ?>
                        <label>
                            <?=$filterProperties['name']?>*: </br>
                            <select name='<?=$filterProperties['type']?>[]' multiple>
                                <? foreach($filterProperties['items'] as $id => $name): ?>
                                    <option value='<?=$id?>' <?=isset($_GET[$filterProperties['type']]) && in_array($id, $_GET[$filterProperties['type']]) ? 'selected' : ''?>><?=$name?></option>
                                <? endforeach; ?>
                            </select>
                        </label></br></br>
                    <? endif; ?>
                <? endif; ?>
            </div>
        <? endforeach; ?>
    <? endif; ?>
    <input type=submit name='applyFilter' value='OK'>
</form><br>
<span class=note>
    * Mehrfachauswahl möglich
</span>