<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?foreach ($arResult['JS_DATA']['ORDER_PROP']['groups'] as $group) :
    if ($group['PROPS_COUNT'] == 0) continue;
    $counter = 0;
    ?>
    <div class="card-body bg-white border mb-3 shadow">
        <label class="h5 mb-4"><?=$group['NAME']?></label>
        <?foreach ($arResult["ORDER_PROP"]["USER_PROPS_N"] as $arProp) :
            if ($arProp['PROPS_GROUP_ID'] != $group['ID']) continue;
            //name
            $name = $arProp["NAME"].($arProp["REQUIRED"] == "Y" ? "*" : "");
            //end
            //type
            $type = "text";
            if ($arProp["IS_PHONE"] == "Y") {
                $type = "tel";
            } elseif ($arProp["IS_EMAIL"] == "Y") {
                $type = "email";
            }
            //end
            ?>
            <?if ($arProp["IS_LOCATION"] == "Y") :?>
                <input
                    type="hidden"
                    name="<?=$arProp["FIELD_NAME"]?>"
                    value="<?=$arProp["DEFAULT_VALUE"]?>"
                >
            <?else:
                $counter ++;?>
                <?if ($counter == 1) :?>
                    <div class="form-group">
                        <input
                                type="<?=$type?>"
                                name="<?=$arProp["FIELD_NAME"]?>"
                                class="form-control"
                                placeholder="<?=$name?>"
                                value="<?=$arProp["VALUE"]?>"
                        >
                    </div>
                <?elseif ($counter % 2 == 0) :?>
                    <div class="row mb-lg-0 mb-n3">
                    <div class="col-lg-6 col-12 mb-lg-0 mb-3">
                        <input
                                type="<?=$type?>"
                                name="<?=$arProp["FIELD_NAME"]?>"
                                class="form-control"
                                placeholder="<?=$name?>"
                                value="<?=$arProp["VALUE"]?>"
                        >
                    </div>
                <?else:?>
                    <div class="col-lg-6 col-12 mb-lg-0 mb-3">
                        <input
                                type="<?=$type?>"
                                name="<?=$arProp["FIELD_NAME"]?>"
                                class="form-control"
                                placeholder="<?=$name?>"
                                value="<?=$arProp["VALUE"]?>"
                        >
                    </div>
                    </div>
                <?endif?>
            <?endif?>
        <?endforeach;?>
    </div>
<?endforeach;?>
