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

$this->setFrameMode(true);

$arResult["ITEMS_COUNT"] = count($arResult["ITEMS"]);
$hasResize = is_array($arParams["PREVIEW_IMAGE_SIZE"]) || is_array($arParams["DETAIL_IMAGE_SIZE"]);

if ($hasResize) {
    foreach ($arResult["ITEMS"] as &$arItem) {
        if (is_array($arParams["DETAIL_IMAGE_SIZE"])) {
            $thumb = \CFile::ResizeImageGet(
                $arItem["PREVIEW_PICTURE"],
                [
                    "width" => $arParams["DETAIL_IMAGE_SIZE"]["WIDTH"],
                    "height" => $arParams["DETAIL_IMAGE_SIZE"]["HEIGHT"]
                ],
                BX_RESIZE_IMAGE_PROPORTIONAL,
                true
            );
            if ($thumb["src"]) {
                $arItem["PREVIEW_PICTURE"]["SRC"] = $thumb["src"];
            }
        }
        if (is_array($arParams["PREVIEW_IMAGE_SIZE"])) {
            $thumb = \CFile::ResizeImageGet(
                $arItem["PREVIEW_PICTURE"],
                [
                    "width" => $arParams["PREVIEW_IMAGE_SIZE"]["WIDTH"],
                    "height" => $arParams["PREVIEW_IMAGE_SIZE"]["HEIGHT"]
                ],
                BX_RESIZE_IMAGE_PROPORTIONAL,
                true
            );
            $arItem["PREVIEW_PICTURE"]["THUMB"] = isset($thumb["src"]) ? $thumb["src"] : $arItem["PREVIEW_PICTURE"]["SRC"];
        }
    }
    unset($arItem);
}

$cp = $this->__component;
if (is_object($cp)) {
    $cp->SetResultCacheKeys(["ITEMS_COUNT"]);
}
