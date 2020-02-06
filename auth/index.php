<?
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->IncludeComponent(
    "bitrix:system.auth.form",
    "auth",
    Array(
        "REGISTER_URL" => "/register/",
        "FORGOT_PASSWORD_URL" => "",
        "PROFILE_URL" => "/personal/profile/",
        "SHOW_ERRORS" => "Y"
    )
);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
