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
            $price = $price * $weight/self::getMeasureKoef($measureId);
        }

        return [
            'value' => $price,
            'formatted' => CurrencyFormat($price, 'RUB'),
        ];
    }

    /**
     * @param int $measureId
     * @return bool
     */
    public static function isWeightMeasure(int $measureId): bool
    {
        return in_array($measureId, [self::G_CAT_MEASURE, self::KG_CAT_MEASURE]);
    }

    /**
     * @param int $measureId
     * @return int
     */
    public static function getMeasureKoef(int $measureId): int
    {
        return $measureId === self::KG_CAT_MEASURE ? 1000 : 1;
    }
}
