<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>

<div class="alert alert-secondary mb-0">
    <?if (isset($arResult['CLOSEST_DELIVERY'])) :?>
        <span>Ближайшая доставка: <br><span class="h5"><?=$arResult['CLOSEST_DELIVERY']['DATE']?><br> <?=$arResult['CLOSEST_DELIVERY']['TIME']?></span></span>
    <?else:?>
        <span>Доставка временно приостановлена</span>
    <?endif?>
</div>

