<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle('Фотогаллерея');

/**
 * @global $rsAsset
 * @global $APPLICATION
 */
$rsAsset->addCss(SITE_TEMPLATE_PATH.'/libs/baguetteBox/1.10.0/baguetteBox.min.css');
$rsAsset->addCss(SITE_TEMPLATE_PATH.'/css/gallery.css');
$rsAsset->addJs(SITE_TEMPLATE_PATH.'/libs/baguetteBox/1.10.0/baguetteBox.min.js');

$GLOBALS['galleryFilter'] = [
    '!PREVIEW_PICTURE' => false
];
$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    'gallery',
    [
        "DISPLAY_DATE" => "Y",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "Y",
        "AJAX_MODE" => "N",
        "IBLOCK_TYPE" => "content",
        "IBLOCK_ID" => IBLOCK_CONTENT_PHOTOGALLERY,
        "NEWS_COUNT" => "20",
        "SORT_BY1" => "ID",
        "SORT_ORDER1" => "DESC",
        "SORT_BY2" => "SORT",
        "SORT_ORDER2" => "ASC",
        "FILTER_NAME" => "galleryFilter",
        "FIELD_CODE" => Array("ID", "NAME", "PREVIEW_TEXT", "CODE"),
        "PROPERTY_CODE" => Array(),
        "CHECK_DATES" => "N",
        "DETAIL_URL" => "",
        "PREVIEW_TRUNCATE_LEN" => "",
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "SET_TITLE" => "N",
        "SET_BROWSER_TITLE" => "N",
        "SET_META_KEYWORDS" => "N",
        "SET_META_DESCRIPTION" => "N",
        "SET_LAST_MODIFIED" => "Y",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN" => "N",
        "HIDE_LINK_WHEN_NO_DETAIL" => "Y",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "INCLUDE_SUBSECTIONS" => "Y",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600",
        "CACHE_FILTER" => "Y",
        "CACHE_GROUPS" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "PAGER_TITLE" => "Новости",
        "PAGER_SHOW_ALWAYS" => "Y",
        "PAGER_TEMPLATE" => "",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "Y",
        "PAGER_BASE_LINK_ENABLE" => "Y",
        "SET_STATUS_404" => "N",
        "SHOW_404" => "N",
        "MESSAGE_404" => "",
        "PAGER_BASE_LINK" => "",
        "PAGER_PARAMS_NAME" => "arrPager",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "PREVIEW_IMAGE_SIZE" => [
            "WIDTH" => 400,
            "HEIGHT" => 400
        ],
        "DETAIL_IMAGE_SIZE" => [
            "WIDTH" => 1110,
            "HEIGHT" => 700
        ]
    ]
);

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
