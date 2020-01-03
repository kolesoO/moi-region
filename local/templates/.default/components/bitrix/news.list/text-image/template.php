<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?foreach ($arResult["ITEMS"] as $key => $arItem) :
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>
    <div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="card-body bg-white border mb-3">
        <div class="h3 mb-4"><?=$arItem["NAME"]?></div>
        <div class="row">
            <?if (is_array($arItem["PREVIEW_PICTURE"])) :?>
                <div class="col-lg-8"><?=htmlspecialcharsback($arItem['PREVIEW_TEXT'])?></div>
                <div class="col-lg-4">
                    <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="">
                </div>
            <?else:?>
                <div class="col-12"><?=htmlspecialcharsback($arItem['PREVIEW_TEXT'])?></div>
            <?endif?>
        </div>
    </div>
<?endforeach;?>
