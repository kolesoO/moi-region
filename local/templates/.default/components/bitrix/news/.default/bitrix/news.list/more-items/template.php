<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

<?if ($arResult["ITEMS_COUNT"]) :?>
    </div></section>
    <section class="pt-5 pb-5">
        <div class="container">
            <div class="h2 mb-5">Другие новости</div>
            <div class="row mb-n4">
                <?foreach ($arResult["ITEMS"] as $arItem) :
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="col-lg-4 col-md-6 col-12 mb-4">
                        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="card text-decoration-none text-success shadow">
                            <div class="card-body">
                                <div class="h5 card-title"><?=$arItem["NAME"]?></div>
                                <div class="text-secondary">
                                    <div class="small"><?=htmlspecialcharsback($arItem['PREVIEW_TEXT'])?></div>
                                    <p class="text-dark mb-0 text-right">
                                        <small><?=$arItem["DISPLAY_ACTIVE_FROM"]?></small>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?endforeach;?>
            </div>
        </div>
    </section>
<?endif?>
