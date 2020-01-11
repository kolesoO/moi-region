<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<div class="card-body bg-white border shadow">
    <div class="row align-items-center">
        <div class="col-7">Стоимость:</div>
        <div class="col-5">
            <div class="h6 mb-0 text-right"><?=$arResult["PRICE_WITHOUT_DISCOUNT"]?></div>
        </div>
    </div>
    <?if ($arResult['DISCOUNT_PRICE'] > 0) :?>
        <div class="row align-items-center text-secondary">
            <div class="col-7">Общая скидка:</div>
            <div class="col-5">
                <div class="h6 mb-0 text-right">
                    <s><?=$arResult["DISCOUNT_PRICE_FORMATED"]?></s>
                </div>
            </div>
        </div>
    <?endif?>
    <?if ($arResult['DELIVERY_PRICE'] > 0) :?>
        <div class="row align-items-center">
            <div class="col-7">Доставка:</div>
            <div class="col-5">
                <div class="h6 mb-0 text-right"><?=$arResult["DELIVERY_PRICE_FORMATED"]?></div>
            </div>
        </div>
    <?endif?>
    <div class="row align-items-center mt-3">
        <div class="col-7">Итого:</div>
        <div class="col-5">
            <div class="h5 mb-0 text-right"><?=$arResult["ORDER_TOTAL_PRICE_FORMATED"]?></div>
        </div>
    </div>
    <button
            class="btn btn-success mt-3 w-100"
            onclick="BX.saleOrderAjax.submitForm('Y');"
    >Оформить заказ</button>
</div>
