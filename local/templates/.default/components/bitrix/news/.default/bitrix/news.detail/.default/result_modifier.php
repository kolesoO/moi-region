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

if ($hasResize && is_array($arResult["DETAIL_PICTURE"])) {
    $thumb = \CFile::ResizeImageGet(
        $arResult["DETAIL_PICTURE"],
        [
            "width" => $arParams["IMAGE_SIZE"]["WIDTH"],
            "height" => $arParams["IMAGE_SIZE"]["HEIGHT"]
        ],
        BX_RESIZE_IMAGE_PROPORTIONAL,
        true
    );
    if ($thumb["src"]) {
        $arResult["DETAIL_PICTURE"]["SRC"] = $thumb["src"];
    }
}
