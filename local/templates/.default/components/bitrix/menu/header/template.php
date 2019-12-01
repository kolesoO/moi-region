<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$count = count($arResult);
?>

<?if (is_array($arResult)) :?>
    <nav class="nav justify-content-end">
        <?foreach ($arResult as $key => $arItem) :
            $class = "text-white text-decoration-none ";
            $class .= $arItem["SELECTED"] == "Y" ? "active" : "hover";
            ?>
            <?if ($key == 0) :?>
                <a class="mr-2 <?=$class?>" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
            <?elseif ($key == $count - 1) :?>
                <a class="ml-2 <?=$class?>" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
            <?else :?>
                <a class="mr-2 ml-2 <?=$class?>" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
            <?endif?>
        <?endforeach;?>
    </nav>
<?endif?>
