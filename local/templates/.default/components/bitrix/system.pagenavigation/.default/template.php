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
    <ul class="pagination">
        <?while ($arResult["nStartPage"] <= $arResult["nEndPage"]) :?>
            <?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]) :?>
                <li class="page-item active" aria-current="page">
                    <div class="page-link"><?=$arResult["nStartPage"]?></div>
                </li>
            <?else:
                $href = $arResult["sUrlPath"];
                if ($arResult["nStartPage"] > 1) {
                    $href .= "?PAGEN_".$arResult["NavNum"]."=".$arResult["nStartPage"];
                }
                ?>
                <li class="page-item">
                    <a class="page-link" href="<?=$href?>"><?=$arResult["nStartPage"]?></a>
                </li>
            <?endif?>
            <?$arResult["nStartPage"] ++?>
        <?endwhile;?>
    </ul>
<?endif?>
