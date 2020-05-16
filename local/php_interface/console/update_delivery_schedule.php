<?php

declare(strict_types=1);

use Bitrix\Main\Loader;

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);
define('BX_NO_ACCELERATOR_RESET', true);
define('CHK_EVENT', true);
define('BX_WITH_ON_AFTER_EPILOG', true);

$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/../../../';

require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

Loader::includeModule('iblock');

$class = CBitrixComponent::includeComponentClass('kDevelop:schedule');

/** @var Schedule $componentInstance */
$componentInstance = new $class();

$componentInstance->arParams = $componentInstance->onPrepareComponentParams(['IBLOCK_ID' => IBLOCK_DELIVERY_SCHEDULE]);
$data = $componentInstance->getData(
    [
        'CODE' => 'general',
        'ACTIVE' => 'Y',
    ],
    ['ID', 'IBLOCK_ID']
);

if (isset($data['ID'])) {
    if (
        strlen($data['PROPERTIES']['START_NEXT_DELIVERY']['VALUE']) > 0
        && strlen($data['PROPERTIES']['END_NEXT_DELIVERY']['VALUE']) > 0
    ) {
        $curDeliveryStartDate = new DateTime($data['PROPERTIES']['START_DELIVERY']['VALUE']);
        $curDeliveryEndDate = new DateTime($data['PROPERTIES']['END_DELIVERY']['VALUE']);
        $nextDeliveryStartDate = new DateTime($data['PROPERTIES']['START_NEXT_DELIVERY']['VALUE']);
        $nextDeliveryEndDate = new DateTime($data['PROPERTIES']['END_NEXT_DELIVERY']['VALUE']);

        CIBlockElement::SetPropertyValuesEx(
            $data['ID'],
            IBLOCK_DELIVERY_SCHEDULE,
            [
                'START_DELIVERY' => $data['PROPERTIES']['START_NEXT_DELIVERY']['VALUE'],
                'END_DELIVERY' => $data['PROPERTIES']['END_NEXT_DELIVERY']['VALUE'],
                'START_NEXT_DELIVERY' => date(
                    'd.m.Y H:i:s',
                    strtotime($data['PROPERTIES']['START_NEXT_DELIVERY']['VALUE'] . ' + ' . $nextDeliveryStartDate->diff($curDeliveryStartDate)->days . ' days')
                ),
                'END_NEXT_DELIVERY' => date(
                    'd.m.Y H:i:s',
                    strtotime($data['PROPERTIES']['END_NEXT_DELIVERY']['VALUE'] . ' + ' . $nextDeliveryEndDate->diff($curDeliveryEndDate)->days . ' days')
                ),
            ]
        );
    }
}
