<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle('Фотогаллерея');

/**
 * @global $rsAsset
 */
$rsAsset->addCss(SITE_TEMPLATE_PATH.'/libs/baguetteBox/1.10.0/baguetteBox.min.css');
$rsAsset->addCss(SITE_TEMPLATE_PATH.'/css/gallery.css');
$rsAsset->addJs(SITE_TEMPLATE_PATH.'/libs/baguetteBox/1.10.0/baguetteBox.min.js');
?>

<div class="gallery-block compact-gallery js-compact-gallery">
    <div class="row no-gutters">
        <div class="col-md-6 col-lg-4 item zoom-on-hover">
            <a class="lightbox" href="<?=SITE_TEMPLATE_PATH?>/images/no-image.png">
                <img class="img-fluid image" src="<?=SITE_TEMPLATE_PATH?>/images/no-image.png">
                <span class="description">
                            <span class="description-heading">Lorem Ipsum</span>
                            <span class="description-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna.Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                        </span>
            </a>
        </div>
        <div class="col-md-6 col-lg-4 item zoom-on-hover">
            <a class="lightbox" href="<?=SITE_TEMPLATE_PATH?>/images/no-image.png">
                <img class="img-fluid image" src="<?=SITE_TEMPLATE_PATH?>/images/no-image.png">
                <span class="description">
                            <span class="description-heading">Lorem Ipsum</span>
                            <span class="description-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna.Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                        </span>
            </a>
        </div>
        <div class="col-md-6 col-lg-4 item zoom-on-hover">
            <a class="lightbox" href="<?=SITE_TEMPLATE_PATH?>/images/no-image.png">
                <img class="img-fluid image" src="<?=SITE_TEMPLATE_PATH?>/images/no-image.png">
                <span class="description">
                            <span class="description-heading">Lorem Ipsum</span>
                            <span class="description-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna.Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                        </span>
            </a>
        </div>
        <div class="col-md-6 col-lg-4 item zoom-on-hover">
            <a class="lightbox" href="<?=SITE_TEMPLATE_PATH?>/images/no-image.png">
                <img class="img-fluid image" src="<?=SITE_TEMPLATE_PATH?>/images/no-image.png">
                <span class="description">
                            <span class="description-heading">Lorem Ipsum</span>
                            <span class="description-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna.Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                        </span>
            </a>
        </div>
        <div class="col-md-6 col-lg-4 item zoom-on-hover">
            <a class="lightbox" href="<?=SITE_TEMPLATE_PATH?>/images/no-image.png">
                <img class="img-fluid image" src="<?=SITE_TEMPLATE_PATH?>/images/no-image.png">
                <span class="description">
                            <span class="description-heading">Lorem Ipsum</span>
                            <span class="description-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna.Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                        </span>
            </a>
        </div>
        <div class="col-md-6 col-lg-4 item zoom-on-hover">
            <a class="lightbox" href="<?=SITE_TEMPLATE_PATH?>/images/no-image.png">
                <img class="img-fluid image" src="<?=SITE_TEMPLATE_PATH?>/images/no-image.png">
                <span class="description">
                            <span class="description-heading">Lorem Ipsum</span>
                            <span class="description-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna.Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                        </span>
            </a>
        </div>
    </div>
</div>

<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>
