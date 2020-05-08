<?php

namespace kDevelop\Service;

use Bitrix\Catalog\Product\CatalogProvider;
use \Bitrix\Sale\Result;

class CatalogProductProvider extends CatalogProvider
{
    /**
     * @param array $products
     * @return Result
     */
    public function getProductData(array $products)
    {
        global $USER;

        $return = parent::getProductData($products);
        $data = $return->getData();

        $rsItem = \CIBlockElement::GetList(
            [],
            [
                "IBLOCK_ID" => IBLOCK_CATALOG_CATALOGSKU,
                "ID" => array_keys($data["PRODUCT_DATA_LIST"])
            ],
            false,
            false,
            ["IBLOCK_ID", "ID", "CATALOG_GROUP_" . PRICE_ID]
        );
        while ($arItem = $rsItem->fetch()) {
            $priceListKey = array_keys($data["PRODUCT_DATA_LIST"][$arItem["ID"]]["PRICE_LIST"])[0];

            //general price info
            $arPrice = \CCatalogProduct::GetOptimalPrice(
                $arItem["ID"],
                $data["PRODUCT_DATA_LIST"][$arItem["ID"]]["PRICE_LIST"][$priceListKey]["QUANTITY"],
                $USER->GetUserGroupArray(),
                "N",
                [
                    [
                        "ID" => $arItem["CATALOG_PRICE_ID_" . PRICE_ID],
                        "PRICE" => $arItem["CATALOG_PRICE_" . PRICE_ID],
                        "CURRENCY" => "RUB",
                        "CATALOG_GROUP_ID" => PRICE_ID
                    ]
                ]
            );
            //end

            //update price by weight
            $discountPrice = Catalog::getPriceByWeight(
                (int) $arItem['CATALOG_MEASURE'],
                (float) $arItem['CATALOG_WEIGHT'],
                (float) $arPrice["RESULT_PRICE"]["DISCOUNT_PRICE"]
            );
            $fullPrice = Catalog::getPriceByWeight(
                (int) $arItem['CATALOG_MEASURE'],
                (float) $arItem['CATALOG_WEIGHT'],
                (float) $arPrice["RESULT_PRICE"]["BASE_PRICE"]
            );
            $arPrice['RESULT_PRICE'] = array_merge(
                $arPrice['RESULT_PRICE'],
                [
                    'DISCOUNT_PRICE' => $discountPrice['value'],
                    'BASE_PRICE' => $fullPrice['value'],
                ]
            );
            //end

            $data["PRODUCT_DATA_LIST"][$arItem["ID"]]["PRICE_LIST"][$priceListKey] = array_merge(
                $data["PRODUCT_DATA_LIST"][$arItem["ID"]]["PRICE_LIST"][$priceListKey],
                $this->getUpdatedProductData($arPrice)
            );
        }
        $return->setData($data);

        return $return;
    }

    /**
     * @param array $priceInfo
     * @return array
     */
    protected function getUpdatedProductData(array $priceInfo)
    {
        return [
            "PRODUCT_PRICE_ID" => $priceInfo["PRICE"]["ID"],
            "PRICE_TYPE_ID" => $priceInfo["RESULT_PRICE"]["PRICE_TYPE_ID"],
            "PRICE" => $priceInfo["RESULT_PRICE"]["DISCOUNT_PRICE"],
            "BASE_PRICE" => $priceInfo["RESULT_PRICE"]["BASE_PRICE"],
            "DISCOUNT_PRICE" => $priceInfo["RESULT_PRICE"]["DISCOUNT"],
            "DISCOUNT_NAME" => $priceInfo["DISCOUNT"]["NAME"],
            "DISCOUNT_VALUE" => $priceInfo["RESULT_PRICE"]["DISCOUNT"],
            "NOTES" => "",
        ];
    }
}
