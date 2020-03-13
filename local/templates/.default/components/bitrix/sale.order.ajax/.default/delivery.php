<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?if ($arResult["DELIVERY_COUNT"] > 0) :?>
    <label class="h5 mb-4">Способ доставки</label>
    <div class="row form-group">
        <?foreach ($arResult["DELIVERY"] as $delivery_id => $arDelivery):
            if ($delivery_id <= 0) continue;
            ?>
            <div class="col-6 col-12">
                <div class="custom-radio pl-4">
                    <input type="radio"
                           id="DELIVERY_ID_<?=$arDelivery["ID"]?>"
                           class="custom-control-input"
                           name="<?=$arDelivery["FIELD_NAME"]?>"
                           value="<?=$arDelivery["ID"]?>"
                           onchange="BX.saleOrderAjax.submitForm();"
                        <?if ($arDelivery["CHECKED"]=="Y") echo " checked";?>
                    >
                    <label for="DELIVERY_ID_<?=$arDelivery["ID"]?>" class="custom-control-label"><?=$arDelivery["NAME"]?></label>
                </div>
            </div>
        <?endforeach;?>
    </div>
<?endif?>
