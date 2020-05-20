<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogProductsViewedComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

$wrapClass = $arResult["ITEMS_COUNT"] > $arParams["LINE_ELEMENT_COUNT"] ? ' js-slider' : '';
?>

<?if ($arResult["ITEMS_COUNT"] > 0) :?>
    <section class="pt-5 pb-5">
        <div class="container">
            <div class="h2 mb-5">Популярные товары</div>
            <div
                    class="row clearfix<?=$wrapClass?>"
                    data-autoplay="<?=$arParams["SLIDER_AUTOPLAY"]?>"
                    data-autoplaySpeed="5000"
                    data-infinite="false"
                    data-speed="1000"
                    data-arrows="<?=$arParams["SLIDER_ARROWS"]?>"
                    data-dots="false"
                    data-slidesToShow="<?=$arParams["LINE_ELEMENT_COUNT"]?>"
                    data-nextArrow="<a href='#' class='arrow-left text-success'><i class='fas fa-arrow-right'></i></a>"
                    data-prevArrow="<a href='#' class='arrow-right text-success'><i class='fas fa-arrow-left'></i></a>"
            >
                <?foreach ($arResult["ITEMS"] as $arItem) :
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="col-lg-3 col-md-6 float-left">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:catalog.item",
                            '',
                            [
                                "RESULT" => [
                                    "ITEM" => $arItem,
                                    "OFFER_KEY" => $arItem["OFFER_ID_SELECTED"],
                                    "OFFERS_LIST" => $arItem["OFFERS"]
                                ],
                                "PARAMS" => [
                                    'PRICE_CODE' => $arParams['PRICE_CODE'][0]
                                ]
                            ],
                            $component,
                            ['HIDE_ICONS' => 'Y']
                        );?>
                    </div>
                <?endforeach;?>
            </div>
        </div>
    </section>
<?endif?>
