<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?foreach ($arResult["ITEMS"] as $key => $arItem) :
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>
    <div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="mb-3">
        <div
            class="clearfix js-slider"
            data-autoplay="true"
            data-autoplaySpeed="5000"
            data-infinite="false"
            data-speed="1000"
            data-arrows="false"
            data-dots="true"
            data-slidesToShow="1"
        >
            <?foreach ($arItem["PROPERTIES"]['IMAGES']['VALUE'] as $image) :?>
                <div class="float-left text-center">
                    <img src="<?=$image['SRC']?>" alt="">
                </div>
            <?endforeach;?>
        </div>
    </div>
<?endforeach;?>
