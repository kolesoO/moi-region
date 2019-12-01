<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(empty($arResult)) return "";

$strReturn = '';
$count = count($arResult);
if ($count > 0) {
    $strReturn .= '<nav aria-label="breadcrumb">';
    $strReturn .= '<ol class="breadcrumb bg-light pl-0 pr-0">';

    foreach ($arResult as $key => $arItem) {
        if ($key == $count - 1) {
            $strReturn .= '<li class="breadcrumb-item active" aria-current="page">' . $arItem["TITLE"] . '</li>';
        } else {
            $strReturn .= '
                <li class="breadcrumb-item">
                    <a href="' . $arItem["LINK"] . '" class="text-success">' . $arItem["TITLE"] . '</a>
                </li>
            ';
        }
    }
    $strReturn .= '</ol>';
    $strReturn .= '</nav>';
}

return $strReturn;
