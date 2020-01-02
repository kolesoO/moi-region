<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?if ($arResult['ITEMS_COUNT'] > 0) :?>
    <div id="accordion" class="row d-lg-flex d-md-flex d-none">
        <div class="col-lg-4 col-md-4">
            <div class="list-group">
                <?foreach ($arResult["ITEMS"] as $arItem) :?>
                    <a
                            href="#group-<?=$arItem['ID']?>"
                            class="list-group-item text-decoration-none text-success bg-hover-success text-hover-white"
                            data-toggle="collapse"
                            role="button"
                            aria-expanded="false"
                            aria-controls="collapseExample"
                    >
                        <?if (isset($arItem["PROPERTIES"]["ICON_CODE"]) && strlen($arItem["PROPERTIES"]["ICON_CODE"]["VALUE"]) > 0) :?>
                            <?=htmlspecialcharsback($arItem["PROPERTIES"]["ICON_CODE"]["VALUE"])?>
                        <?endif?>
                        <span><?=$arItem['NAME']?></span>
                    </a>
                <?endforeach;?>
            </div>
        </div>
        <div class="col-lg-8 col-md-8">
            <?foreach ($arResult["ITEMS"] as $key => $arItem) :
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <div id="group-<?=$arItem['ID']?>" data-parent="#accordion" class="collapse<?if ($key == 0) :?> show<?endif?>">
                    <div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="card card-body shadow"><?=$arItem['PREVIEW_TEXT']?></div>
                </div>
            <?endforeach;?>
        </div>
    </div>
<?endif?>
