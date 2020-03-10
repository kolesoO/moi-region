<?php

declare(strict_types=1);

namespace kDevelop\Service;

class User
{
    /** @var string */
    private static $userPassword = '';

    /**
     * @param $arFields
     */
    public static function OnBeforeUserAddHandler(&$arFields)
    {
        $arFields['LOGIN'] = $arFields['EMAIL'];
        self::$userPassword = $arFields['PASSWORD'];
    }

    /**
     * @param $arParams
     */
    public static function OnSendUserInfoHandler(&$arParams)
    {
        $arParams['FIELDS']['PASSWORD'] = self::$userPassword;
    }
}
