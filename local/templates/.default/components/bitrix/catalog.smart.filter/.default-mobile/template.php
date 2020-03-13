<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<form
        class="card-body bg-white border"
        name="<?=$arResult["FILTER_NAME"]."_form"?>?>"
        action="<?=$arResult["FORM_ACTION"]?>"
        method="get"
>
    <?if ($arParams["COMPONENT_CONTAINER_ID"]) :?>
        <input type="hidden" name="bxajaxid" value="<?=$arParams["COMPONENT_CONTAINER_ID"]?>">
    <?endif?>
    <?foreach($arResult["HIDDEN"] as $arItem):?>
        <input type="hidden" name="<?=$arItem["CONTROL_NAME"]?>" id="<?=$arItem["CONTROL_ID"]?>" value="<?=$arItem["HTML_VALUE"]?>" />
    <?endforeach;?>
    <?
    //цены
    foreach ($arResult["ITEMS"] as $key=>$arItem) :?>
        <?if (isset($arItem["PRICE"])) :
            if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
                continue;
            ?>
            <div class="form-group">
                <label class="h6"><?=GetMessage("CT_BCSF_FILTER_PRICE_TITLE")?></label>
                <div class="row">
                    <div class="col-12 mb-2">
                        <input
                                class="form-control"
                                name="<?=$arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                id="<?=$arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                                type="number"
                                placeholder="<?=GetMessage("CT_BCSF_FILTER_FROM")." ".number_format(floatval($arItem["VALUES"]["MIN"]["VALUE"]), 0, ".", " ")?>"
                                onchange="smartFilter.keyup(this)"
                                value="<?=$arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
                                min="0"
                        >
                    </div>
                    <div class="col-12">
                        <input
                                class="form-control"
                                name="<?=$arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                id="<?=$arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                                type="number"
                                placeholder="<?=GetMessage("CT_BCSF_FILTER_TO")." ".number_format(floatval($arItem["VALUES"]["MAX"]["VALUE"]), 0, ".", " ")?>"
                                onchange="smartFilter.keyup(this)"
                                value="<?=$arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
                                min="0"
                        >
                    </div>
                </div>
            </div>
            <?break;?>
        <?endif?>
    <?endforeach?>
    <?
    //остальные свойства
    foreach ($arResult["ITEMS"] as $key=>$arItem) :
        if(empty($arItem["VALUES"]) || isset($arItem["PRICE"]))
            continue;
        if ($arItem["DISPLAY_TYPE"] == "A" && ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0))
            continue;
        $arCur = current($arItem["VALUES"]);
        ?>
        <div class="form-group">
            <label class="h6"><?=$arItem["NAME"]?></label>
            <?switch ($arItem["DISPLAY_TYPE"]) {
                case "B": //числа ?>
                    <div class="row">
                        <div class="col-12 mb-2">
                            <input
                                    class="form-control"
                                    name="<?=$arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                    id="<?=$arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                                    type="text"
                                    placeholder="<?=GetMessage("CT_BCSF_FILTER_FROM")." ".number_format(floatval($arItem["VALUES"]["MIN"]["VALUE"]), 0, ".", " ")?>"
                                    value="<?=$arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
                                    onchange="smartFilter.keyup(this)"
                            >
                        </div>
                        <div class="col-12">
                            <input
                                    class="form-control"
                                    name="<?=$arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                    id="<?=$arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                                    type="text"
                                    placeholder="<?=GetMessage("CT_BCSF_FILTER_TO")." ".number_format(floatval($arItem["VALUES"]["MAX"]["VALUE"]), 0, ".", " ")?>"
                                    value="<?=$arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
                                    onchange="smartFilter.keyup(this)"
                            >
                        </div>
                    </div>
                    <?break;
                case "F": //флажки
                    $checkedItemExist = false;
                    foreach ($arItem["VALUES"] as $val => $ar) {
                        if ($ar["CHECKED"]) {
                            $checkedItemExist = true;
                            break;
                        }
                    }
                    ?>
                    <?foreach ($arItem["VALUES"] as $val => $ar) :?>
                        <div class="custom-checkbox pl-4">
                            <input
                                    type="checkbox"
                                    value="<?=$ar["HTML_VALUE"]?>"
                                    name="<?=$ar["CONTROL_NAME"]?>"
                                    id="<?=$ar["CONTROL_ID"]?>"
                                    class="custom-control-input"
                                    onclick="smartFilter.click(this)"
                                    <?if ($ar["CHECKED"]) :?> checked<?endif?>
                            >
                            <label
                                    for="<?=$ar["CONTROL_ID"]?>"
                                    class="custom-control-label"
                            >
                                <small><?=$ar["VALUE"]?></small>
                            </label>
                        </div>
                    <?endforeach?>
                    <?break;
            }?>
        </div>
    <?endforeach?>
    <div id="modef_del"<?if (!$arResult["IS_APPLIED"]) :?> style="display:none"<?endif?>>
        <a href="<?=$arResult["SEF_DEL_FILTER_URL"]?>" class="btn btn-secondary w-100"><?=GetMessage("CT_BCSF_DEL_FILTER")?></a>
    </div>
    <div id="modef" class="small"<?if(!isset($arResult["ELEMENT_COUNT"])) echo ' style="display:none"';?>>
        <span><?=GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<b id="modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</b>'));?></span>
    </div>
    <input
            class="d-none"
            type="submit"
            id="set_filter"
            name="set_filter"
            value="<?=GetMessage("CT_BCSF_SET_FILTER")?>"
    >
</form>
<script type="text/javascript">
    var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>
