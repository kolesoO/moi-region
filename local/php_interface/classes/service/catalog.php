<?php

declare(strict_types=1);

namespace kDevelop\Service;

/**
 * Class Order
 */
class Catalog
{
    protected const G_CAT_MEASURE = 3; //г

    protected const KG_CAT_MEASURE = 4; //кг

    /**
     * @param int $measureId
     * @param float $weight
     * @param float $price
     * @return array
     */
    public static function getPriceByWeight(int $measureId, float $weight, float $price): array
    {
        if ($weight > 0) {
            if ($measureId === self::KG_CAT_MEASURE) {
                $price = $price * $weight/1000;
            } elseif ($measureId === self::G_CAT_MEASURE) {
                $price = $price * $weight;
            }
        }

        return [
            'value' => $price,
            'formatted' => CurrencyFormat($price, 'RUB'),
        ];
    }
}
