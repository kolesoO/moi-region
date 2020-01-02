<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?if ($arResult["SECTIONS_COUNT"] > 0) :?>
    <div class="row mb-n4">
        <?foreach ($arResult["SECTIONS"] as $arSection) :
            $this->AddEditAction(
                $arSection['ID'],
                $arSection['EDIT_LINK'],
                CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT")
            );
            $this->AddDeleteAction(
                $arSection['ID'],
                $arSection['DELETE_LINK'],
                CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE"),
                array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'))
            );
            ?>
            <div id="<?=$this->GetEditAreaId($arSection['ID'])?>" class="col-lg-3 col-md-6 col-xs-12 mb-4">
                <a
                        href="<?=$arSection["SECTION_PAGE_URL"]?>"
                        class="card card-img-top image-block h-custom-250 transform-wrap bg-dark text-white p-3"
                        style="background-image: url('<?=$arSection["PICTURE"]["SRC"]?>')"
                >
                    <div class="card-img-overlay overflow-hidden">
                        <div class="h5 card-title"><?=$arSection["NAME"]?></div>
                        <p class="card-text transform-50_0"><?=htmlspecialcharsback($arSection['DESCRIPTION'])?></p>
                    </div>
                </a>
            </div>
        <?endforeach?>
    </div>
<?endif?>
