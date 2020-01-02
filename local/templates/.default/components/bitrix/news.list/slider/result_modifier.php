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
    $images = [];
    foreach ($arItem["PROPERTIES"]['IMAGES']['VALUE'] as $fileId) {
        $fileInfo = \CFile::GetFileArray($fileId);
        if ($hasResize) {
            $thumb = \CFile::ResizeImageGet(
                $fileInfo,
                [
                    "width" => $arParams["IMAGE_SIZE"]["WIDTH"],
                    "height" => $arParams["IMAGE_SIZE"]["HEIGHT"]
                ],
                BX_RESIZE_IMAGE_PROPORTIONAL,
                true
            );
            if ($thumb["src"]) {
                $fileInfo["SRC"] = $thumb["src"];
            }
        }
        $images[] = $fileInfo;
    }
    $arItem["PROPERTIES"]['IMAGES']['VALUE'] = $images;
}
unset($arItem);

$cp = $this->__component;
if (is_object($cp)) {
    $cp->SetResultCacheKeys(["ITEMS_COUNT"]);
}
