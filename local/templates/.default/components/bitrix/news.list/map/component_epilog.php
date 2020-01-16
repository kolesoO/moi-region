<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
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

$rsAsset = \Bitrix\Main\Page\Asset::getInstance();

$rsAsset->addString('<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>');
$rsAsset->addJs(SITE_TEMPLATE_PATH . '/js/modules/ymap/script.js');
