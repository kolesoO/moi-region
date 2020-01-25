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
$hasResize = is_array($arParams["IMAGE_SIZE"]);
$arResult["ITEMS_COUNT"] = count($arResult["ITEMS"]);

foreach ($arResult["ITEMS"] as &$arItem) {
    if (!is_array($arItem["PREVIEW_PICTURE"])) {
        $arItem["PREVIEW_PICTURE"]["SRC"] = SITE_TEMPLATE_PATH . '/images/no-image.png';
        continue;
    }
    if ($hasResize) {
        $thumb = \CFile::ResizeImageGet(
            $arItem["PREVIEW_PICTURE"],
            ["width" => $arParams["IMAGE_SIZE"]["WIDTH"], "height" => $arParams["IMAGE_SIZE"]["HEIGHT"]],
            BX_RESIZE_IMAGE_PROPORTIONAL,
            true
        );
        if ($thumb["src"]) {
            $arItem["PREVIEW_PICTURE"]["SRC"] = $thumb["src"];
        }
    }
}
unset($arItem);

$cp = $this->__component;
if (is_object($cp)) {
    $cp->SetResultCacheKeys(["ITEMS_COUNT"]);
}
