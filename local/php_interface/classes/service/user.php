<?php

declare(strict_types=1);

namespace kDevelop\Service;

class User
{
    /**
     * @param $arFields
     */
    public static function OnBeforeUserAddHandler(&$arFields)
    {
        $arFields['LOGIN'] = $arFields['EMAIL'];
    }
}
