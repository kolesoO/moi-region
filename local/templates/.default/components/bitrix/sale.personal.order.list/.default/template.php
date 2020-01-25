<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main,
	Bitrix\Main\Localization\Loc,
	Bitrix\Main\Page\Asset;

Loc::loadMessages(__FILE__);

if (!empty($arResult['ERRORS']['FATAL']))
{
	foreach($arResult['ERRORS']['FATAL'] as $error)
	{
		ShowError($error);
	}
	$component = $this->__component;
	if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED]))
	{
		$APPLICATION->AuthForm('', false, false, 'N', false);
	}

}
else
{
	?>
    <?if (count($arResult['ORDERS']) > 0) :?>
        <div class="mb-n3">
            <?
            $orderHeaderStatus = null;
            foreach ($arResult['ORDERS'] as $order) :
                if ($orderHeaderStatus !== $order['ORDER']['STATUS_ID'] && $arResult['SORT_TYPE'] == 'STATUS') {
                    $orderHeaderStatus = $order['ORDER']['STATUS_ID'];
                }
                $count = count($order['BASKET_ITEMS']) % 10;
                if ($count == '1') {
                    $measure = Loc::getMessage('SPOL_TPL_GOOD');
                }
                elseif ($count >= '2' && $count <= '4') {
                    $measure = Loc::getMessage('SPOL_TPL_TWO_GOODS');
                }
                else {
                    $measure = Loc::getMessage('SPOL_TPL_GOODS');
                }
                ?>
                <div class="card card-body shadow mb-3">
                    <div class="mb-2 d-flex justify-content-between align-content-center">
                        <div class="h4 mb-0">Заказ №<?=$order['ORDER']['ACCOUNT_NUMBER']?></div>
                        <a href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_COPY"])?>" class="text-success text-decoration-none">
                            <i class="fas fa-clone"></i>
                            <span>Повторить заказ</span>
                        </a>
                    </div>
                    <div class="text-secondary">
                        <div class="small">Дата - <b><?=$order['ORDER']['DATE_INSERT']->format($arParams['ACTIVE_DATE_FORMAT'])?></b></div>
                        <div class="small">Кол-во товаров - <b><?=count($order['BASKET_ITEMS']);?> <?=$measure?></b></div>
                        <div class="small">Сумма - <b><?=$order['ORDER']['FORMATED_PRICE']?></b></div>
                        <div class="small">Статус - <b><?=$arResult['INFO']['STATUS'][$orderHeaderStatus]['NAME']?></b></div>
                    </div>
                    <div id="accordion-<?=$order['ORDER']['ACCOUNT_NUMBER']?>" class="mt-2">
                        <a
                                href="#order-detail-<?=$order['ORDER']['ACCOUNT_NUMBER']?>"
                                class="text-decoration-none text-success"
                                data-toggle="collapse"
                                role="button"
                                aria-expanded="false"
                                aria-controls="collapseExample"
                        >
                            <i class="fas fa-shopping-basket mr-1"></i>
                            <span>Список товаров</span>
                        </a>
                        <div id="order-detail-<?=$order['ORDER']['ACCOUNT_NUMBER']?>" data-parent="#accordion-<?=$order['ORDER']['ACCOUNT_NUMBER']?>" class="collapse">
                            <div class="mb-n3">
                                <div class="row border-top border-bottom pt-1 pb-1 mt-2 mb-2">
                                    <div class="col-lg-4 col-7">Товар</div>
                                    <div class="col-lg-2 col-md-4 col-4">Цена</div>
                                    <div class="col-lg-2 col-4">Количество</div>
                                    <div class="col-lg-2 col-4">Стоимость</div>
                                </div>
                                <?foreach ($order['BASKET_ITEMS'] as $item) :?>
                                    <div class="row align-items-lg-center mb-3">
                                        <div class="col-lg-4 col-7">
                                            <a href="#" class="h6 text-success text-decoration-none"><?=$item['NAME']?></a>
                                            <div class="text-secondary mt-2">
                                                <div><small>Вес:  <?=$item['WEIGHT']?></small></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-4 col-4 align-self-lg-auto align-self-center">
                                            <?if (isset($item['DISCOUNT_PRICE'])) :?>
                                                <small class="text-secondary">
                                                    <s><?=SaleFormatCurrency($item['BASE_PRICE'], $item["CURRENCY"])?></s>
                                                </small>
                                            <?endif?>
                                            <div class="h6 mb-0"><?=SaleFormatCurrency($item['PRICE'], $item["CURRENCY"])?></div>
                                        </div>
                                        <div class="col-lg-2 col-4 align-self-lg-auto align-self-center">
                                            <span><?=$item['QUANTITY']?></span>
                                        </div>
                                        <div class="col-lg-2 col-4 align-self-lg-auto align-self-center">
                                            <small class="text-secondary">
                                                <s><?=SaleFormatCurrency($item['BASE_PRICE']*floatval($item['QUANTITY']), $item['CURRENCY'])?></s>
                                            </small>
                                            <div class="h5 mb-0"><?=SaleFormatCurrency($item['PRICE']*floatval($item['QUANTITY']), $item['CURRENCY'])?></div>
                                        </div>
                                    </div>
                                <?endforeach;?>
                            </div>
                        </div>
                    </div>
                </div>
            <?endforeach;?>
        </div>
        <?=$arResult["NAV_STRING"]?>
    <?else:?>
        <div class="card card-body shadow"><?=Loc::getMEssage("SPOL_TPL_EMPTY_ORDER_LIST")?></div>
    <?endif?>

    <?
}
