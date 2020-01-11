<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 */

if ($arParams["SET_TITLE"] == "Y") {
	$APPLICATION->SetTitle(Loc::getMessage("SOA_ORDER_COMPLETE"));
}
?>

<div class="card-body bg-white border">
    <? if (!empty($arResult["ORDER"])): ?>
        <p>
            <?=Loc::getMessage("SOA_ORDER_SUC", array(
                "#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"]->toUserTime()->format('d.m.Y H:i'),
                "#ORDER_ID#" => $arResult["ORDER"]["ACCOUNT_NUMBER"]
            ))?>
        </p>
        <? if ($arParams['NO_PERSONAL'] !== 'Y'): ?>
            <?=Loc::getMessage('SOA_ORDER_SUC1', ['#LINK#' => $arParams['PATH_TO_PERSONAL']])?>
        <? endif; ?>
    <? else: ?>
        <p><b><?=Loc::getMessage("SOA_ERROR_ORDER")?></b></p>
        <p><?=Loc::getMessage("SOA_ERROR_ORDER_LOST", ["#ORDER_ID#" => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"])])?></p>
        <div><?=Loc::getMessage("SOA_ERROR_ORDER_LOST1")?></div>
    <? endif ?>
</div>
