<?php

declare(strict_types=1);

use Bitrix\Catalog\MeasureRatioTable;
use Bitrix\Catalog\Model\Product;
use Bitrix\Iblock\ElementTable;
use Bitrix\Main\Loader;
use kDevelop\Service\Catalog;

$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/../../../';

require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

Loader::includeModule('catalog');

$rs = ElementTable::getList([
    'filter' => ['IBLOCK_ID' => IBLOCK_1C_CATALOG_CATALOG],
    'select' => ['ID', 'NAME']
]);
while($item = $rs->fetch()) {
    $ratio = MeasureRatioTable::getList([
        'filter' => ['PRODUCT_ID' => $item['ID']]
    ])->fetch();

    if (!$ratio) continue;

    $product = Product::getList([
        'filter' => ['ID' => $item['ID']]
    ])->fetch();
    $product['WEIGHT'] = (float) $product['WEIGHT'];
    $product['MEASURE'] = (int) $product['MEASURE'];

    if ($product['WEIGHT'] == 0 || !Catalog::isWeightMeasure($product['MEASURE'])) continue;

    $newRatio = $product['WEIGHT'] / Catalog::getMeasureKoef($product['MEASURE']);

    MeasureRatioTable::update($ratio['ID'], ['RATIO' => $newRatio]);

    echo $item['NAME'] . ' updated' . PHP_EOL;
}
