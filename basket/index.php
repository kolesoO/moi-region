<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');

/**
 * @global $rsAsset
 * @global $APPLICATION
 */

$APPLICATION->SetTitle('Корзина');
$APPLICATION->SetPageProperty('description', '');
$APPLICATION->SetPageProperty('keywords', '');

$APPLICATION->IncludeComponent(
    "bitrix:sale.basket.basket",
    '',
    Array(
        "ACTION_VARIABLE" => "action",
        "AUTO_CALCULATION" => "Y",
        "TEMPLATE_THEME" => "blue",
        "COLUMNS_LIST" => array(),
        "COMPONENT_TEMPLATE" => ".default",
        "COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
        "GIFTS_BLOCK_TITLE" => "Выберите один из подарков",
        "GIFTS_CONVERT_CURRENCY" => "Y",
        "GIFTS_HIDE_BLOCK_TITLE" => "N",
        "GIFTS_HIDE_NOT_AVAILABLE" => "N",
        "GIFTS_MESS_BTN_BUY" => "Выбрать",
        "GIFTS_MESS_BTN_DETAIL" => "Подробнее",
        "GIFTS_PAGE_ELEMENT_COUNT" => "4",
        "GIFTS_PRODUCT_PROPS_VARIABLE" => "prop",
        "GIFTS_PRODUCT_QUANTITY_VARIABLE" => "",
        "GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
        "GIFTS_SHOW_IMAGE" => "Y",
        "GIFTS_SHOW_NAME" => "Y",
        "GIFTS_SHOW_OLD_PRICE" => "Y",
        "GIFTS_TEXT_LABEL_GIFT" => "Подарок",
        "GIFTS_PLACE" => "BOTTOM",
        "HIDE_COUPON" => "N",
        "OFFERS_PROPS" => array("SIZES_SHOES", "SIZES_CLOTHES"),
        "PATH_TO_ORDER" => "/order/",
        "EMPTY_REDIRECT_PATH" => "/",
        "PRICE_VAT_SHOW_VALUE" => "N",
        "QUANTITY_FLOAT" => "N",
        "SET_TITLE" => "N",
        "USE_GIFTS" => "N",
        "USE_PREPAYMENT" => "N",
        "TOTAL_BLOCK_DISPLAY" => ["bottom"],
        "SHOW_FILTER" => "N",
        "SHOW_RESTORE" => "N"
    )
);

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
