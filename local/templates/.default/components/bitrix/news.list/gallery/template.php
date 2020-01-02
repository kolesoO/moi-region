<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?if ($arResult["ITEMS_COUNT"] > 0) :?>
    <div class="gallery-block compact-gallery js-compact-gallery">
        <div class="row no-gutters">
            <?foreach ($arResult["ITEMS"] as $key => $arItem) :
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="col-md-6 col-lg-4 item zoom-on-hover">
                    <a class="lightbox" href="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>">
                        <img class="img-fluid image" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="">
                        <span class="description">
                            <span class="description-heading"><?=$arItem["NAME"]?></span>
                            <span class="description-body"><?=$arItem["PREVIEW_TEXT"]?></span>
                        </span>
                    </a>
                </div>
            <?endforeach;?>
        </div>
    </div>
<?endif?>
