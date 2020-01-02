<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?foreach ($arResult["ITEMS"] as $key => $arItem) :
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    $textClass = $key < $arResult["ITEMS_COUNT"] - 1 ? 'mb-5' : 'mb-0';
    ?>
    <div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="h3"><?=$arItem["NAME"]?></div>
    <p class="<?=$textClass?>"><?=$arItem["PREVIEW_TEXT"]?></p>
<?endforeach;?>
