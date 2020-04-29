<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');

/**
 * @global $rsAsset
 * @global $APPLICATION
 */

$APPLICATION->SetTitle('Политика конфиденциальности');
$APPLICATION->SetPageProperty('description', '');
$APPLICATION->SetPageProperty('keywords', '');

$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    ".default",
    [
        "AREA_FILE_SHOW" => "file",
        "PATH" => SITE_TEMPLATE_PATH . "/include/policy.php"
    ],
    false
);

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
