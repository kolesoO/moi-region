<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?if ($arResult["PAY_SYSTEM_COUNT"] > 0) :?>
    <div class="card-body bg-white border mb-3 shadow">
        <label class="h5 mb-4">Способ оплаты</label>
        <div class="row">
            <?foreach ($arResult["PAY_SYSTEM"] as $arPaySystem) :?>
                <div class="col-lg-6">
                    <div class="custom-radio pl-4">
                        <input
                                id="PAY_SYSTEM_<?=$arPaySystem["ID"]?>"
                                class="custom-control-input"
                                type="radio"
                                name="PAY_SYSTEM_ID"
                                value="<?=$arPaySystem["ID"]?>"
                                onchange="BX.saleOrderAjax.submitForm();"
                            <?if ($arPaySystem["CHECKED"] == "Y" ) echo "checked";?>
                        >
                        <label for="PAY_SYSTEM_<?=$arPaySystem["ID"]?>" class="custom-control-label"><?=$arPaySystem["PSA_NAME"]?></label>
                    </div>
                </div>
            <?endforeach;?>
        </div>
    </div>
<?endif?>
