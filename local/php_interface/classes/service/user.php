<?php

declare(strict_types=1);

namespace kDevelop\Service;

use CUser;

class User
{
    /**
     * @param $arFields
     */
    public static function OnBeforeUserAddHandler(&$arFields)
    {
        $arFields['LOGIN'] = $arFields['EMAIL'];
    }

    /**
     * @param $arParams
     */
    public static function OnSendUserInfoHandler(&$arParams)
    {
        $user = CUser::GetByID($arParams['FIELDS']['USER_ID'])->fetch();
        $arParams['FIELDS']['PASSWORD'] = $user['PASSWORD'];
    }
}
