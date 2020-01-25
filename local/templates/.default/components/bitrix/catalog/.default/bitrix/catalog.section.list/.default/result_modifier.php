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

$hasResizeImage = is_array($arParams["IMAGE_SIZE"]);

foreach ($arResult["SECTIONS"] as &$arSection) {
    if (!is_array($arSection["PICTURE"])) {
        $arSection["PICTURE"] = [
            'SRC' => SITE_TEMPLATE_PATH . '/images/no-image.png'
        ];
        continue;
    }
    if ($hasResizeImage) {
        //кеширование изображений
        $thumb = \CFile::ResizeImageGet(
            $arSection["PICTURE"],
            ["width" => $arParams["IMAGE_SIZE"]["WIDTH"], "height" => $arParams["IMAGE_SIZE"]["HEIGHT"]],
            BX_RESIZE_IMAGE_PROPORTIONAL,
            true
        );
        if ($thumb["src"]) {
            $arSection["PICTURE"]["SRC"] = $thumb["src"];
        }
        //end
    }
}
unset($arSection);
