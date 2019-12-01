<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle('Главная');

/**
 * @global $rsAsset
 */
$rsAsset->addCss(SITE_TEMPLATE_PATH.'/libs/baguetteBox/1.10.0/baguetteBox.min.css');
$rsAsset->addCss(SITE_TEMPLATE_PATH.'/css/gallery.css');
$rsAsset->addJs(SITE_TEMPLATE_PATH.'/libs/baguetteBox/1.10.0/baguetteBox.min.js');
?>

<section class="bg-dark text-light pt-5 pb-5">
    <div class="container pt-lg-5 pb-lg-5 pt-md-5 pb-md-5 pt-0 pb-0">
        <h1 class="h1 mb-5 mt-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit</h1>
        <div class="row justify-content-between">
            <div class="col-lg-6 col-md-7 col-12">
                <div class="h3">Lorem ipsum dolor sit amet</div>
                <p class="mb-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                <div class="h3">Lorem ipsum dolor sit amet</div>
                <p class="mb-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                <div class="h3">Lorem ipsum dolor sit amet</div>
                <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
            </div>
            <div class="col-lg-4 col-md-4 col-12 mt-lg-0 mt-md-0 mt-5">
                <div class="d-flex align-items-center mb-5">
                    <div class="h1 mb-0 mr-3 col-2 pl-0 pr-0">
                        <i class="fab fa-pagelines text-success"></i>
                    </div>
                    <div>
                        <div class="h5">Lorem ipsum</div>
                        <span>Lorem ipsum dolor sit amet</span>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-5">
                    <div class="h1 mb-0 mr-3 col-2 pl-0 pr-0">
                        <i class="fas fa-pepper-hot text-warning"></i>
                    </div>
                    <div>
                        <div class="h5">Lorem ipsum</div>
                        <span>Lorem ipsum dolor sit amet</span>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="h1 mb-0 mr-3 col-2 pl-0 pr-0">
                        <i class="fas fa-leaf text-success"></i>
                    </div>
                    <div>
                        <div class="h5">Lorem ipsum</div>
                        <span>Lorem ipsum dolor sit amet</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="pt-5 pb-5">
    <div class="container">
        <div class="h2 mb-5">Lorem ipsum dolor sit amet, consectetur</div>
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <a href="#" class="card card-img-top h-custom-250 transform-wrap bg-dark text-white p-3">
                    <div class="card-img-overlay overflow-hidden">
                        <div class="h5 card-title">Catalog section</div>
                        <p class="card-text transform-50_0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 mt-lg-0 mt-md-0 mt-4">
                <a href="#" class="card card-img-top h-custom-250 transform-wrap bg-dark text-white p-3">
                    <div class="card-img-overlay overflow-hidden">
                        <div class="h5 card-title">Catalog section</div>
                        <p class="card-text transform-50_0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 mt-lg-0 mt-4">
                <a href="#" class="card card-img-top h-custom-250 transform-wrap bg-dark text-white p-3">
                    <div class="card-img-overlay overflow-hidden">
                        <div class="h5 card-title">Catalog section</div>
                        <p class="card-text transform-50_0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 mt-lg-0 mt-4">
                <a href="#" class="card card-img-top h-custom-250 transform-wrap bg-dark text-white p-3">
                    <div class="card-img-overlay overflow-hidden">
                        <div class="h5 card-title">Catalog section</div>
                        <p class="card-text transform-50_0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
<section class="pt-5 pb-5">
    <div class="container">
        <div class="h2 mb-5">Lorem ipsum dolor sit amet, consectetur</div>
        <div
            class="clearfix d-lg-block d-none js-slider"
            data-autoplay="false"
            data-autoplaySpeed="5000"
            data-infinite="false"
            data-speed="1000"
            data-arrows="true"
            data-dots="false"
            data-slidesToShow="4"
            data-nextArrow="<a href='#' class='arrow-left text-success'><i class='fas fa-arrow-right'></i></a>"
            data-prevArrow="<a href='#' class='arrow-right text-success'><i class='fas fa-arrow-left'></i></a>"
        >
            <div class="col-lg-3 col-md-6 col-12 float-left">
                <div class="card shadow">
                    <a href="#" class="card-img-top image-block h-custom-250 bg-dark" style="background-image: url('<?=SITE_TEMPLATE_PATH?>/images/no-image.png')"></a>
                    <div class="card-body">
                        <a href="#" class="h5 card-title text-success">Product title</a>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                        <div class="text-right">
                            <a href="#" class="btn btn-success text-white">
                                <i class="fas fa-cart-arrow-down"></i>
                                <span>Add to cart</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12 float-left">
                <div class="card shadow">
                    <a href="#" class="card-img-top image-block h-custom-250 bg-dark" style="background-image: url('<?=SITE_TEMPLATE_PATH?>/images/no-image.png')"></a>
                    <div class="card-body">
                        <a href="#" class="h5 card-title text-success">Product title</a>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                        <div class="text-right">
                            <a href="#" class="btn btn-success text-white">
                                <i class="fas fa-cart-arrow-down"></i>
                                <span>Add to cart</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12 float-left">
                <div class="card shadow">
                    <a href="#" class="card-img-top image-block h-custom-250 bg-dark" style="background-image: url('<?=SITE_TEMPLATE_PATH?>/images/no-image.png')"></a>
                    <div class="card-body">
                        <a href="#" class="h5 card-title text-success">Product title</a>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                        <div class="text-right">
                            <a href="#" class="btn btn-success text-white">
                                <i class="fas fa-cart-arrow-down"></i>
                                <span>Add to cart</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12 float-left">
                <div class="card shadow">
                    <a href="#" class="card-img-top image-block h-custom-250 bg-dark" style="background-image: url('<?=SITE_TEMPLATE_PATH?>/images/no-image.png')"></a>
                    <div class="card-body">
                        <a href="#" class="h5 card-title text-success">Product title</a>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                        <div class="text-right">
                            <a href="#" class="btn btn-success text-white">
                                <i class="fas fa-cart-arrow-down"></i>
                                <span>Add to cart</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12 float-left">
                <div class="card shadow">
                    <a href="#" class="card-img-top image-block h-custom-250 bg-dark" style="background-image: url('<?=SITE_TEMPLATE_PATH?>/images/no-image.png')"></a>
                    <div class="card-body">
                        <a href="#" class="h5 card-title text-success">Product title</a>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                        <div class="text-right">
                            <a href="#" class="btn btn-success text-white">
                                <i class="fas fa-cart-arrow-down"></i>
                                <span>Add to cart</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="clearfix d-lg-none d-md-block d-none js-slider"
            data-autoplay="true"
            data-autoplaySpeed="5000"
            data-infinite="false"
            data-speed="1000"
            data-arrows="false"
            data-dots="false"
            data-slidesToShow="2"
        >
            <div class="col-lg-3 col-md-6 col-12 float-left">
                <div class="card shadow">
                    <a href="#" class="card-img-top image-block h-custom-250 bg-dark" style="background-image: url('<?=SITE_TEMPLATE_PATH?>/images/no-image.png')"></a>
                    <div class="card-body">
                        <div class="h5 card-title">Product title</div>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                        <div class="text-right">
                            <a href="#" class="btn btn-success">See more</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12 float-left">
                <div class="card shadow">
                    <a href="#" class="card-img-top image-block h-custom-250 bg-dark" style="background-image: url('<?=SITE_TEMPLATE_PATH?>/images/no-image.png')"></a>
                    <div class="card-body">
                        <div class="h5 card-title">Product title</div>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                        <div class="text-right">
                            <a href="#" class="btn btn-success">See more</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12 float-left">
                <div class="card shadow">
                    <a href="#" class="card-img-top image-block h-custom-250 bg-dark" style="background-image: url('<?=SITE_TEMPLATE_PATH?>/images/no-image.png')"></a>
                    <div class="card-body">
                        <div class="h5 card-title">Product title</div>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                        <div class="text-right">
                            <a href="#" class="btn btn-success">See more</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12 float-left">
                <div class="card shadow">
                    <a href="#" class="card-img-top image-block h-custom-250 bg-dark" style="background-image: url('<?=SITE_TEMPLATE_PATH?>/images/no-image.png')"></a>
                    <div class="card-body">
                        <div class="h5 card-title">Product title</div>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                        <div class="text-right">
                            <a href="#" class="btn btn-success">See more</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12 float-left">
                <div class="card shadow">
                    <a href="#" class="card-img-top image-block h-custom-250 bg-dark" style="background-image: url('<?=SITE_TEMPLATE_PATH?>/images/no-image.png')"></a>
                    <div class="card-body">
                        <div class="h5 card-title">Product title</div>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                        <div class="text-right">
                            <a href="#" class="btn btn-success">See more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="clearfix d-lg-none d-md-none js-slider"
            data-autoplay="true"
            data-autoplaySpeed="5000"
            data-infinite="false"
            data-speed="1000"
            data-arrows="false"
            data-dots="false"
            data-slidesToShow="1"
        >
            <div class="col-lg-3 col-md-6 col-12 float-left">
                <div class="card shadow">
                    <a href="#" class="card-img-top image-block h-custom-250 bg-dark" style="background-image: url('<?=SITE_TEMPLATE_PATH?>/images/no-image.png')"></a>
                    <div class="card-body">
                        <div class="h5 card-title">Product title</div>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                        <div class="text-right">
                            <a href="#" class="btn btn-success">See more</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12 float-left">
                <div class="card shadow">
                    <a href="#" class="card-img-top image-block h-custom-250 bg-dark" style="background-image: url('<?=SITE_TEMPLATE_PATH?>/images/no-image.png')"></a>
                    <div class="card-body">
                        <div class="h5 card-title">Product title</div>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                        <div class="text-right">
                            <a href="#" class="btn btn-success">See more</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12 float-left">
                <div class="card shadow">
                    <a href="#" class="card-img-top image-block h-custom-250 bg-dark" style="background-image: url('<?=SITE_TEMPLATE_PATH?>/images/no-image.png')"></a>
                    <div class="card-body">
                        <div class="h5 card-title">Product title</div>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                        <div class="text-right">
                            <a href="#" class="btn btn-success">See more</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12 float-left">
                <div class="card shadow">
                    <a href="#" class="card-img-top image-block h-custom-250 bg-dark" style="background-image: url('<?=SITE_TEMPLATE_PATH?>/images/no-image.png')"></a>
                    <div class="card-body">
                        <div class="h5 card-title">Product title</div>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                        <div class="text-right">
                            <a href="#" class="btn btn-success">See more</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12 float-left">
                <div class="card shadow">
                    <a href="#" class="card-img-top image-block h-custom-250 bg-dark" style="background-image: url('<?=SITE_TEMPLATE_PATH?>/images/no-image.png')"></a>
                    <div class="card-body">
                        <div class="h5 card-title">Product title</div>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                        <div class="text-right">
                            <a href="#" class="btn btn-success">See more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="pt-5 pb-5">
    <div class="container">
        <div class="h2 mb-5">Lorem ipsum dolor sit amet, consectetur</div>
        <div class="row mb-n4">
            <div class="col-lg-4 col-md-6 col-12 mb-4">
                <div class="card border-success">
                    <div class="card-header d-flex justify-content-between">
                        <span>Header</span>
                        <div>
                            <i class="fas fa-quote-left"></i>
                            <i class="fas fa-quote-right"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="h5 card-title">Primary card title</div>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <p class="text-secondary text-right mb-0">
                            <small>01.01.2019</small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12 mb-4">
                <div class="card border-success">
                    <div class="card-header d-flex justify-content-between">
                        <span>Header</span>
                        <div>
                            <i class="fas fa-quote-left"></i>
                            <i class="fas fa-quote-right"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="h5 card-title">Primary card title</div>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <p class="text-secondary text-right mb-0">
                            <small>01.01.2019</small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12 mb-4">
                <div class="card border-success">
                    <div class="card-header d-flex justify-content-between">
                        <span>Header</span>
                        <div>
                            <i class="fas fa-quote-left"></i>
                            <i class="fas fa-quote-right"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="h5 card-title">Primary card title</div>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <p class="text-secondary text-right mb-0">
                            <small>01.01.2019</small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12 mb-4">
                <div class="card border-success">
                    <div class="card-header d-flex justify-content-between">
                        <span>Header</span>
                        <div>
                            <i class="fas fa-quote-left"></i>
                            <i class="fas fa-quote-right"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="h5 card-title">Primary card title</div>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <p class="text-secondary text-right mb-0">
                            <small>01.01.2019</small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12 mb-4">
                <div class="card border-success">
                    <div class="card-header d-flex justify-content-between">
                        <span>Header</span>
                        <div>
                            <i class="fas fa-quote-left"></i>
                            <i class="fas fa-quote-right"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="h5 card-title">Primary card title</div>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <p class="text-secondary text-right mb-0">
                            <small>01.01.2019</small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-6 col-12 mb-4">
                <div class="card border-success">
                    <div class="card-header d-flex justify-content-between">
                        <span>Header</span>
                        <div>
                            <i class="fas fa-quote-left"></i>
                            <i class="fas fa-quote-right"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="h5 card-title">Primary card title</div>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <p class="text-secondary text-right mb-0">
                            <small>01.01.2019</small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12 mb-4">
                <div class="card border-success">
                    <div class="card-header d-flex justify-content-between">
                        <span>Header</span>
                        <div>
                            <i class="fas fa-quote-left"></i>
                            <i class="fas fa-quote-right"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="h5 card-title">Primary card title</div>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <p class="text-secondary text-right mb-0">
                            <small>01.01.2019</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="pt-5 pb-5">
    <div class="container">
        <div class="h2 mb-5">Lorem ipsum dolor sit amet, consectetur</div>
        <div id="accordion" class="row d-lg-flex d-md-flex d-none">
            <div class="col-lg-4 col-md-4">
                <div class="list-group">
                    <a
                        href="#group-1"
                        class="list-group-item text-decoration-none text-success bg-hover-success text-hover-white"
                        data-toggle="collapse"
                        role="button"
                        aria-expanded="false"
                        aria-controls="collapseExample"
                    >
                        <i class="fas fa-shopping-basket mr-2"></i>
                        <span>Lorem ipsum dolor</span>
                    </a>
                    <a
                        href="#group-2"
                        class="list-group-item text-decoration-none text-success bg-hover-success text-hover-white"
                        data-toggle="collapse"
                        role="button"
                        aria-expanded="false"
                        aria-controls="collapseExample"
                    >
                        <i class="fas fa-shopping-basket mr-2"></i>
                        <span>Lorem ipsum dolor</span>
                    </a>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div id="group-1" data-parent="#accordion" class="collapse show">
                    <div class="card card-body shadow">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                        <ul>
                            <li>Lorem ipsum dolor sit amet</li>
                            <li>Lorem ipsum dolor sit amet</li>
                            <li>Lorem ipsum dolor sit amet</li>
                        </ul>
                    </div>
                </div>
                <div id="group-2" data-parent="#accordion" class="collapse">
                    <div class="card card-body shadow">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                        <ul>
                            <li>Lorem ipsum dolor sit amet</li>
                            <li>Lorem ipsum dolor sit amet</li>
                            <li>Lorem ipsum dolor sit amet</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- only for mobile -->
        <div id="accordion-mobile" class="accordion d-lg-none d-md-none">
            <div class="card">
                <div class="card-header" id="group-1-btn-mobile">
                    <button
                        class="btn col-12 text-decoration-none text-success btn-outline-none"
                        type="button"
                        data-toggle="collapse"
                        data-target="#group-1-text-mobile"
                        aria-expanded="true"
                        aria-controls="collapseOne"
                    >
                        <i class="fas fa-shopping-basket mr-2"></i>
                        <span>Lorem ipsum dolor</span>
                    </button>
                </div>
                <div
                    id="group-1-text-mobile"
                    class="collapse show"
                    aria-labelledby="group-1-btn-mobile"
                    data-parent="#accordion-mobile"
                >
                    <div class="card-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                        <ul>
                            <li>Lorem ipsum dolor sit amet</li>
                            <li>Lorem ipsum dolor sit amet</li>
                            <li>Lorem ipsum dolor sit amet</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="group-2-btn-mobile">
                    <button
                        class="btn col-12 text-decoration-none text-success"
                        type="button"
                        data-toggle="collapse"
                        data-target="#group-2-text-mobile"
                        aria-expanded="true"
                        aria-controls="collapseOne"
                    >
                        <i class="fas fa-shopping-basket mr-2"></i>
                        <span>Lorem ipsum dolor</span>
                    </button>
                </div>
                <div
                    id="group-2-text-mobile"
                    class="collapse"
                    aria-labelledby="group-2-btn-mobile"
                    data-parent="#accordion-mobile"
                >
                    <div class="card-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                        <ul>
                            <li>Lorem ipsum dolor sit amet</li>
                            <li>Lorem ipsum dolor sit amet</li>
                            <li>Lorem ipsum dolor sit amet</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- end -->
    </div>
</section>
<section class="pt-5 pb-5">
    <div class="container">
        <div class="h2 mb-5">Lorem ipsum dolor sit amet, consectetur</div>
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
            </div>
        </div>
    </div>
</section>
<section class="pt-5 pb-5">
    <div class="container">
        <div class="h2 mb-5">Lorem ipsum dolor sit amet, consectetur</div>
        <div class="row mb-n4">
            <div class="col-lg-4 col-md-6 col-12 mb-4">
                <a href="#" class="card text-decoration-none text-success shadow">
                    <div class="card-body">
                        <div class="h5 card-title">Lorem ipsum dolor</div>
                        <div class="text-secondary">
                            <p><small>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</small></p>
                            <p class="text-dark mb-0 text-right"><small>01.01.2019</small></p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 col-12 mb-4">
                <a href="#" class="card text-decoration-none text-success shadow">
                    <div class="card-body">
                        <div class="h5 card-title">Lorem ipsum dolor</div>
                        <div class="text-secondary">
                            <p><small>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</small></p>
                            <p class="text-dark mb-0 text-right"><small>01.01.2019</small></p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 col-12 mb-4">
                <a href="#" class="card text-decoration-none text-success shadow">
                    <div class="card-body">
                        <div class="h5 card-title">Lorem ipsum dolor</div>
                        <div class="text-secondary">
                            <p><small>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</small></p>
                            <p class="text-dark mb-0 text-right"><small>01.01.2019</small></p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="text-right mt-3">
            <a href="#" class="text-decoration-none text-success">See all</a>
        </div>
    </div>
</section>

<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>
