<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

use \Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);

$arResult["OFFER"] = $arResult["ITEM"];

//цены
//$initPrice = $arResult["OFFER"]['ITEM_PRICES'][0];
//$discountPrice = \kDevelop\Service\Catalog::getPriceByWeight(
//    (int) $arResult["OFFER"]['PRODUCT']['MEASURE'],
//    (float) $arResult["OFFER"]['PRODUCT']['WEIGHT'],
//    (float) $initPrice['PRICE']
//);
//$fullPrice = \kDevelop\Service\Catalog::getPriceByWeight(
//    (int) $arResult["OFFER"]['PRODUCT']['MEASURE'],
//    (float) $arResult["OFFER"]['PRODUCT']['WEIGHT'],
//    (float) $initPrice['BASE_PRICE']
//);
//$arResult["OFFER"]["ITEM_PRICES"][0] = array_merge(
//    $arResult["OFFER"]["ITEM_PRICES"][0],
//    [
//        'PRICE' => $discountPrice['value'],
//        'PRINT_PRICE' => $discountPrice['formatted'],
//        'BASE_PRICE' => $fullPrice['value'],
//        'PRINT_BASE_PRICE' => $fullPrice['formatted'],
//    ]
//);
//end

$cp = $this->__component;
if (is_object($cp)) {
    $cp->SetResultCacheKeys(["OFFER", "ITEM"]);
}
