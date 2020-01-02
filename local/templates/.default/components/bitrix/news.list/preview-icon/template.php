<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?foreach ($arResult["ITEMS"] as $key => $arItem) :
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    $textClass = '';
    if ($key < $arResult["ITEMS_COUNT"] - 1) {
        $textClass = ' mb-5';
    }
    ?>
    <div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="d-flex align-items-center<?=$textClass?>">
        <?if (isset($arItem["PROPERTIES"]["ICON_CODE"]) && strlen($arItem["PROPERTIES"]["ICON_CODE"]["VALUE"]) > 0) :?>
            <div class="h1 mb-0 mr-3 col-2 pl-0 pr-0"><?=htmlspecialcharsback($arItem["PROPERTIES"]["ICON_CODE"]["VALUE"])?></div>
        <?elseif (is_array($arItem['PREVIEW_PICTURE'])) :?>
            <div class="h1 mb-0 mr-3 col-2 pl-0 pr-0">
                <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="">
            </div>
        <?endif?>
        <div>
            <div class="h5"><?=$arItem["NAME"]?></div>
            <span><?=$arItem["PREVIEW_TEXT"]?></span>
        </div>
    </div>
<?endforeach;?>
