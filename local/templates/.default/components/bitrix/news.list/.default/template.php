<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?if ($arResult["ITEMS_COUNT"] > 0) :?>
    <section class="pt-5 pb-5">
        <div class="container">
            <div class="h2 mb-5">Новости</div>
            <div class="row mb-n4">
                <?foreach ($arResult["ITEMS"] as $key => $arItem) :
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="col-lg-4 col-md-6 col-12 mb-4">
                        <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="card text-decoration-none text-success shadow">
                            <div class="card-body">
                                <div class="h5 card-title"><?=$arItem["NAME"]?></div>
                                <div class="text-secondary">
                                    <div class="small mb-3"><?=$arItem["PREVIEW_TEXT"]?></div>
                                    <p class="text-dark mb-0 text-right">
                                        <small><?=$arItem['DISPLAY_ACTIVE_FROM']?></small>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?endforeach;?>
            </div>
            <div class="text-right mt-3">
                <a href="<?=$arResult["ITEMS"][0]["LIST_PAGE_URL"]?>" class="text-decoration-none text-success">Все новости</a>
            </div>
        </div>
    </section>
<?endif?>
