<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<?if ($arResult["NavPageCount"] > 1) :?>
    <ul class="pagination row">
        <?if ($arResult["NavPageNomer"] > 1) :
            $prevUrl = $arResult["sUrlPath"];
            if ($arResult["NavPageNomer"] > 2) {
                $prevUrl .= "?PAGEN_".$arResult["NavNum"]."=".($arResult["NavPageNomer"] - 1);
            }
            ?>
            <li class="page-item disabled col-12 text-center">
                <a class="page-link" href="<?=$prevUrl?>" tabindex="-1" aria-disabled="true">Предыдущая страница</a>
            </li>
        <?endif?>
        <?if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]) :?>
            <li class="page-item col-12 text-center mt-2">
                <a class="page-link" href="<?=$arResult["sUrlPath"]?>?PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"] + 1)?>">Следующая страница</a>
            </li>
        <?endif?>
    </ul>
<?endif?>
