<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?if (is_array($arResult)) :?>
    <div class="list-group shadow">
        <?foreach ($arResult as $arItem) :?>
            <?if ($arItem["SELECTED"] == "Y") :?>
                <div class="list-group-item text-decoration-none text-white bg-success"><?=$arItem["TEXT"]?></div>
            <?else:?>
                <a
                        href="<?=$arItem["LINK"]?>"
                        class="list-group-item text-decoration-none text-success bg-hover-success text-hover-white"
                ><?=$arItem["TEXT"]?></a>
            <?endif?>
        <?endforeach;?>
    </div>
<?endif?>
