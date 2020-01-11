<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?foreach ($arResult['JS_DATA']['ORDER_PROP']['groups'] as $group) :
    if ($group['RELATED_PROPS_COUNT'] == 0) continue;?>
    <label class="h6 mb-2"><?=$group['NAME']?></label>
    <div class="mb-n3">
        <div class="row">
            <?foreach ($arResult["ORDER_PROP"]["RELATED"] as $arProp) :
                //name
                $name = $arProp["NAME"].($arProp["REQUIRED"] == "Y" ? "*" : "");
                //end
                ?>
                <div class="col-lg-6 col-12 mb-3">
                    <input
                            type="text"
                            name="<?=$arProp["FIELD_NAME"]?>"
                            class="form-control"
                            placeholder="<?=$name?>"
                            value="<?=$arProp["VALUE"]?>"
                    >
                </div>
            <?endforeach;?>
        </div>
    </div>
<?endforeach;?>
