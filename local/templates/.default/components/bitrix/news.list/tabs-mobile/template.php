<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?if ($arResult['ITEMS_COUNT'] > 0) :?>
    <div id="accordion-mobile" class="accordion d-lg-none d-md-none">
        <?foreach ($arResult["ITEMS"] as $key => $arItem) :?>
            <div class="card">
                <div class="card-header" id="group-1-btn-mobile">
                    <button
                        class="btn col-12 text-decoration-none text-success btn-outline-none"
                        type="button"
                        data-toggle="collapse"
                        data-target="#group-<?=$arItem['ID']?>"
                        aria-expanded="true"
                        aria-controls="collapseOne"
                    >
                        <?if (isset($arItem["PROPERTIES"]["ICON_CODE"]) && strlen($arItem["PROPERTIES"]["ICON_CODE"]["VALUE"]) > 0) :?>
                            <?=htmlspecialcharsback($arItem["PROPERTIES"]["ICON_CODE"]["VALUE"])?>
                        <?endif?>
                        <span><?=$arItem['NAME']?></span>
                    </button>
                </div>
                <div
                    id="group-<?=$arItem['ID']?>"
                    class="collapse <?if ($key == 0) :?> show<?endif?>"
                    aria-labelledby="group-1-btn-mobile"
                    data-parent="#accordion-mobile"
                >
                    <div class="card-body"><?=$arItem['PREVIEW_TEXT']?></div>
                </div>
            </div>
        <?endforeach;?>
    </div>
<?endif?>
