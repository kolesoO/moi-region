<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?if (is_array($arResult)) :?>
    <div class="list-group">
        <?foreach ($arResult as $key => $arItem) :?>
            <a href="<?=$arItem["LINK"]?>" class="list-group-item"><?=$arItem["TEXT"]?></a>
        <?endforeach?>
    </div>
<?endif?>
