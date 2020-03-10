<?php

declare(strict_types=1);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->IncludeComponent(
    "bitrix:system.auth.forgotpasswd",
    "",
    Array(),
    false
);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
