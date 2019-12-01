<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$count = count($arResult);
?>

<?if (is_array($arResult)) :?>
    <?foreach ($arResult as $key => $arItem) :
        $class = "text-white text-decoration-none ";
        $class .= $arItem["SELECTED"] == "Y" ? "active" : "hover";
        ?>
        <?if ($key == 0) :?>
            <div class="mb-2">
                <a href="<?=$arItem["LINK"]?>" class="<?=$class?>"><?=$arItem["TEXT"]?></a>
            </div>
        <?elseif ($key == $count - 1) :?>
            <div>
                <a href="<?=$arItem["LINK"]?>" class="<?=$class?>"><?=$arItem["TEXT"]?></a>
            </div>
        <?else :?>
            <div class="mb-2">
                <a href="<?=$arItem["LINK"]?>" class="<?=$class?>"><?=$arItem["TEXT"]?></a>
            </div>
        <?endif?>
    <?endforeach;?>
<?endif?>
