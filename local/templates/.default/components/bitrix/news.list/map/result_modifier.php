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
$arResult['MAP_DATA'] = [
    'general' => [
        'map_id' => 'map-' . rand(0, 10000),
        'map_zoom' => 17,
        'map_center' => [59.94087204212996, 30.30525268554495] //fix spb
    ],
    'marker_info' => [],
    'marker_props' => [],
    'marker_options' => []
];

foreach ($arResult["ITEMS"] as &$arItem) {
    if ($hasResize && is_array($arItem["PREVIEW_PICTURE"])) {
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
    $arResult['MAP_DATA']['marker_info'][] = [
        'coords' => explode(',', $arItem['PROPERTIES']['COORDS']['VALUE'])
    ];
    $arResult['MAP_DATA']['marker_props'][] = [
        'iconCaption' => $arItem['NAME']
    ];
    $arResult['MAP_DATA']['marker_options'][] = [
        'preset' => 'islands#blueCircleDotIconWithCaption',
        'balloonLayout' => [
            'image' => $arItem['PREVIEW_PICTURE'],
            'text' => $arItem['PREVIEW_TEXT']
        ],
        'balloonPanelMaxMapArea' => 0
    ];
}
unset($arItem);

$cp = $this->__component;
if (is_object($cp)) {
    $cp->SetResultCacheKeys(["ITEMS_COUNT", "MAP_DATA"]);
}
