<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?if ($arResult["SECTIONS_COUNT"] > 0) :?>
    <?foreach ($arResult["SECTIONS"] as $key => $section) :
        $class = '';
        if ($key < $arResult["SECTIONS_COUNT"] - 1) {
            $class = 'mb-2';
        }
        ?>
        <div class="<?=$class?>">
            <a href="<?=$section['SECTION_PAGE_URL']?>" class="text-white text-decoration-none hover"><?=$section["NAME"]?></a>
        </div>
    <?endforeach;?>
<?endif;?>
