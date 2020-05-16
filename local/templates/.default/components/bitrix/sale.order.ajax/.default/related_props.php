<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?foreach ($arResult['JS_DATA']['ORDER_PROP']['groups'] as $group) :
    if ($group['RELATED_PROPS_COUNT'] == 0) continue;?>
    <div class="form-group">
        <label class="h6 mb-2"><?=$group['NAME']?></label>
        <div class="mb-n3">
            <div class="row">
                <?foreach ($arResult["ORDER_PROP"]["RELATED"] as $arProp) :
                    if ($arProp['PROPS_GROUP_ID'] != $group['ID']) continue;

                    $name = $arProp["NAME"].($arProp["REQUIRED"] == "Y" ? "*" : "");
                    $class = $group['RELATED_PROPS_COUNT'] > 1 ? 'col-lg-6' : 'col-lg-12';

                    $attrs = '';

                    if ($arProp['CODE'] == 'DELIVERY_DATE') {
                        $attrs .= ' disabled';
                    }
                    ?>

                    <?if ($arProp['TYPE'] == 'CHECKBOX' || $arProp['CODE'] == 'IS_ZHK') :?>
                        <div class="<?=$class?> col-12 mb-3">
                            <div class="pl-4">
                                <input
                                        id="<?=$arProp['FIELD_ID']?>"
                                        type="checkbox"
                                        name="<?=$arProp["FIELD_NAME"]?>"
                                        class="custom-control-input"
                                        placeholder="<?=$name?>"
                                        value="Да"
                                    <?=$attrs?>
                                >
                                <label for="<?=$arProp['FIELD_ID']?>" class="custom-control-label"><?=$name?></label>
                            </div>
                        </div>
                    <?else:?>
                        <div class="<?=$class?> col-12 mb-3">
                            <input
                                    type="<?=strtolower($arProp['TYPE'])?>"
                                    name="<?=$arProp["FIELD_NAME"]?>"
                                    class="form-control"
                                    placeholder="<?=$name?>"
                                    value="<?=$arProp["VALUE"]?>"
                                <?=$attrs?>
                            >
                        </div>
                    <?endif?>

                <?endforeach;?>
            </div>
        </div>
    </div>
<?endforeach;?>
