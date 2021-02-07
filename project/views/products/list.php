<div class=row>
    <section class='search column'>
        <?  require 'views/viewparts/filter.php';
        ?>
    </section>
    <section class='column middle'>
        <section class=products id=products>
            <h1 class=pagetitle><?=isset($pageTitle) ? $pageTitle : 'Produkte'?></h1>
            <section class=page-navigator id=page-navigator>
                <form method=Get>
                    <? if(isset($getParameters)): ?>
                        <? foreach($getParameters as $key => $value): ?>
                            <input type=hidden name='<?=$key?>' value='<?=$value?>'?>
                        <? endforeach; ?>
                    <? endif; ?>
                </form>
            </section>
            <? foreach($products as $id => $product): ?><!--
             --><article class='product'>
                    <a href='index.php?c=products&a=item&id=<?=$product->ProductId?>'>
                        <div class=img-container>
                            <span class=helper></span><img src='assets/pictures/products/<?=($product->getProperty('mainPicture') !== null) ? $product->getProperty('mainPicture')->value : 'placeholder.png'?>' alt='<?=$product->name?>'><br>
                        </div>
                        <span class='productTitle'><?=$product->name?></span><br>
                        <span class='productPrice'><?=$product->price?> €</span><br>
                    </a>
                </article><!--
         --><? endforeach; ?>
        </section>
    </section>
</div>
