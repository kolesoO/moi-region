<?php
declare(strict_types=1);

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

//Loc::getMessage

$psTitle = 'Название PS для modulbank';

$psDescription = 'Описание еее';

$arPSCorrespondence = [
    "MERCHANT_ID" => [
        "NAME" => 'PS_MB_MERCHANT_ID',
        "DESCRIPTION" => 'Merchant Id',
        "SORT" => 100,
        "VALUE" => "",
        "TYPE" => "",
    ],
    "SECRET_KEY" => [
        "NAME" => 'PS_MB_SECRET_KEY',
        "DESCR" => 'Secret key',
        "SORT" => 200,
        "VALUE" => "",
        "TYPE" => "",
    ],
    "TEST_MODE" => [
        "NAME" => 'PS_MB_TEST_MODE',
        "DESCR" => 'Test mode',
        "SORT" => 300,
        "VALUE" => "",
        "TYPE" => "",
    ],
    "ORDER_DESCRIPTION" => [
        "NAME" => 'PS_MB_ORDER_DESCRIPTION',
        "DESCR" => 'Order description (can use #ORDER_ID#)',
        "SORT" => 400,
        "VALUE" => "",
        "TYPE" => "",
    ],
    "SUCCESS_URL" => [
        "NAME" => 'PS_MB_SUCCESS_URL',
        "DESCR" => 'Success url',
        "SORT" => 500,
        "VALUE" => "",
        "TYPE" => "",
    ],
    "FAIL_URL" => [
        "NAME" => 'PS_MB_FAIL_URL',
        "DESCR" => 'Fail url',
        "SORT" => 600,
        "VALUE" => "",
        "TYPE" => "",
    ],
];
