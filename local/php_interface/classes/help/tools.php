<?
namespace kDevelop\Help;

use \Bitrix\Main\Loader;

class Tools
{
    private static $offerPrefixInUrl = "offer-";

    private static $offerSefUrlTmp = "#SKU_CODE#";

    /**
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function definders()
    {
        Loader::includeModule('iblock');
        Loader::includeModule('form');
        Loader::includeModule('highloadblock');

        $rsResult = \Bitrix\Iblock\IblockTable::getList([
            'select' => ['ID', 'IBLOCK_TYPE_ID', 'CODE']
        ]);
        while ($row = $rsResult->fetch()) {
            $CONSTANT = ToUpper(implode('_', ['IBLOCK', $row['IBLOCK_TYPE_ID'], $row['CODE']]));
            if (!defined($CONSTANT)) {
                define($CONSTANT, $row['ID']);
            }
        }

        $rsForms = \CForm::GetList($by = "s_id", $order = "desc", [], ($is_filtered = null));
        while ($arForm = $rsForms->Fetch()) {
            $CONSTANT = ToUpper(implode('_', ['WEB_FORM', $arForm['SID']]));
            if (!defined($CONSTANT)) {
                define($CONSTANT, $arForm['ID']);
            }
        }
    }

    /**
     *
     */
    public static function setDeviceType()
    {
        $obDetect = new Mobile_Detect();
        if ($obDetect->isTablet()) {
            $deviceType = "TABLET";
        } elseif ($obDetect->isMobile()) {
            $deviceType = "MOBILE";
        } else {
            $deviceType = "DESKTOP";
        }
        define('DEVICE_TYPE', $deviceType);
    }

    /**
     * @return string
     */
    public static function getOfferPrefixInUrl()
    {
        return self::$offerPrefixInUrl;
    }

    /**
     * @return string
     */
    public static function getOfferSefUrlTmp()
    {
        return self::$offerSefUrlTmp;
    }

    /**
     *
     */
    public static function defineAjax()
    {
        if (isset($_SERVER["HTTP_X_REQUESTED_WITH"])) {
            if (strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {
                include(__DIR__."/../../ajax/index.php");
            }
        }
    }
}