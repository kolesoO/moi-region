<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

$arPrice = $arResult["PRICES"][$arParams["PRICE_CODE"][0]];

//параметры для js
$jsParams = [
    "OFFER_ID" => $arResult["ID"]
];
if ($arParams['DISPLAY_COMPARE']) {
    $jsParams['compare'] = array(
        'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
        'COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
        'COMPARE_PATH' => $arParams['COMPARE_PATH']
    );
}
///end
?>

<div class="row">
    <div class="col-lg-7 col-md-7 col-12">
        <div
                class="clearfix d-lg-block d-none js-slider"
                data-autoplay="true"
                data-autoplaySpeed="5000"
                data-infinite="false"
                data-speed="1000"
                data-arrows="true"
                data-dots="false"
                data-slidesToShow="1"
                data-nextArrow="<a href='#' class='arrow-left text-success'><i class='fas fa-arrow-right'></i></a>"
                data-prevArrow="<a href='#' class='arrow-right text-success'><i class='fas fa-arrow-left'></i></a>"
        >
            <div
                    class="image-block h-custom-300 float-left"
                    style="background-image: url('<?=$arResult['DETAIL_PICTURE']["SRC"]?>')"
            ></div>
            <?foreach ($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $filePath) :?>
                <div
                        class="image-block h-custom-300 float-left"
                        style="background-image: url('<?=$filePath?>')"
                ></div>
            <?endforeach;?>
        </div>
    </div>
    <div class="col-lg-5 col-md-5 col-12 mt-lg-0 mt-md-0 mt-3">
        <div class="card-body bg-white border">
            <?if (strlen($arResult['DETAIL_TEXT']) > 0) :?>
                <div class="card-body bg-primary border-left border-danger mb-4"><?=htmlspecialcharsback($arResult['DETAIL_TEXT'])?></div>
            <?endif?>
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-8">
                    <?if ($arPrice['DISCOUNT_DIFF'] > 0) :?>
                        <s class="text-secondary"><?=$arPrice['PRINT_VALUE']?></s>
                    <?endif?>
                    <div class="h4"> <?=$arPrice['PRINT_DISCOUNT_VALUE']?></div>
                </div>
                <div class="col-lg-6 col-md-4">
                    <input type="number" class="form-control" min="1" max="100" value="1">
                </div>
            </div>
            <div class="mt-4">
                <button
                        class="btn btn-success text-white w-100"
                        onclick="obAjax.addToBasket('<?=$arResult["ID"]?>', '<?=$arPrice["PRICE_ID"]?>', event)"
                >
                    <i class="fas fa-cart-arrow-down"></i>
                    <span><?=$arParams["MESS_BTN_ADD_TO_BASKET"]?></span>
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    BX.message({
        ECONOMY_INFO_MESSAGE: '<?=GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO2')?>',
        TITLE_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR')?>',
        TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS')?>',
        BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR')?>',
        BTN_SEND_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS')?>',
        BTN_MESSAGE_BASKET_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
        BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE')?>',
        BTN_MESSAGE_CLOSE_POPUP: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
        TITLE_SUCCESSFUL: '<?=GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK')?>',
        COMPARE_MESSAGE_OK: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK')?>',
        COMPARE_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR')?>',
        COMPARE_TITLE: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE')?>',
        BTN_MESSAGE_COMPARE_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT')?>',
        PRODUCT_GIFT_LABEL: '<?=GetMessageJS('CT_BCE_CATALOG_PRODUCT_GIFT_LABEL')?>',
        PRICE_TOTAL_PREFIX: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_PRICE_TOTAL_PREFIX')?>',
        RELATIVE_QUANTITY_MANY: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY'])?>',
        RELATIVE_QUANTITY_FEW: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW'])?>',
        SITE_ID: '<?=CUtil::JSEscape($component->getSiteId())?>',
        BTN_MESSAGE_FAVORITE_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_FAVORITE_REDIRECT')?>',
        FAVORITE_TITLE: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_FAVORITE_TITLE')?>'
    });
    var obCatalogElementDetail = new window.catalogElementDetail(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
</script>

</div></section>
