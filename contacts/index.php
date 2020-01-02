<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');

/**
 * @global $rsAsset
 * @global $APPLICATION
 */

$APPLICATION->SetTitle('Контакты');
$APPLICATION->SetPageProperty('description', '');
$APPLICATION->SetPageProperty('keywords', '');

$rsAsset->addString('<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>');
$rsAsset->addJs(SITE_TEMPLATE_PATH . '/js/modules/ymap/script.js');
$rsAsset->addJs(SITE_TEMPLATE_PATH . '/js/map.js');
?>

<div class="card-body bg-white border mb-3">
    <?$APPLICATION->IncludeComponent(
        "bitrix:main.include",
        ".default",
        [
            "AREA_FILE_SHOW" => "file",
            "PATH" => SITE_TEMPLATE_PATH . "/include/contacts/text.php"
        ],
        false
    );?>
</div>
<div id="map"></div>

<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>
