<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/** @global CMain $APPLICATION */
/** @global CMain $USER */

CJSCore::Init(array('ajax'));

$rsAsset = \Bitrix\Main\Page\Asset::getInstance();
$strCurPage = $APPLICATION->GetCurPage(false);
$isMainPage = $strCurPage == SITE_DIR;

//css
$rsAsset->addCss(SITE_TEMPLATE_PATH.'/libs/bootstrap-4.3.1-dist/css/bootstrap.min.css');
$rsAsset->addCss(SITE_TEMPLATE_PATH.'/libs/normalize-8.0.1/normalize.css');
$rsAsset->addCss(SITE_TEMPLATE_PATH.'/libs/fontawesome-free-5.11.2-web/css/all.min.css');
$rsAsset->addCss(SITE_TEMPLATE_PATH.'/css/main.css');
//end

//js
$rsAsset->addJs(SITE_TEMPLATE_PATH.'/libs/jquery-3.4.1/jquery-3.4.1.min.js');
$rsAsset->addJs(SITE_TEMPLATE_PATH.'/libs/popper/1.14.6/popper.min.js');
$rsAsset->addJs(SITE_TEMPLATE_PATH.'/libs/bootstrap-4.3.1-dist/js/bootstrap.min.js');
$rsAsset->addJs(SITE_TEMPLATE_PATH.'/libs/fontawesome-free-5.11.2-web/js/all.min.js');
$rsAsset->addJs(SITE_TEMPLATE_PATH.'/libs/slick-1.6.0/slick-1.6.0.min.js');
$rsAsset->addJs(SITE_TEMPLATE_PATH.'/js/modules/slider/script.js');
$rsAsset->addJs(SITE_TEMPLATE_PATH.'/js/ajax.js');
$rsAsset->addJs(SITE_TEMPLATE_PATH.'/js/main.js');
//end
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?$APPLICATION->ShowTitle()?></title>

    <meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="msapplication-TileColor" content="#fff">
    <meta name="theme-color" content="#fff">
    <meta name="msapplication-TileImage" content="<?=SITE_TEMPLATE_PATH?>/images/favicons/favicon-180x180.png"/>

    <!--Favicon-->
    <link rel="shortcut icon" type="image/png" href="<?=SITE_TEMPLATE_PATH?>/images/favicons/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="<?=SITE_TEMPLATE_PATH?>/images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?=SITE_TEMPLATE_PATH?>/images/favicons/favicon-96x96.png">
    <link rel="apple-touch-icon" href="<?=SITE_TEMPLATE_PATH?>/images/favicons/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=SITE_TEMPLATE_PATH?>/images/favicons/apple-touch-icon-180x180.png">
    <link rel="apple-touch-icon" sizes="192x192" href="<?=SITE_TEMPLATE_PATH?>/images/favicons/apple-touch-icon-192x192.png">
    <link rel="apple-touch-icon" sizes="270x270" href="<?=SITE_TEMPLATE_PATH?>/images/favicons/apple-touch-icon-270x270.png">
    <!--end-->

    <?$APPLICATION->ShowHead();?>
</head>
<body class="bg-light">
    <?if ($USER->IsAdmin()) :?>
        <div id="panel"><?$APPLICATION->ShowPanel();?></div>
    <?endif?>
    <?if (DEVICE_TYPE != "DESKTOP") :?>
        <div id="main-menu" class="position-absolute popup-menu">
            <?$APPLICATION->IncludeComponent(
                "bitrix:menu",
                "header-popup",
                Array(
                    "ROOT_MENU_TYPE" => "top",
                    "MAX_LEVEL" => "1",
                    "CHILD_MENU_TYPE" => "top",
                    "USE_EXT" => "Y",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "Y",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => ""
                )
            );?>
        </div>
    <?endif?>
    <div class="header sticky-top bg-success text-white pt-3 pb-3 shadow">
        <div class="container">
            <div class="row align-items-center">
                <div class="d-flex align-items-center col-lg-6 col-md-10 col-10">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:sale.basket.basket.line",
                        "",
                        [
                            "HIDE_ON_BASKET_PAGES" => "Y",
                            "PATH_TO_BASKET" => SITE_DIR."basket/",
                            "PATH_TO_ORDER" => SITE_DIR."order/",
                            "PATH_TO_PERSONAL" => SITE_DIR."personal/",
                            "PATH_TO_PROFILE" => SITE_DIR."personal/",
                            "PATH_TO_REGISTER" => SITE_DIR."login/",
                            "POSITION_FIXED" => "Y",
                            "POSITION_HORIZONTAL" => "",
                            "POSITION_VERTICAL" => "",
                            "SHOW_AUTHOR" => "N",
                            "SHOW_DELAY" => "N",
                            "SHOW_EMPTY_VALUES" => "N",
                            "SHOW_IMAGE" => "N",
                            "SHOW_NOTAVAIL" => "N",
                            "SHOW_NUM_PRODUCTS" => "Y",
                            "SHOW_PERSONAL_LINK" => "N",
                            "SHOW_PRICE" => "N",
                            "SHOW_PRODUCTS" => "Y",
                            "SHOW_SUMMARY" => "N",
                            "SHOW_TOTAL_PRICE" => "N"
                        ]
                    );?>
                    <div class="pr-4">
                        <?if ($USER->IsAuthorized()) :?>
                            <a href="#" class="text-white text-decoration-none" data-toggle="modal" data-target="#auth-reg-form">
                                <i class="fas fa-user-cog"></i>
                                <span class="d-none d-lg-inline d-md-inline">Личный кабинет</span>
                            </a>
                        <?else:?>
                            <a href="#" class="text-white text-decoration-none" data-toggle="modal" data-target="#auth-reg-form">
                                <i class="fas fa-user-cog"></i>
                                <span class="d-none d-lg-inline d-md-inline">Личный кабинет</span>
                            </a>
                        <?endif?>
                    </div>
                    <div>
                        <i class="fas fa-mobile-alt"></i>
                        <span>
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                ".default",
                                [
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => SITE_TEMPLATE_PATH . "/include/index/phone.php"
                                ],
                                false
                            );?>
                        </span>
                    </div>
                </div>
                <div class="text-right col-lg-6 col-md-2 col-2">
                    <?if (DEVICE_TYPE == "DESKTOP") :?>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "header",
                            Array(
                                "ROOT_MENU_TYPE" => "top",
                                "MAX_LEVEL" => "1",
                                "CHILD_MENU_TYPE" => "top",
                                "USE_EXT" => "Y",
                                "DELAY" => "N",
                                "ALLOW_MULTI_SELECT" => "Y",
                                "MENU_CACHE_TYPE" => "N",
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "MENU_CACHE_GET_VARS" => ""
                            )
                        );?>
                    <?else:?>
                        <a
                                href="#"
                                class="d-lg-none text-white text-decoration-none h5 js-toggle_class"
                                data-class="active"
                                data-target="#main-menu"
                        >
                            <i class="fas fa-bars"></i>
                        </a>
                    <?endif?>
                </div>
            </div>
        </div>
    </div>
    <header>
        <div class="pt-3 pb-3">
            <div class="container">
                <div class="row align-items-center">
                    <div class="d-flex col-lg-9 col-md-7 col-12 align-items-center">
                        <div class="col-lg-2 col-md-3 col-3 pl-0">
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                ".default",
                                [
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => SITE_TEMPLATE_PATH . "/include/index/logo.php"
                                ],
                                false
                            );?>
                        </div>
                        <div class="lead col-lg-6 col-md-8 col-9">
                            <span>
                                <?$APPLICATION->IncludeComponent(
                                    "bitrix:main.include",
                                    ".default",
                                    [
                                        "AREA_FILE_SHOW" => "file",
                                        "PATH" => SITE_TEMPLATE_PATH . "/include/index/slogan.php"
                                    ],
                                    false
                                );?>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-5 col-12 mt-lg-0 mt-md-0 mt-3">
                        <div class="alert alert-secondary mb-0">
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                ".default",
                                [
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => SITE_TEMPLATE_PATH . "/include/index/alert.php"
                                ],
                                false
                            );?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <?if (!$isMainPage) :?>
        <section class="pt-5 pb-5">
            <div class="container">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:breadcrumb",
                    "",
                    [
                        "START_FROM" => "0",
                        "PATH" => "",
                        "SITE_ID" => SITE_ID
                    ]
                );?>
                <h1 class="h1 mb-5 mt-0"><?$APPLICATION->ShowTitle(false)?></h1>
    <?endif?>
