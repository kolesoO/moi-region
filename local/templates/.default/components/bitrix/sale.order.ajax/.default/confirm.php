<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 * @var $USER
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
            <p><?=Loc::getMessage('SOA_ORDER_SUC1', ['#LINK#' => $arParams['PATH_TO_PERSONAL']])?></p>
        <? endif; ?>
        <?if ($arResult['ORDER']['STATUS_ID'] == 'N') :?>
            <?foreach ($arResult["PAYMENT"] as $payment) :
                if ($payment["PAID"] == 'Y') continue;
                if (empty($arResult['PAY_SYSTEM_LIST']) || !array_key_exists($payment["PAY_SYSTEM_ID"], $arResult['PAY_SYSTEM_LIST'])) continue;
                $arPaySystem = $arResult['PAY_SYSTEM_LIST_BY_PAYMENT_ID'][$payment["ID"]];
                if (!empty($arPaySystem["ERROR"])) echo '<span style="color:red;">' . Loc::getMessage("SOA_ORDER_PS_ERROR") . '</span>';
                ?>
                <br><br>
                <table class="sale_order_full_table">
                    <tr>
                        <td class="ps_logo">
                            <div class="pay_name"><?=Loc::getMessage("SOA_PAY") ?></div>
                            <?=CFile::ShowImage($arPaySystem["LOGOTIP"], 100, 100, "border=0\" style=\"width:100px\"", "", false) ?>
                            <div class="paysystem_name"><?=$arPaySystem["NAME"] ?></div>
                            <br/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <? if (strlen($arPaySystem["ACTION_FILE"]) > 0 && $arPaySystem["NEW_WINDOW"] == "Y" && $arPaySystem["IS_CASH"] != "Y"): ?>
                                <?
                                $orderAccountNumber = urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]));
                                $paymentAccountNumber = $payment["ACCOUNT_NUMBER"];
                                ?>
                                <script>
                                    window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=$orderAccountNumber?>&PAYMENT_ID=<?=$paymentAccountNumber?>');
                                </script>
                            <?=Loc::getMessage("SOA_PAY_LINK", array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$orderAccountNumber."&PAYMENT_ID=".$paymentAccountNumber))?>
                            <? if (CSalePdf::isPdfAvailable() && $arPaySystem['IS_AFFORD_PDF']): ?>
                            <br/>
                                <?=Loc::getMessage("SOA_PAY_PDF", array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$orderAccountNumber."&pdf=1&DOWNLOAD=Y"))?>
                            <? endif ?>
                            <? else: ?>
                                <?=$arPaySystem["BUFFERED_OUTPUT"]?>
                            <? endif ?>
                        </td>
                    </tr>
                </table>
            <?endforeach?>
        <?elseif ($arResult['ORDER']['STATUS_ID'] != 'C') :?>
            <p><?=Loc::getMessage("PAY_SYSTEM_PAYABLE_ERROR_DEFAULT")?></p>
        <?endif?>
    <?elseif (!$USER->IsAuthorized()) :?>
        <span><?=Loc::getMessage("STOF_AUTH_REQUEST")?></span>
    <? else: ?>
        <p><b><?=Loc::getMessage("SOA_ERROR_ORDER")?></b></p>
        <p><?=Loc::getMessage("SOA_ERROR_ORDER_LOST", ["#ORDER_ID#" => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"])])?></p>
        <div><?=Loc::getMessage("SOA_ERROR_ORDER_LOST1")?></div>
    <? endif ?>
</div>
