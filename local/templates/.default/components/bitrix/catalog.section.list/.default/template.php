<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));
$wrapClass = $arResult["SECTIONS_COUNT"] > $arParams["LINE_ELEMENT_COUNT"] ? ' js-slider' : '';
?>

<?if ($arResult["SECTIONS_COUNT"] > 0) :?>
    <div
            class="row clearfix<?=$wrapClass?>"
            data-autoplay="false"
            data-autoplaySpeed="5000"
            data-infinite="false"
            data-speed="1000"
            data-arrows="<?=$arParams["SLIDER_ARROWS"]?>"
            data-dots="false"
            data-slidesToShow="<?=$arParams["LINE_ELEMENT_COUNT"]?>"
            data-nextArrow="<a href='#' class='arrow-left text-success'><i class='fas fa-arrow-right'></i></a>"
            data-prevArrow="<a href='#' class='arrow-right text-success'><i class='fas fa-arrow-left'></i></a>"
    >
        <?foreach ($arResult["SECTIONS"] as $section) :
            $this->AddEditAction($arResult['SECTION']['ID'], $arResult['SECTION']['EDIT_LINK'], $strSectionEdit);
            $this->AddDeleteAction($arResult['SECTION']['ID'], $arResult['SECTION']['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
            ?>
            <div id="<?=$this->GetEditAreaId($arResult['SECTION']['ID'])?>" class="col-lg-3 col-md-6 float-left">
                <a
                        href="<?=$section['SECTION_PAGE_URL']?>"
                        class="card card-img-top image-block h-custom-250 transform-wrap bg-dark text-white p-3 border-0"
                        style="background-image: url('<?=$section["PICTURE"]["SRC"]?>')"
                >
                    <div class="card-img-overlay overflow-hidden">
                        <div class="h5 card-title"><?=$section["NAME"]?></div>
                        <p class="card-text transform-50_0"><?=htmlspecialcharsback($section['DESCRIPTION'])?></p>
                    </div>
                </a>
            </div>
        <?endforeach;?>
    </div>
<?endif;?>
