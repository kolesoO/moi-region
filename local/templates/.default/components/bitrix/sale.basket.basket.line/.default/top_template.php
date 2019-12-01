<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/**
 * @global array $arParams
 * @global CUser $USER
 * @global CMain $APPLICATION
 * @global string $cartId
 */
$compositeStub = (isset($arResult['COMPOSITE_STUB']) && $arResult['COMPOSITE_STUB'] == 'Y');
?>
<a href="<?=($arResult['NUM_PRODUCTS'] > 0 ? $arParams['PATH_TO_BASKET'] : "#")?>" class="text-white text-decoration-none">
    <span class="icon_sup position-relative d-inline-block">
        <i class="fas fa-shopping-cart"></i>
        <?if ($arResult['NUM_PRODUCTS'] > 0) :?>
            <span class="icon_sup-number bg-danger text-white"><?=$arResult['NUM_PRODUCTS']?></span>
        <?endif?>
    </span>
    <span class="d-none d-lg-inline d-md-inline"><?=GetMessage("TSB1_YOUR_CART")?></span>
</a>
