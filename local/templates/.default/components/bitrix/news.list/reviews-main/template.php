<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?if ($arResult["ITEMS_COUNT"] > 0) :?>
    <div class="row mb-n4">
        <?foreach ($arResult["ITEMS"] as $key => $arItem) :
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            if ($key < 3) {
                $itemClass = 'col-lg-4';
            } elseif ($key < 5) {
                $itemClass = 'col-lg-6';
            } elseif ($key < 6) {
                $itemClass = 'col-lg-8';
            } else {
                $itemClass = 'col-lg-4';
            }
            ?>
            <div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="<?=$itemClass?> col-md-6 col-12 mb-4">
                <div class="card border-success">
                    <div class="card-header d-flex justify-content-between">
                        <span><?=$arItem['PROPERTIES']['AUTHOR']['VALUE']?></span>
                        <div>
                            <i class="fas fa-quote-left"></i>
                            <i class="fas fa-quote-right"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="h5 card-title"><?=$arItem['NAME']?></div>
                        <p class="card-text"><?=$arItem['PREVIEW_TEXT']?></p>
                        <p class="text-secondary text-right mb-0">
                            <small><?=$arItem['DISPLAY_ACTIVE_FROM']?></small>
                        </p>
                    </div>
                </div>
            </div>
        <?endforeach;?>
    </div>
<?endif?>
