<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();
$hasResizeImage = is_array($arParams["IMAGE_SIZE"]);

//detail picture
if (!is_array($arResult['DETAIL_PICTURE'])) {
    $arResult['DETAIL_PICTURE'] = [
        'SRC' => SITE_TEMPLATE_PATH . '/images/no-image.png'
    ];
} elseif ($hasResizeImage) {
    $thumb = \CFile::ResizeImageGet(
        $arResult['DETAIL_PICTURE'],
        [
            "width" => $arParams["IMAGE_SIZE"]["WIDTH"],
            "height" => $arParams["IMAGE_SIZE"]["HEIGHT"]
        ],
        BX_RESIZE_IMAGE_PROPORTIONAL,
        true
    );
    if ($thumb["src"]) {
        $arResult['DETAIL_PICTURE']["SRC"] = $thumb["src"];
    }
}
//end

//доп. картинки
if ($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"]) {
    $arPhoto = [];
    foreach ($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $fileId) {
        $thumb = \CFile::ResizeImageGet(
            CFile::GetFileArray($fileId),
            [
                "width" => $arParams["IMAGE_SIZE"]["WIDTH"],
                "height" => $arParams["IMAGE_SIZE"]["HEIGHT"]
            ],
            BX_RESIZE_IMAGE_PROPORTIONAL,
            true
        );
        if ($thumb["src"]) {
            $arPhoto[] = $thumb["src"];
        }
    }
}
$arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"] = $arPhoto;
//end

$cp = $this->__component;
if (is_object($cp)) {
    $cp->SetResultCacheKeys([]);
}
