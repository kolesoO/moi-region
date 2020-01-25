<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?if ($arResult["ITEMS_COUNT"] > 0) :?>
    <div class="row mb-n4">
        <?foreach ($arResult["ITEMS"] as $key => $arItem) :
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
            <div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="col-lg-4 col-md-6 col-12 mb-4">
                <div class="card text-decoration-none text-success shadow">
                    <div
                            class="card-img-top image-block h-custom-250 bg-dark"
                            style="background-image: url('<?=$arItem['PREVIEW_PICTURE']['SRC']?>')"
                    ></div>
                    <div class="card-body">
                        <div class="h5 card-title"><?=$arItem["NAME"]?></div>
                        <div class="text-secondary">
                            <div class="small mb-3"><?=$arItem["PREVIEW_TEXT"]?></div>
                            <p class="text-dark mb-0 text-right">
                                <small><?=$arItem['DISPLAY_ACTIVE_FROM']?></small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        <?endforeach;?>
    </div>
    <?if ($arParams["DISPLAY_BOTTOM_PAGER"]) :?>
        <div class="mt-4"><?=$arResult["NAV_STRING"]?></div>
    <?endif;?>
<?endif?>
