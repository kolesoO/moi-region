<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 */
?>
<script id="basket-total-template" type="text/html">
    <div class="card-body bg-white border shadow">
        <div class="row align-items-center">
            <div class="col-7">Стоимость:</div>
            <div class="col-5">
                <div class="h6 mb-0 text-right">{{{PRICE_WITHOUT_DISCOUNT_FORMATED}}}</div>
            </div>
        </div>
        {{#DISCOUNT_PRICE_FORMATED}}
            <div class="row align-items-center text-secondary">
                <div class="col-7">Общая скидка:</div>
                <div class="col-5">
                    <div class="h6 mb-0 text-right">
                        <s>{{{DISCOUNT_PRICE_FORMATED}}}</s>
                    </div>
                </div>
            </div>
        {{/DISCOUNT_PRICE_FORMATED}}
        <div class="row align-items-center mt-3">
            <div class="col-7">Итого:</div>
            <div class="col-5">
                <div
                        class="h5 mb-0 text-right"
                        data-entity="basket-total-price"
                >{{{PRICE_FORMATED}}}</div>
            </div>
        </div>
        <a href="{{{PATH_TO_ORDER}}}" class="btn btn-success mt-3 w-100">Оформить заказ</a>
        <a
                href="javascript:void(0)"
                class="btn btn-secondary mt-2 w-100"
                onclick="obAjax.clearBasket()"
        >Очистить корзину</a>
    </div>
    <?if ($arParams['HIDE_COUPON'] !== 'Y') :?>
        <div class="card-body bg-white border mt-3 shadow">
            <div class="form-group">
                <input
                        id="promocode-input"
                        data-entity="basket-coupon-input"
                        type="text"
                        class="form-control w-100"
                        placeholder="<?=Loc::getMessage('SBB_COUPON_ENTER')?>"
                >
            </div>
            <div class="mb-n1">
                {{#COUPON_LIST}}
                    <div class="row align-items-center mb-1">
                        <div class="col-lg-9 col-8 line-h-1">
                            <small class="{{CLASS}}">{{COUPON}} - <?=Loc::getMessage('SBB_COUPON')?> {{JS_CHECK_CODE}}</small>
                        </div>
                        <div class="col-lg-3 col-4 text-right">
                            <a
                                    href="javascript:void(0)"
                                    class="link dashed"
                                    data-entity="basket-coupon-delete"
                                    data-coupon="{{COUPON}}"
                            ><small><?=Loc::getMessage('SBB_DELETE')?></small></a>
                        </div>
                    </div>
                {{/COUPON_LIST}}
            </div>
        </div>
    <?endif?>
</script>
