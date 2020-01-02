<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogProductsViewedComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

$arPrice = $arResult["OFFER"]["ITEM_PRICES"][0];
$arPrice['CAN_BUY'] = $arPrice['PRICE'] > 0;

//параметры для js
$jsParams = [
    "OFFER_ID" => $arResult["OFFER"]["ID"],
    "ITEM_ID" => $arResult["ITEM"]["ID"]
];
if ($arParams['DISPLAY_COMPARE']) {
    $jsParams['compare'] = $arParams["COMPARE"];
}
//end
?>

<div class="card shadow">
    <a
            href="<?=$arResult["ITEM"]["DETAIL_PAGE_URL"]?>"
            class="card-img-top image-block h-custom-250 bg-dark"
            style="background-image: url('<?=$arResult["ITEM"]['PREVIEW_PICTURE']['SRC']?>')"
    ></a>
    <div class="card-body">
        <a href="<?=$arResult["ITEM"]["DETAIL_PAGE_URL"]?>" class="h5 card-title text-success"><?=$arResult["ITEM"]["NAME"]?></a>
        <div class="card-text small mt-3 mb-3"><?=htmlspecialcharsback($arResult["ITEM"]["PREVIEW_TEXT"])?></div>
        <?if (isset($arPrice) && $arPrice['CAN_BUY'] == 'Y') :?>
            <div class="text-right">
                <?if ($arPrice['DISCOUNT'] > 0) :?>
                    <s class="text-secondary mr-2"><?=$arPrice['PRINT_PRICE']?></s>
                <?endif?>
                <a
                        href="#"
                        class="btn btn-success text-white"
                        onclick="obAjax.addToBasket('<?=$arResult["OFFER"]["ID"]?>', '<?=$arPrice["PRICE_TYPE_ID"]?>', event)"
                >
                    <i class="fas fa-cart-arrow-down"></i>
                    <span><?=$arPrice["PRINT_BASE_PRICE"]?></span>
                </a>
            </div>
        <?endif?>
    </div>
</div>
<script>
    if (typeof window.catalogElement == "function") {
        var obCatalogElement_<?=$arResult["OFFER"]["ID"]?> = new window.catalogElement(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
    }
</script>
